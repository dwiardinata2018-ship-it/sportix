<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'booking_status_histories';

    // Tabel hanya memiliki created_at, tanpa updated_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'booking_id',
        'changed_by',
        'old_status',
        'new_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // Riwayat ini merupakan bagian dari satu booking.
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    // Pengguna yang mengubah status booking.
    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }
}
