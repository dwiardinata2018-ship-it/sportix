<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'account_status',
        'email_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

// Relasi akun dengan profil Owner.
public function ownerProfile()
{
    return $this->hasOne(OwnerProfile::class, 'user_id', 'id');
}

// Relasi akun Admin yang melakukan verifikasi Owner.
public function verifiedOwnerProfiles()
{
    return $this->hasMany(OwnerProfile::class, 'verified_by', 'id');
}

// Satu Owner dapat memiliki banyak Venue.
public function venues()
{
    return $this->hasMany(Venue::class, 'owner_id', 'id');
}

// Admin yang melakukan verifikasi Venue.
public function verifiedVenues()
{
    return $this->hasMany(Venue::class, 'verified_by', 'id');
}
// Satu Owner dapat membuat banyak jadwal blokir.
public function createdBlockedSlots()
{
    return $this->hasMany(BlockedSlot::class, 'created_by', 'id');
}
// Satu Owner dapat memiliki beberapa rekening pembayaran.
public function paymentAccounts()
{
    return $this->hasMany(OwnerPaymentAccount::class, 'owner_id', 'id');
}
// Satu pengguna dapat memiliki banyak booking.
public function bookings()
{
    return $this->hasMany(Booking::class, 'user_id', 'id');
}

// Satu pengguna dapat memverifikasi banyak check-in.
public function checkedBookings()
{
    return $this->hasMany(Booking::class, 'checked_in_by', 'id');
}
// Satu pengguna dapat melakukan banyak perubahan status booking.
public function bookingStatusChanges()
{
    return $this->hasMany(
        BookingStatusHistory::class,
        'changed_by',
        'id'
    );
}
// Satu Owner dapat memverifikasi banyak pembayaran.
public function verifiedPayments()
{
    return $this->hasMany(PaymentRecord::class, 'verified_by', 'id');
}
// Satu pengguna dapat memberikan banyak ulasan.
public function reviews()
{
    return $this->hasMany(Review::class, 'user_id', 'id');
}

// Satu Admin dapat memoderasi banyak ulasan.
public function moderatedReviews()
{
    return $this->hasMany(Review::class, 'moderated_by', 'id');
}
// Satu User dapat memiliki banyak daftar favorite.
public function favorites()
{
    return $this->hasMany(Favorite::class, 'user_id', 'id');
}

// Mengambil semua Venue yang disukai User.
public function favoriteVenues()
{
    return $this->belongsToMany(
        Venue::class,
        'favorites',
        'user_id',
        'venue_id'
    );
}
// Satu User dapat memiliki banyak notifikasi.
public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id', 'id');
}
// User dapat memverifikasi banyak dokumen Venue.
public function verifiedVenueDocuments()
{
    return $this->hasMany(VenueDocument::class, 'verified_by', 'id');
}
// Satu User dapat memiliki banyak catatan aktivitas.
public function auditLogs()
{
    return $this->hasMany(AuditLog::class, 'user_id', 'id');
}
}
