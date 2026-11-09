<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $table = 'payment_records';

    protected $fillable = [
        'booking_id',
        'owner_payment_account_id',
        'payment_method',
        'payment_status',
        'amount',
        'proof_image_path',
        'submitted_at',
        'verified_by',
        'verified_at',
        'bank_name_snapshot',
        'account_number_snapshot',
        'account_holder_snapshot',
        'notes',

        // Data transaksi Midtrans
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_qr_url',
        'midtrans_expired_at',
        'midtrans_transaction_status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'midtrans_expired_at' => 'datetime',
        ];
    }

    // Pembayaran terkait dengan satu booking.
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    // Rekening Owner untuk pembayaran transfer.
    public function ownerPaymentAccount()
    {
        return $this->belongsTo(
            OwnerPaymentAccount::class,
            'owner_payment_account_id',
            'id'
        );
    }

    // Owner yang memverifikasi pembayaran.
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }
}
