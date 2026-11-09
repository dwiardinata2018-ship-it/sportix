<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'facilities';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'icon_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Fasilitas dapat digunakan oleh banyak Venue.
    public function venues()
    {
        return $this->belongsToMany(
            Venue::class,
            'venue_facilities',
            'facility_id',
            'venue_id'
        );
    }
}
