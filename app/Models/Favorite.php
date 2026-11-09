<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    // Tabel hanya memiliki created_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'venue_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // Favorite dimiliki oleh satu User.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Favorite mengarah ke satu Venue.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
