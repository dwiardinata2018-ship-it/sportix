<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatingHour extends Model
{
    use HasFactory;

    protected $table = 'operating_hours';

    public $timestamps = false;

    protected $fillable = [
        'venue_id',
        'weekday',
        'open_time',
        'close_time',
        'is_closed',
    ];

    protected function casts(): array
    {
        return [
            'weekday' => 'integer',
            'is_closed' => 'boolean',
        ];
    }

    // Jadwal operasional ini dimiliki oleh satu Venue.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
