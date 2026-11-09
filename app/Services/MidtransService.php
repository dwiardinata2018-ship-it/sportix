<?php

namespace App\Services;

use App\Models\PaymentRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\CoreApi;
use RuntimeException;
use Midtrans\Transaction;

class MidtransService
{
    /**
     * Mengatur koneksi Midtrans.
     */
    private function configure(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        if (empty(Config::$serverKey)) {
            throw new RuntimeException(
                'Midtrans Server Key belum dikonfigurasi.'
            );
        }
    }

    /**
     * Membuat ID transaksi baru.
     */
    private function generateOrderId(PaymentRecord $payment): string
    {
        return 'SPX-PAY-' . $payment->id . '-'
            . strtoupper(Str::random(8));
    }

    /**
     * Memeriksa apakah status pembayaran tidak boleh diubah.
     */
    private function isProtectedStatus(string $status): bool
    {
        return in_array(
            $status,
            ['paid', 'payment_disputed', 'refunded'],
            true
        );
    }

    /**
     * Membuat transaksi QRIS untuk booking.
     */
    public function createQrisTransaction(
        PaymentRecord $payment
    ): PaymentRecord {
        $this->configure();

        return DB::transaction(function () use ($payment) {

            // Kunci data pembayaran agar tidak diproses bersamaan.
            $payment = PaymentRecord::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $payment->loadMissing('booking.user');

            $booking = $payment->booking;
            $user = $booking?->user;

            if (!$booking || !$user) {
                throw new RuntimeException(
                    'Data booking atau pelanggan tidak ditemukan.'
                );
            }

            // Lindungi status pembayaran.
            if ($this->isProtectedStatus($payment->payment_status)) {
                throw new RuntimeException(
                    'Status pembayaran tidak mengizinkan transaksi baru.'
                );
            }

            // Pastikan nominal merupakan Rupiah bulat.
            $amount = number_format(
                (float) $payment->amount,
                2,
                '.',
                ''
            );

            if (
                !preg_match('/^[0-9]+\.00$/', $amount) ||
                (float) $amount <= 0
            ) {
                throw new RuntimeException(
                    'Nominal pembayaran harus berupa angka Rupiah bulat dan lebih dari nol.'
                );
            }

            $grossAmount = (int) $amount;

            /*
             * Periksa transaksi sebelumnya.
             */
            if ($payment->midtrans_order_id) {

                try {
                    $previous = Transaction::status(
                        $payment->midtrans_order_id
                    );
                } catch (\Throwable $e) {
                    throw new RuntimeException(
                        'Status transaksi sebelumnya belum dapat dipastikan. '
                        . 'Periksa transaksi di dashboard Midtrans sebelum mencoba kembali.',
                        0,
                        $e
                    );
                }

                // Pastikan Order ID sesuai.
                if (
                    ($previous->order_id ?? null)
                    !== $payment->midtrans_order_id
                ) {
                    throw new RuntimeException(
                        'Order ID transaksi sebelumnya tidak sesuai.'
                    );
                }

                // Pastikan nominal sesuai.
                $previousAmount = number_format(
                    (float) ($previous->gross_amount ?? 0),
                    2,
                    '.',
                    ''
                );

                if ($previousAmount !== $amount) {
                    throw new RuntimeException(
                        'Nominal transaksi sebelumnya tidak sesuai database.'
                    );
                }

                $previousStatus =
                    $previous->transaction_status ?? null;

                // Transaksi sebelumnya sudah lunas.
                if (
                    $previousStatus === 'settlement' ||
                    (
                        $previousStatus === 'capture' &&
                        ($previous->fraud_status ?? null) === 'accept'
                    )
                ) {
                    $payment->update([
                        'payment_status' => 'paid',
                        'midtrans_transaction_id' =>
                            $previous->transaction_id
                            ?? $payment->midtrans_transaction_id,
                        'midtrans_transaction_status' => $previousStatus,
                    ]);

                    return $payment->fresh();
                }

                // Transaksi masih menunggu pembayaran.
                if ($previousStatus === 'pending') {

                    $payment->update([
                        'midtrans_transaction_id' =>
                            $previous->transaction_id
                            ?? $payment->midtrans_transaction_id,
                        'midtrans_transaction_status' => 'pending',
                    ]);

                    if (
                        $payment->midtrans_qr_url &&
                        (
                            !$payment->midtrans_expired_at ||
                            $payment->midtrans_expired_at->isFuture()
                        )
                    ) {
                        return $payment->fresh();
                    }

                    throw new RuntimeException(
                        'Transaksi masih pending, tetapi QRIS belum tersedia atau sudah kedaluwarsa. Periksa transaksi di dashboard Midtrans.'
                    );
                }

                // Hanya transaksi terminal yang boleh dibuat ulang.
                if (!in_array(
                    $previousStatus,
                    ['expire', 'cancel', 'deny'],
                    true
                )) {
                    throw new RuntimeException(
                        'Status transaksi sebelumnya belum aman untuk dicoba ulang: '
                        . ($previousStatus ?? 'tidak diketahui')
                    );
                }

                // Siapkan Order ID baru.
                $payment->update([
                    'midtrans_transaction_status' => $previousStatus,
                    'midtrans_order_id' => $this->generateOrderId($payment),
                    'midtrans_transaction_id' => null,
                    'midtrans_qr_url' => null,
                    'midtrans_expired_at' => null,
                ]);

            } else {

                // Transaksi pertama.
                $payment->update([
                    'midtrans_order_id' => $this->generateOrderId($payment),
                ]);
            }

            /*
             * Kirim permintaan transaksi ke Midtrans.
             */
            $params = [
                'payment_type' => 'qris',

                'transaction_details' => [
                    'order_id' => $payment->midtrans_order_id,
                    'gross_amount' => $grossAmount,
                ],

                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ];

            $response = CoreApi::charge($params);

            // Cari URL QRIS.
            $qrUrl = null;

            foreach ($response->actions ?? [] as $action) {
                if (($action->name ?? '') === 'generate-qr-code') {
                    $qrUrl = $action->url ?? null;
                    break;
                }
            }

            if (!$qrUrl) {
                throw new RuntimeException(
                    'URL QRIS tidak ditemukan pada respons Midtrans.'
                );
            }

            // Pastikan pembayaran belum berubah menjadi status terlindungi.
            $payment->refresh();

            if ($this->isProtectedStatus($payment->payment_status)) {
                return $payment;
            }

            // Simpan hasil transaksi.
            $payment->update([
                'payment_method' => 'qris',
                'midtrans_transaction_id' =>
                    $response->transaction_id ?? null,
                'midtrans_qr_url' => $qrUrl,
                'midtrans_expired_at' =>
                    !empty($response->expiry_time)
                        ? Carbon::parse($response->expiry_time)
                        : null,
                'midtrans_transaction_status' =>
                    $response->transaction_status ?? 'pending',
            ]);

            return $payment->fresh();

        }, );
    }

