<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueImage extends Model
{
    use HasFactory;

    protected $table = 'venue_images';

    // Tabel hanya memiliki created_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'venue_id',
        'image_path',
        'caption',
        'is_primary',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'display_order' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    // Foto dimiliki oleh satu Venue.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
