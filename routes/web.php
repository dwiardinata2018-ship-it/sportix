<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\VenueController;
use App\Http\Controllers\Owner\VenueUnitController;
use App\Http\Controllers\Owner\OperatingHourController;
use App\Http\Controllers\Owner\PricingRuleController;
use App\Http\Controllers\Owner\BookingController as OwnerBookingController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\User\ActivityController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OwnerController as AdminOwnerController;


// Halaman utama Sportix
Route::get('/', function () {
    return view('welcome');
});

// Webhook notifikasi pembayaran Midtrans
Route::post('/midtrans/notification', [
    MidtransWebhookController::class,
    'handle'
])->name('midtrans.notification');

// Dashboard utama: mengarahkan pengguna sesuai role
Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'user' => redirect()->route('user.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        default => abort(403, 'Role akun tidak dikenali.'),
    };
})->middleware('auth')->name('dashboard');


// ======================================
// HALAMAN KHUSUS USER
// ======================================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', function () {
    return view('dashboard');
    })->name('dashboard');

    // Halaman Reservation
    Route::get('/reservation', [ReservationController::class, 'index'])
        ->name('reservation');

    // Halaman Detail Venue
    Route::get('/reservation/{slug}', [ReservationController::class, 'show'])
        ->name('reservation.detail');
    // Memeriksa ketersediaan unit venue
    Route::get('/reservation/{slug}/availability', [ReservationController::class, 'checkAvailability'])
        ->name('reservation.availability');

    // Halaman Booking
    Route::get('/booking', [BookingController::class, 'index'])
        ->name('booking');

    // Memproses pemesanan venue
    Route::post('/booking', [BookingController::class, 'store'])
        ->name('booking.store');

    Route::get('/booking/{id}/qr', [BookingController::class, 'qr'])
    ->name('booking.qr');
    // Halaman pembayaran QRIS
    Route::get('/booking/{id}/payment', [PaymentController::class, 'show'])
        ->whereNumber('id')
        ->name('booking.payment');
    // Meminta pembuatan ulang QRIS
    Route::post('/booking/{id}/payment/retry', [PaymentController::class, 'retry'])
        ->whereNumber('id')
        ->name('booking.payment.retry');

    // Halaman Activity User
    Route::get('/activity', [ActivityController::class, 'index'])
        ->name('activity');
        // Halaman Favorit User
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('favorites');

    // Menambahkan venue ke favorit
    Route::post('/favorites/{venueId}', [FavoriteController::class, 'store'])
        ->whereNumber('venueId')
        ->name('favorites.store');

    // Menghapus venue dari favorit
    Route::delete('/favorites/{venueId}', [FavoriteController::class, 'destroy'])
        ->whereNumber('venueId')
        ->name('favorites.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications');

    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.read');
    // Reviews dan Rating
    Route::post('/booking/{bookingId}/review', [ReviewController::class, 'store'])
        ->whereNumber('bookingId')
        ->name('booking.review.store');
    Route::post('/booking/{id}/payment/cash', [PaymentController::class, 'selectCash'])
    ->whereNumber('id')
    ->name('booking.payment.cash');

});