    /**
     * Memeriksa dan memperbarui status pembayaran dari Midtrans.
     */
    public function refreshPaymentStatus(
        PaymentRecord $payment
    ): PaymentRecord {
        $this->configure();

        $payment->refresh();

        if ($this->isProtectedStatus($payment->payment_status)) {
            return $payment;
        }

        if (!$payment->midtrans_order_id) {
            return $payment;
        }

        // Simpan Order ID yang sedang diperiksa.
        $orderId = $payment->midtrans_order_id;

        $transaction = Transaction::status($orderId);

        if (($transaction->order_id ?? null) !== $orderId) {
            throw new RuntimeException(
                'Order ID transaksi tidak sesuai.'
            );
        }

        $midtransAmount = number_format(
            (float) ($transaction->gross_amount ?? 0),
            2,
            '.',
            ''
        );

        $databaseAmount = number_format(
            (float) $payment->amount,
            2,
            '.',
            ''
        );

        if ($midtransAmount !== $databaseAmount) {
            throw new RuntimeException(
                'Nominal transaksi Midtrans tidak sesuai database.'
            );
        }

        $transactionStatus =
            $transaction->transaction_status ?? null;

        $fraudStatus =
            $transaction->fraud_status ?? null;

        DB::transaction(function () use (
            $payment,
            $orderId,
            $transaction,
            $transactionStatus,
            $fraudStatus
        ) {
            $currentPayment = PaymentRecord::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Lindungi status pembayaran.
            if ($this->isProtectedStatus($currentPayment->payment_status)) {
                return;
            }

            // Jangan gunakan respons transaksi lama.
            if ($currentPayment->midtrans_order_id !== $orderId) {
                return;
            }

            $newPaymentStatus = $currentPayment->payment_status;

            if (
                $transactionStatus === 'settlement' ||
                (
                    $transactionStatus === 'capture' &&
                    $fraudStatus === 'accept'
                )
            ) {
                $newPaymentStatus = 'paid';

            } elseif (
                in_array(
                    $transactionStatus,
                    ['pending', 'expire', 'cancel', 'deny'],
                    true
                )
            ) {
                $newPaymentStatus = 'unpaid';
            }

            $currentPayment->update([
                'payment_status' => $newPaymentStatus,
                'midtrans_transaction_id' =>
                    $transaction->transaction_id
                    ?? $currentPayment->midtrans_transaction_id,
                'midtrans_transaction_status' =>
                    $transactionStatus
                    ?? $currentPayment->midtrans_transaction_status,
            ]);
        });

        return $payment->fresh();
    }
}
