<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $table = 'pricing_rules';

    protected $fillable = [
        'venue_id',
        'unit_id',
        'name',
        'weekday',
        'start_time',
        'end_time',
        'price_per_hour',
        'effective_from',
        'effective_until',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'weekday' => 'integer',
            'price_per_hour' => 'decimal:2',
            'effective_from' => 'date',
            'effective_until' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Aturan harga ini dimiliki oleh satu Venue.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    // Aturan harga dapat berlaku untuk satu unit tertentu.
    public function unit()
    {
        return $this->belongsTo(VenueUnit::class, 'unit_id', 'id');
    }
}

