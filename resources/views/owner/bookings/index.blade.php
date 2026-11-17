<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Booking - Sportix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neu-base text-neu-dark antialiased selection:bg-neu-primary selection:text-white">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar Mandiri Khusus Owner (Seragam dengan seluruh halaman Owner) -->
        <nav x-data="{ open: false }" class="bg-neu-base pt-6 pb-4">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">

                    <!-- KIRI: Logo & Badge Owner -->
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/owner/dashboard') }}"
                           class="text-3xl font-extrabold tracking-tight text-neu-primary drop-shadow-sm">
                            SPORTIX<span class="text-neu-muted">.</span>
                        </a>
                        <span class="hidden sm:inline-block rounded-full bg-neu-base shadow-neu-inset px-3.5 py-1 text-xs font-extrabold text-neu-primary uppercase tracking-wider">
                            Owner Panel
                        </span>
                    </div>

                    <!-- TENGAH: Menu Navigasi Owner -->
                    <div class="hidden md:flex md:items-center">
                        <div class="flex items-center space-x-2 bg-neu-base shadow-neu-inset rounded-full p-1.5">
                            <a href="{{ url('/owner/dashboard') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Dashboard
                            </a>
                            <a href="{{ url('/owner/venues') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Kelola Venue
                            </a>
                            <a href="{{ url('/owner/bookings') }}"
                               class="bg-neu-base shadow-neu-raised text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Booking
                            </a>
                            <a href="{{ url('/owner/bookings/checkin') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Check-in QR
                            </a>
                            <a href="{{ url('/owner/profile') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Profil Usaha
                            </a>
                        </div>
                    </div>

                    <!-- KANAN: Info Akun & Tombol Logout -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-3">
                        <div class="rounded-full bg-neu-base shadow-neu-inset px-4 py-2.5 text-xs font-extrabold text-neu-dark">
                            {{ Auth::user()->name }}
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-neu-base shadow-neu-raised text-red-500 transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed focus:outline-none"
                                    title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Tombol Menu Mobile -->
                    <div class="flex items-center md:hidden">
                        <button @click="open = ! open"
                                class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-neu-base shadow-neu-raised text-neu-dark hover:shadow-neu-pressed transition-all duration-300 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Menu Mobile -->
            <div :class="{ 'block': open, 'hidden': ! open }" class="hidden md:hidden bg-neu-base mt-4 px-4">
                <div class="bg-neu-base shadow-neu-inset rounded-3xl p-4 space-y-2">
                    <a href="{{ url('/owner/dashboard') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Dashboard</a>
                    <a href="{{ url('/owner/venues') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Kelola Venue</a>
                    <a href="{{ url('/owner/bookings') }}" class="bg-neu-base shadow-neu-raised text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Booking</a>
                    <a href="{{ url('/owner/bookings/checkin') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Check-in QR</a>
                    <a href="{{ url('/owner/profile') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Profil Usaha</a>
                    <div class="border-t border-neu-muted/20 my-2 pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-5 py-3 text-start font-bold text-red-500">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-1 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Header & Tombol Navigasi -->
                <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                            Daftar Permintaan Booking
                        </h1>
                        <p class="mt-2 text-base font-medium text-neu-muted">
                            Berikut pemesanan yang masuk ke venue milikmu.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <a href="{{ route('owner.bookings.checkin') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-6 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            QR Check-in Scanner
                        </a>

                        <a href="{{ route('owner.dashboard') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-6 py-3.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

                <!-- Pesan Berhasil & Error -->
                @if (session('success'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-green-500/30 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-extrabold text-green-600">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-red-500/30 flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-extrabold text-red-500">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Ringkasan Statistik -->
                <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                        <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-neu-muted">Total Booking</p>
                            <h2 class="mt-1 text-3xl font-extrabold text-neu-dark">
                                {{ $bookings->total() }}
                            </h2>
                        </div>
                    </div>

                    <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                        <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-neu-muted">Halaman Saat Ini</p>
                            <h2 class="mt-1 text-3xl font-extrabold text-neu-dark">
                                {{ $bookings->currentPage() }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Daftar Booking -->
                @if ($bookings->count() > 0)
                    <div class="space-y-6">
                        @foreach ($bookings as $booking)
                            @php
                                $statusLabels = [
                                    'pending_confirmation' => 'Menunggu Konfirmasi',
                                    'confirmed' => 'Dikonfirmasi',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                    'checked_in' => 'Sudah Check-in',
                                    'completed' => 'Selesai',
                                    'expired' => 'Kedaluwarsa',
                                ];

                                $statusTextColors = [
                                    'pending_confirmation' => 'text-amber-500',
                                    'confirmed' => 'text-green-600',
                                    'rejected' => 'text-red-500',
                                    'cancelled' => 'text-neu-muted',
                                    'checked_in' => 'text-neu-primary',
                                    'completed' => 'text-purple-600',
                                    'expired' => 'text-neu-muted',
                                ];
                            @endphp

                            <div class="rounded-[28px] bg-neu-base p-6 sm:p-8 shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover">

                                <!-- Header Card Booking -->
                                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                                    <div>
                                        <span class="inline-block rounded-full bg-neu-base shadow-neu-inset px-4 py-1 text-xs font-extrabold text-neu-primary tracking-wide">
                                            {{ $booking->booking_code }}
                                        </span>

                                        <h3 class="mt-3 text-2xl font-extrabold text-neu-dark">
                                            {{ $booking->venue->name }}
                                        </h3>

                                        <p class="mt-1 text-sm font-bold text-neu-muted">
                                            {{ $booking->unit->name }}
                                        </p>
                                    </div>

                                    <div>
                                        <span class="inline-block rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider
                                            {{ $statusTextColors[$booking->booking_status] ?? 'text-neu-dark' }}">
                                            {{ $statusLabels[$booking->booking_status] ?? $booking->booking_status }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Detail Grid (Inset Cards) -->
                                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted">Nama Pemesan</p>
                                        <p class="mt-1 text-sm font-extrabold text-neu-dark">
                                            {{ $booking->user->name }}
                                        </p>
                                    </div>

                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted">Tanggal Booking</p>
                                        <p class="mt-1 text-sm font-extrabold text-neu-dark">
                                            {{ $booking->booking_date->format('d F Y') }}
                                        </p>
                                    </div>

                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted">Waktu</p>
                                        <p class="mt-1 text-sm font-extrabold text-neu-dark">
                                            {{ substr($booking->start_time, 0, 5) }}
                                            -
                                            {{ substr($booking->end_time, 0, 5) }}
                                        </p>
                                    </div>

                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted">Durasi</p>
                                        <p class="mt-1 text-sm font-extrabold text-neu-dark">
                                            {{ $booking->duration_minutes }} menit
                                        </p>
                                    </div>

                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted">Total Harga</p>
                                        <p class="mt-1 text-base font-extrabold text-neu-primary">
                                            Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted">Catatan Pemesan</p>
                                        <p class="mt-1 text-sm font-medium text-neu-dark">
                                            {{ $booking->user_notes ?: '-' }}
                                        </p>
                                    </div>

                                </div>

                                <!-- Bagian Konfirmasi Pembayaran Cash -->
                                @if (
                                    $booking->booking_status === 'confirmed' &&
                                    $booking->paymentRecord &&
                                    $booking->paymentRecord->payment_method === 'cash'
                                )
                                    <div class="mt-6 rounded-[20px] bg-neu-base shadow-neu-inset p-5 sm:p-6">
                                        <h4 class="text-sm font-extrabold text-neu-dark flex items-center gap-2">
                                            <svg class="w-5 h-5 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Pembayaran Cash
                                        </h4>

                                        @if ($booking->paymentRecord->payment_status === 'paid')
                                            <p class="mt-2 text-sm font-extrabold text-green-600">
                                                ✓ Pembayaran sudah diterima dan dikonfirmasi.
                                            </p>
                                        @elseif ($booking->paymentRecord->payment_status === 'unpaid')
                                            <p class="mt-2 text-sm font-medium text-neu-muted leading-relaxed">
                                                User memilih pembayaran Cash. Pastikan uang sudah diterima secara langsung sebelum mengonfirmasi pembayaran.
                                            </p>

                                            <form
                                                action="{{ route('owner.bookings.cash.confirm', $booking->id) }}"
                                                method="POST"
                                                class="mt-4"
                                                onsubmit="return confirm('Apakah pembayaran Cash untuk booking ini sudah benar-benar diterima?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-6 py-3 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:bg-emerald-700 active:shadow-neu-pressed"
                                                >
                                                    ✓ Konfirmasi Pembayaran Cash
                                                </button>
                                            </form>
                                        @else
                                            <p class="mt-2 text-sm font-bold text-amber-600">
                                                Status pembayaran: {{ $booking->paymentRecord->payment_status }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Tombol Aksi Terima / Tolak Booking -->
                                @if ($booking->booking_status === 'pending_confirmation')
                                    <div class="mt-6 flex flex-wrap items-center gap-4 border-t border-neu-muted/15 pt-6">

                                        <!-- Form Terima Booking -->
                                        <form action="{{ route('owner.bookings.confirm', $booking->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah kamu yakin ingin menerima booking ini?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-full bg-green-600 px-6 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:bg-green-700 active:shadow-neu-pressed">
                                                ✓ Terima Booking
                                            </button>
                                        </form>

                                        <!-- Form Tolak Booking -->
                                        <form action="{{ route('owner.bookings.reject', $booking->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah kamu yakin ingin menolak booking ini?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-6 py-3.5 text-sm font-extrabold text-red-500 transition-all duration-300 hover:shadow-neu-pressed">
                                                ✕ Tolak Booking
                                            </button>
                                        </form>

                                    </div>
                                @endif

                                <!-- Tombol Selesaikan Booking -->
                                @if ($booking->booking_status === 'checked_in')
                                    <div class="mt-6 border-t border-neu-muted/15 pt-6">
                                        <form action="{{ route('owner.bookings.complete', $booking->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah booking ini sudah benar-benar selesai?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-full bg-purple-600 px-6 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:bg-purple-700 active:shadow-neu-pressed">
                                                ✓ Selesaikan Booking
                                            </button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($bookings->hasPages())
                        <div class="mt-10">
                            <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-4">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    @endif

                @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center rounded-[28px] bg-neu-base shadow-neu-inset px-6 py-20 text-center">
                        <div class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-5xl">
                            📋
                        </div>

                        <h3 class="text-2xl font-extrabold text-neu-dark">
                            Belum Ada Booking
                        </h3>

                        <p class="mt-2 max-w-md text-sm font-medium text-neu-muted">
                            Belum ada pemesanan yang masuk ke venue milikmu.
                        </p>
                    </div>
                @endif

            </div>
        </main>
    </div>

</body>
</html>