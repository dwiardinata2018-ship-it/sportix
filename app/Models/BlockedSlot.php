<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedSlot extends Model
{
    use HasFactory;

    protected $table = 'blocked_slots';

    // Tabel ini hanya memiliki created_at, tanpa updated_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'unit_id',
        'start_at',
        'end_at',
        'reason',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    // Jadwal blokir dimiliki oleh satu unit olahraga.
    public function unit()
    {
        return $this->belongsTo(VenueUnit::class, 'unit_id', 'id');
    }

    // Pengguna yang membuat jadwal blokir.
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
