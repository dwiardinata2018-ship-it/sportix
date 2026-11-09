<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerPaymentAccount extends Model
{
    use HasFactory;

    protected $table = 'owner_payment_accounts';

    protected $fillable = [
        'owner_id',
        'bank_name',
        'account_number',
        'account_holder',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Rekening pembayaran dimiliki oleh satu Owner.
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
    // Satu rekening dapat digunakan untuk beberapa catatan pembayaran.
    public function paymentRecords()
    {
        return $this->hasMany(
            PaymentRecord::class,
            'owner_payment_account_id',
            'id'
        );
    }
}
