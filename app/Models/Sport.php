<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $table = 'sports';

    protected $fillable = [
        'name',
        'description',
        'icon_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Satu kategori olahraga dapat memiliki banyak Venue.
    public function venues()
    {
        return $this->hasMany(Venue::class, 'sport_id', 'id');
    }
}