// ======================================
// HALAMAN KHUSUS OWNER
// ======================================
// OWNER
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        // Pengelolaan booking Owner
        Route::get('/bookings', [OwnerBookingController::class, 'index'])
            ->name('bookings.index');
        // Menerima booking
        Route::patch('/bookings/{id}/confirm', [OwnerBookingController::class, 'confirm'])
            ->name('bookings.confirm');
        // Halaman QR Scanner
        Route::get('/bookings/check-in', [OwnerBookingController::class, 'checkin'])
            ->name('bookings.checkin');
        // Proses QR Check-in
        Route::post('/bookings/check-in', [OwnerBookingController::class, 'storeCheckin'])
            ->name('bookings.checkin.store');
        // Menolak booking
        Route::patch('/bookings/{id}/reject', [OwnerBookingController::class, 'reject'])
            ->name('bookings.reject');
        Route::patch('/bookings/{id}/complete', [OwnerBookingController::class, 'complete'])
            ->whereNumber('id')
            ->name('bookings.complete');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/venues/create', [VenueController::class, 'create'])
            ->name('venues.create');
        
        Route::get('/venues/{id}', [VenueController::class, 'show'])
            ->whereNumber('id')
            ->name('venues.show');

        Route::post('/venues', [VenueController::class, 'store'])
            ->name('venues.store');

        Route::get('/venues', [VenueController::class, 'index'])
            ->name('venues.index');

        Route::get('/venues/{id}/edit', [VenueController::class, 'edit'])
            ->whereNumber('id')
            ->name('venues.edit');

        Route::put('/venues/{id}', [VenueController::class, 'update'])
            ->whereNumber('id')
            ->name('venues.update');
            // Mengubah status aktif/nonaktif venue
        Route::patch('/venues/{id}/status', [VenueController::class, 'updateStatus'])
            ->whereNumber('id')
            ->name('venues.status');
        Route::delete('/venues/{id}/images/{imageId}', [VenueController::class, 'destroyImage'])
            ->whereNumber('id')
            ->whereNumber('imageId')
            ->name('venues.images.destroy');
        Route::patch('/venues/{id}/images/{imageId}/primary', [VenueController::class, 'setPrimaryImage'])
            ->whereNumber('id')
            ->whereNumber('imageId')
            ->name('venues.images.primary');
        Route::get('/venues/{venueId}/units', [VenueUnitController::class, 'index'])
            ->whereNumber('venueId')
            ->name('venues.units.index');
        Route::get('/venues/{venueId}/units/create', [VenueUnitController::class, 'create'])
            ->whereNumber('venueId')
            ->name('venues.units.create');
        Route::post('/venues/{venueId}/units', [VenueUnitController::class, 'store'])
            ->whereNumber('venueId')
            ->name('venues.units.store');
        Route::get('/venues/{venueId}/units/{unitId}/edit', [VenueUnitController::class, 'edit'])
            ->whereNumber('venueId')
            ->whereNumber('unitId')
            ->name('venues.units.edit');
        Route::put('/venues/{venueId}/units/{unitId}', [VenueUnitController::class, 'update'])
            ->whereNumber('venueId')
            ->whereNumber('unitId')
            ->name('venues.units.update');
        Route::patch('/venues/{venueId}/units/{unitId}/status', [VenueUnitController::class, 'toggleStatus'])
            ->whereNumber('venueId')
            ->whereNumber('unitId')
            ->name('venues.units.toggle-status');
        Route::get('/venues/{venueId}/operating-hours', [OperatingHourController::class, 'index'])
            ->whereNumber('venueId')
            ->name('venues.operating-hours.index');
        Route::get('/venues/{venueId}/operating-hours/edit', [OperatingHourController::class, 'edit'])
            ->whereNumber('venueId')
            ->name('venues.operating-hours.edit');

        Route::put('/venues/{venueId}/operating-hours', [OperatingHourController::class, 'update'])
            ->whereNumber('venueId')
            ->name('venues.operating-hours.update');
        // Pengelolaan aturan harga venue.
        Route::get('/venues/{venueId}/pricing-rules', [PricingRuleController::class, 'index'])
            ->whereNumber('venueId')
            ->name('venues.pricing-rules.index');
        // Menampilkan formulir tambah aturan harga.
        Route::get('/venues/{venueId}/pricing-rules/create', [PricingRuleController::class, 'create'])
            ->whereNumber('venueId')
            ->name('venues.pricing-rules.create');
        // Menyimpan aturan harga baru.
        Route::post('/venues/{venueId}/pricing-rules', [PricingRuleController::class, 'store'])
            ->whereNumber('venueId')
            ->name('venues.pricing-rules.store');
        // Menampilkan formulir edit aturan harga.
        Route::get('/venues/{venueId}/pricing-rules/{ruleId}/edit', [PricingRuleController::class, 'edit'])
            ->whereNumber('venueId')
            ->whereNumber('ruleId')
            ->name('venues.pricing-rules.edit');
        // Menyimpan perubahan aturan harga.
        Route::put('/venues/{venueId}/pricing-rules/{ruleId}', [PricingRuleController::class, 'update'])
            ->whereNumber('venueId')
            ->whereNumber('ruleId')
            ->name('venues.pricing-rules.update');
        Route::delete('/venues/{venueId}/pricing-rules/{ruleId}', [PricingRuleController::class, 'destroy'])
            ->whereNumber('venueId')
            ->whereNumber('ruleId')
            ->name('venues.pricing-rules.destroy');
        Route::patch('/bookings/{id}/payment/cash/confirm', [OwnerBookingController::class, 'confirmCashPayment'])
            ->whereNumber('id')
            ->name('bookings.cash.confirm');
        
        // Pengelolaan Profil Owner.
        Route::get('/profile', [\App\Http\Controllers\Owner\ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [\App\Http\Controllers\Owner\ProfileController::class, 'update'])
            ->name('profile.update');

});

// ======================================
// HALAMAN KHUSUS ADMIN
// ======================================


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin.
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // Kelola Pengguna.
    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/{user}', [AdminUserController::class, 'show'])
        ->name('users.show');

    Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])
        ->name('users.updateStatus');

        // Kelola Owner.
    Route::get('/owners', [AdminOwnerController::class, 'index'])
        ->name('owners.index');
        // Detail Owner.
    Route::get('/owners/{owner}', [AdminOwnerController::class, 'show'])
        ->name('owners.show');
    Route::patch('/owners/{owner}/status', [AdminOwnerController::class, 'updateStatus'])
        ->name('owners.updateStatus');
    // Melihat dokumen identitas Owner.
    Route::get('/owners/{owner}/document', [AdminOwnerController::class, 'showDocument'])
        ->name('owners.document');

    // Menyetujui verifikasi profil Owner.
    Route::patch('/owners/{owner}/verify', [AdminOwnerController::class, 'verify'])
        ->name('owners.verify');

    // Menolak verifikasi profil Owner.
    Route::patch('/owners/{owner}/reject', [AdminOwnerController::class, 'reject'])
        ->name('owners.reject');
        // Kelola Lapangan
    Route::get('/venues', [\App\Http\Controllers\Admin\VenueController::class, 'index'])
        ->name('venues.index');

}); 


// ======================================
// PROFILE BAWAAN BREEZE
// ======================================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';
