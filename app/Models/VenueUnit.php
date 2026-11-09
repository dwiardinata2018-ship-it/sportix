<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueUnit extends Model
{
    use HasFactory;

    protected $table = 'venue_units';

    protected $fillable = [
        'venue_id',
        'name',
        'unit_type',
        'description',
        'capacity',
        'default_price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'default_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Unit ini dimiliki oleh satu Venue.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
    // Satu unit olahraga dapat memiliki beberapa aturan harga.
    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class, 'unit_id', 'id');
    }
    // Satu unit olahraga dapat memiliki banyak jadwal blokir.
    public function blockedSlots()
    {
        return $this->hasMany(BlockedSlot::class, 'unit_id', 'id');
    }
    // Satu unit olahraga dapat memiliki banyak booking.
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'unit_id', 'id');
    }
}
