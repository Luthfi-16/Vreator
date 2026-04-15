<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['template.user', 'template.category', 'template.software'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        foreach ($transactions as $transaction) {
            if ($transaction->status === 'pending') {
                $this->refreshTransactionStatus($transaction);
            }
        }

        return response()->json([
            'message' => 'Riwayat transaksi berhasil diambil.',
            'data' => TransactionResource::collection(
                Transaction::with(['template.user', 'template.category', 'template.software'])
                    ->where('user_id', $request->user()->id)
                    ->latest()
                    ->get()
            ),
        ]);
    }

    public function checkout(Request $request, Template $template)
    {
        $this->configureMidtrans();

        $existingTransaction = Transaction::where('user_id', $request->user()->id)
            ->where('template_id', $template->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existingTransaction) {
            $this->refreshTransactionStatus($existingTransaction);

            if ($existingTransaction->status === 'pending' && $existingTransaction->snap_token) {
                return response()->json([
                    'message' => 'Transaksi pending ditemukan.',
                    'data' => [
                        'transaction' => new TransactionResource(
                            $existingTransaction->load(['template.user', 'template.category', 'template.software'])
                        ),
                        'reused' => true,
                    ],
                ]);
            }
        }

        $orderId = 'ORDER-' . uniqid();
        $snapToken = Snap::getSnapToken($this->buildSnapParams($request, $template, $orderId));

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'template_id' => $template->id,
            'order_id' => $orderId,
            'total_price' => $template->price,
            'snap_token' => $snapToken,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Checkout berhasil dibuat.',
            'data' => [
                'transaction' => new TransactionResource(
                    $transaction->load(['template.user', 'template.category', 'template.software'])
                ),
                'reused' => false,
            ],
        ], 201);
    }

    public function resume(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== $request->user()->id, 403);

        $this->configureMidtrans();
        $this->refreshTransactionStatus($transaction);

        if ($transaction->status !== 'pending') {
            return response()->json([
                'message' => 'Transaksi ini sudah tidak bisa dilanjutkan.',
                'data' => [
                    'status' => $transaction->status,
                ],
            ], 422);
        }

        if (! $transaction->snap_token) {
            $transaction->update([
                'snap_token' => Snap::getSnapToken(
                    $this->buildSnapParams($request, $transaction->template, $transaction->order_id)
                ),
            ]);
        }

        return response()->json([
            'message' => 'Transaksi berhasil dilanjutkan.',
            'data' => new TransactionResource(
                $transaction->fresh()->load(['template.user', 'template.category', 'template.software'])
            ),
        ]);
    }

    private function configureMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    private function buildSnapParams(Request $request, Template $template, string $orderId): array
    {
        return [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $template->price,
            ],
            'item_details' => [[
                'id' => $template->id,
                'price' => (int) $template->price,
                'quantity' => 1,
                'name' => $template->title,
            ]],
            'customer_details' => [
                'first_name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
        ];
    }

    private function refreshTransactionStatus(Transaction $transaction): void
    {
        if ($transaction->status !== 'pending') {
            return;
        }

        try {
            $status = MidtransTransaction::status($transaction->order_id);
            $this->syncTransactionStatus($transaction, $status->transaction_status, $status->fraud_status ?? null);
        } catch (\Throwable $e) {
            // Keep local status as pending if Midtrans status cannot be fetched.
        }
    }

    private function syncTransactionStatus(Transaction $transaction, string $transactionStatus, ?string $fraudStatus = null): void
    {
        $status = match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? 'paid' : 'failed',
            'settlement' => 'paid',
            'cancel', 'deny', 'expire' => 'failed',
            default => 'pending',
        };

        $transaction->update(['status' => $status]);
    }
}
