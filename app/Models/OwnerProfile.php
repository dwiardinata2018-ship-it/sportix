<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerProfile extends Model
{
    use HasFactory;

    protected $table = 'owner_profiles';

    protected $fillable = [
        'user_id',
        'identity_number',
        'identity_document_path',
        'business_name',
        'verification_status',
        'verification_notes',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    // Profil ini dimiliki oleh satu akun User.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Admin yang melakukan verifikasi profil Owner.
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }
}
