<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;
use Throwable;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['notification']);
    }

    public function checkout(Template $template)
    {
        $this->configureMidtrans();

        $existingTransaction = Transaction::where('user_id', Auth::id())
            ->where('template_id', $template->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existingTransaction) {
            $this->refreshTransactionStatus($existingTransaction);

            if ($existingTransaction->status === 'pending' && $existingTransaction->snap_token) {
                return response()->json([
                    'snap_token' => $existingTransaction->snap_token,
                    'transaction_id' => $existingTransaction->id,
                    'reused' => true,
                ]);
            }
        }

        $orderId = 'ORDER-' . uniqid();
        $snapToken = Snap::getSnapToken($this->buildSnapParams($template, $orderId));

        // Simpan ke DB setelah snap berhasil dibuat
        Transaction::create([
            'user_id'     => Auth::id(),
            'template_id' => $template->id,
            'order_id'    => $orderId,
            'total_price' => $template->price,
            'snap_token'  => $snapToken,
            'status'      => 'pending',
        ]);

        return response()->json([
            'snap_token' => $snapToken,
            'reused' => false,
        ]);
    }

    public function index()
    {
        $transactions = Transaction::with(['template.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        foreach ($transactions as $transaction) {
            if ($transaction->status === 'pending') {
                $this->refreshTransactionStatus($transaction);
            }
        }

        return view('user.transactions-history', compact('transactions'));
    }

    public function resume(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $this->configureMidtrans();
        $this->refreshTransactionStatus($transaction);

        if ($transaction->status !== 'pending') {
            return response()->json([
                'message' => 'Transaksi ini sudah tidak bisa dilanjutkan.',
                'status' => $transaction->status,
            ], 422);
        }

        if (!$transaction->snap_token) {
            $transaction->update([
                'snap_token' => Snap::getSnapToken($this->buildSnapParams($transaction->template, $transaction->order_id)),
            ]);
        }

        return response()->json([
            'snap_token' => $transaction->snap_token,
            'transaction_id' => $transaction->id,
        ]);
    }

    public function success(Request $request)
    {
        $this->configureMidtrans();

        $orderId = $request->order_id;

        if (!$orderId) {
            return redirect('/user/home')->with('error', 'Order ID tidak ditemukan');
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            return redirect('/user/home')->with('error', 'Transaction tidak ditemukan');
        }

        try {
            $status = $this->fetchMidtransStatus($orderId);
            $this->syncTransactionStatus($transaction, $status->transaction_status, $status->fraud_status ?? null);
        } catch (Throwable $e) {
            Log::warning('Midtrans success callback verification failed.', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('user.template.show', $transaction->template)
                ->with('info', 'Pembayaran sedang diverifikasi. Silakan tunggu sebentar lalu cek kembali.');
        }

        $flashType = $transaction->status === 'paid' ? 'success' : ($transaction->status === 'failed' ? 'error' : 'info');
        $flashMessage = match ($transaction->status) {
            'paid' => 'Pembayaran berhasil. Template siap diunduh.',
            'failed' => 'Pembayaran gagal atau dibatalkan.',
            default => 'Pembayaran masih menunggu konfirmasi.',
        };

        return redirect()
            ->route('user.template.show', $transaction->template)
            ->with($flashType, $flashMessage);
    }

    public function notification(Request $request)
    {
        $this->configureMidtrans();

        Log::info('Midtrans notification received.', [
            'payload' => $request->all(),
            'raw_body' => $request->getContent(),
        ]);

        $notif = new \Midtrans\Notification();

        $orderId           = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $fraudStatus       = $notif->fraud_status;

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            Log::warning('Midtrans notification transaction not found.', [
                'order_id' => $orderId,
            ]);

            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $this->syncTransactionStatus($transaction, $transactionStatus, $fraudStatus);

        Log::info('Midtrans notification synchronized.', [
            'transaction_id' => $transaction->id,
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'local_status' => $transaction->fresh()->status,
        ]);

        return response()->json(['message' => 'OK']);
    }

    private function configureMidtrans(): void
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    private function buildSnapParams(Template $template, string $orderId): array
    {
        $callbackUrl = route('user.payment.success', ['order_id' => $orderId]);

        return [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $template->price,
            ],
            'item_details'        => [[
                'id'       => $template->id,
                'price'    => (int) $template->price,
                'quantity' => 1,
                'name'     => $template->title,
            ]],
            'customer_details'    => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
            'callbacks' => [
                'finish' => $callbackUrl,
                'error' => $callbackUrl,
                'unfinish' => $callbackUrl,
            ],
        ];
    }

    private function refreshTransactionStatus(Transaction $transaction): void
    {
        if ($transaction->status !== 'pending') {
            return;
        }

        try {
            $status = $this->fetchMidtransStatus($transaction->order_id);
            $this->syncTransactionStatus($transaction, $status->transaction_status, $status->fraud_status ?? null);
        } catch (Throwable $e) {
            Log::warning('Midtrans refresh status failed.', [
                'order_id' => $transaction->order_id,
                'message' => $e->getMessage(),
            ]);

            // Keep local status as pending if Midtrans status cannot be fetched.
        }
    }

    private function fetchMidtransStatus(string $orderId, int $attempts = 3, int $delayMilliseconds = 350): object
    {
        $lastException = null;

        for ($attempt = 1; $attempt <= $attempts; $attempt++) {
            try {
                return MidtransTransaction::status($orderId);
            } catch (Throwable $e) {
                $lastException = $e;

                if ($attempt < $attempts) {
                    usleep($delayMilliseconds * 1000);
                }
            }
        }

        throw $lastException ?? new \RuntimeException('Gagal mengambil status Midtrans.');
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

        Log::info('Transaction status synchronized.', [
            'transaction_id' => $transaction->id,
            'order_id' => $transaction->order_id,
            'midtrans_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'local_status' => $status,
        ]);
    }
}
