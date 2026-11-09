<?php

namespace App\Http\Controllers;

use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\CoreApi;
use Midtrans\Config;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        $notification = $request->all();

        $orderId = $notification['order_id'] ?? null;
        $statusCode = $notification['status_code'] ?? null;
        $grossAmount = $notification['gross_amount'] ?? null;
        $signatureKey = $notification['signature_key'] ?? null;

        // Validasi data dasar.
        if (
            !$orderId ||
            !$statusCode ||
            !$grossAmount ||
            !$signatureKey
        ) {
            return response('Invalid notification data.', 400);
        }

        // Verifikasi signature.
        $serverKey = config('midtrans.server_key');

        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::warning('Midtrans signature tidak valid.', [
                'order_id' => $orderId,
            ]);

            return response('Invalid signature.', 403);
        }

        try {
            // Periksa transaksi langsung ke server Midtrans.
            // Konfigurasi SDK Midtrans untuk request Webhook.
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = (bool) config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            if (empty(Config::$serverKey)) {
                throw new \RuntimeException(
                    'Midtrans Server Key belum dikonfigurasi.'
                );
            }
            $transaction = Transaction::status($orderId);

            // Pastikan Order ID cocok.
            if (($transaction->order_id ?? null) !== $orderId) {
                return response('Order ID mismatch.', 400);
            }

            // Pastikan nominal cocok dengan notifikasi dan database.
            $notificationAmount = number_format(
                (float) $grossAmount,
                2,
                '.',
                ''
            );

            $serverAmount = number_format(
                (float) ($transaction->gross_amount ?? 0),
                2,
                '.',
                ''
            );

            if ($notificationAmount !== $serverAmount) {
                return response('Transaction amount mismatch.', 400);
            }

            DB::transaction(function () use (
                $orderId,
                $transaction,
                $notificationAmount
            ) {
                $payment = PaymentRecord::where(
                    'midtrans_order_id',
                    $orderId
                )
                ->lockForUpdate()
                ->first();

                if (!$payment) {
                    throw new \RuntimeException(
                        'Payment record tidak ditemukan.'
                    );
                }

                $databaseAmount = number_format(
                    (float) $payment->amount,
                    2,
                    '.',
                    ''
                );

                if ($databaseAmount !== $notificationAmount) {
                    throw new \RuntimeException(
                        'Nominal database tidak sesuai.'
                    );
                }

               // Lindungi status pembayaran yang tidak boleh diturunkan.
                if (in_array(
                    $payment->payment_status,
                    ['paid', 'payment_disputed', 'refunded'],
                    true
                )) {
                    return;
                }

                $transactionStatus =
                    $transaction->transaction_status ?? null;

                $fraudStatus =
                    $transaction->fraud_status ?? null;

                $paymentStatus = $payment->payment_status;

                if (
                    $transactionStatus === 'settlement' ||
                    (
                        $transactionStatus === 'capture' &&
                        $fraudStatus === 'accept'
                    )
                ) {
                    $paymentStatus = 'paid';
                } elseif (
                    in_array(
                        $transactionStatus,
                        ['pending', 'expire', 'cancel', 'deny'],
                        true
                    )
                ) {
                    $paymentStatus = 'unpaid';
                }

                $payment->update([
                    'payment_status' => $paymentStatus,
                    'midtrans_transaction_id' =>
                        $transaction->transaction_id ??
                        $payment->midtrans_transaction_id,
                    'midtrans_transaction_status' =>
                        $transactionStatus ??
                        $payment->midtrans_transaction_status,
                ]);
            });

            return response('OK', 200);

        } catch (\Throwable $e) {
            Log::error('Midtrans webhook gagal diproses.', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
            ]);

            return response('Webhook processing failed.', 500);
        }
    }
}