<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'booking_id',
        'user_id',
        'venue_id',
        'rating',
        'comment',
        'moderation_status',
        'moderated_by',
        'moderated_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'moderated_at' => 'datetime',
        ];
    }

    // Ulasan berasal dari satu booking.
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    // Pengguna yang memberikan ulasan.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Venue yang mendapatkan ulasan.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    // Admin yang memoderasi ulasan.
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by', 'id');
    }
}
