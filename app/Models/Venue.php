<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venues';

    protected $fillable = [
        'owner_id',
        'sport_id',
        'name',
        'slug',
        'description',
        'address',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
        'whatsapp_number',
        'instagram_url',
        'venue_type',
        'verification_status',
        'venue_status',
        'verification_notes',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'verified_at' => 'datetime',
        ];
    }

    // Venue dimiliki oleh satu akun Owner.
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
    // Venue memiliki satu kategori olahraga.
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id', 'id');
    }
    // Admin yang melakukan verifikasi Venue.
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }
    // Satu Venue dapat memiliki banyak unit olahraga.
    public function units()
    {
        return $this->hasMany(VenueUnit::class, 'venue_id', 'id');
    }
    // Venue dapat memiliki banyak fasilitas.
    public function facilities()
    {
        return $this->belongsToMany(
            Facility::class,
            'venue_facilities',
            'venue_id',
            'facility_id'
        );
    }
    // Satu Venue memiliki beberapa jadwal operasional.
    public function operatingHours()
    {
        return $this->hasMany(OperatingHour::class, 'venue_id', 'id');
    }
    // Satu Venue dapat memiliki banyak aturan harga.
    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class, 'venue_id', 'id');
    }
    // Satu Venue dapat memiliki banyak booking.
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'venue_id', 'id');
    }
    // Satu Venue dapat memiliki banyak ulasan.
    public function reviews()
    {
        return $this->hasMany(Review::class, 'venue_id', 'id');
    }
    // Satu Venue dapat difavoritkan oleh banyak User.
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'venue_id', 'id');
    }

    // Mengambil semua User yang menyukai Venue ini.
    public function favoritedByUsers()
    {
        return $this->belongsToMany(
            User::class,
            'favorites',
            'venue_id',
            'user_id'
        );
    }
    // Satu Venue dapat memiliki banyak foto.
    public function images()
    {
        return $this->hasMany(VenueImage::class, 'venue_id', 'id');
    }
    // Satu Venue dapat memiliki banyak dokumen.
    public function documents()
    {
        return $this->hasMany(VenueDocument::class, 'venue_id', 'id');
    }

}
