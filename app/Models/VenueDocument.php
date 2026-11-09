<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueDocument extends Model
{
    use HasFactory;

    protected $table = 'venue_documents';

    // Tabel hanya memiliki created_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'venue_id',
        'document_type',
        'file_path',
        'verification_status',
        'verification_notes',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    // Dokumen dimiliki oleh satu Venue.
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    // Dokumen diverifikasi oleh satu User (Admin).
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }
}

