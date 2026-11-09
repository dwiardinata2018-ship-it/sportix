<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    // Tabel hanya memiliki created_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'notification_type',
        'related_type',
        'related_id',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    // Notifikasi dimiliki oleh satu User.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
