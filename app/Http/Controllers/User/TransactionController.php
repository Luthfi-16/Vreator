<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function checkout(Template $template)
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $orderId = 'ORDER-' . uniqid();

        $params = [
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
                'finish' => route('user.payment.success', ['order_id' => $orderId]),
            ],
        ];


        $snapToken = Snap::getSnapToken($params);

        // Simpan ke DB setelah snap berhasil dibuat
        Transaction::create([
            'user_id'     => Auth::id(),
            'template_id' => $template->id,
            'order_id'    => $orderId,
            'total_price' => $template->price,
            'status'      => 'pending',
        ]);

        return response()->json([
            'snap_token' => $snapToken,
        ]);
    }

    public function success(Request $request)
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $orderId = $request->order_id;

        if (!$orderId) {
            return redirect('/user/home')->with('error', 'Order ID tidak ditemukan');
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            return redirect('/user/home')->with('error', 'Transaction tidak ditemukan');
        }

        try {

            $status = \Midtrans\Transaction::status($orderId);

            // DEBUG dulu kalau mau
            // dd($status);

            if (in_array($status->transaction_status, ['settlement', 'capture'])) {

                $transaction->update([
                    'status' => 'paid'
                ]);

            } elseif ($status->transaction_status == 'pending') {

                $transaction->update([
                    'status' => 'pending'
                ]);

            } elseif (in_array($status->transaction_status, ['expire', 'cancel', 'deny'])) {

                $transaction->update([
                    'status' => 'failed'
                ]);
            }

        } catch (\Exception $e) {
            return redirect('/user/home')->with('error', 'Gagal cek status Midtrans');
        }

        return redirect('/user/home')->with('success', 'Payment processed');
    }
}
