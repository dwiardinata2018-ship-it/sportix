<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'user_id',
        'venue_id',
        'unit_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_minutes',
        'price_per_hour_snapshot',
        'total_price',
        'booking_status',
        'checkin_token_hash',
        'checked_in_at',
        'checked_in_by',
        'user_notes',
        'owner_notes',
        'expires_at',
    ];

    protected $hidden = [
        'checkin_token_hash',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'duration_minutes' => 'integer',
            'price_per_hour_snapshot' => 'decimal:2',
            'total_price' => 'decimal:2',
            'checked_in_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // Pengguna yang melakukan pemesanan.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Venue yang dipesan.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    // Unit olahraga yang dipesan.
    public function unit()
    {
        return $this->belongsTo(VenueUnit::class, 'unit_id', 'id');
    }

    // Owner atau pengguna yang memverifikasi check-in.
    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_in_by', 'id');
    }
    // Satu booking memiliki banyak riwayat perubahan status.
    public function statusHistories()
    {
        return $this->hasMany(
            BookingStatusHistory::class,
            'booking_id',
            'id'
        );
    }
    // Satu booking memiliki satu catatan pembayaran.
    public function paymentRecord()
    {
        return $this->hasOne(PaymentRecord::class, 'booking_id', 'id');
    }
    // Satu booking hanya memiliki satu ulasan.
    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id', 'id');
    }
}
