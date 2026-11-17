<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Owner - Sportix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neu-base text-neu-dark antialiased selection:bg-neu-primary selection:text-white">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar Mandiri Khusus Owner -->
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
                               class="bg-neu-base shadow-neu-raised text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Dashboard
                            </a>
                            <a href="{{ url('/owner/venues') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Kelola Venue
                            </a>
                            <a href="{{ url('/owner/bookings') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
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
                    <a href="{{ url('/owner/dashboard') }}" class="bg-neu-base shadow-neu-raised text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Dashboard</a>
                    <a href="{{ url('/owner/venues') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Kelola Venue</a>
                    <a href="{{ url('/owner/bookings') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Booking</a>
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

                <!-- Header Banner Selamat Datang -->
                <div class="mb-10 rounded-[32px] bg-neu-base p-8 sm:p-10 shadow-neu-raised flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <span class="inline-block rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold text-neu-primary mb-3">
                            👋 Portal Mitra Venue
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                            Selamat datang, {{ Auth::user()->name }}!
                        </h1>
                        <p class="mt-2 text-sm sm:text-base font-medium text-neu-muted">
                            Pantau performa venue, status verifikasi, dan kelola jadwal operasional olahraga Anda di Sportix.
                        </p>
                    </div>

                    <!-- Aksi Cepat Owner -->
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <a href="{{ url('/owner/bookings/checkin') }}"
                           class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-6 py-3.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                            <svg class="w-5 h-5 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            Scan QR Check-in
                        </a>

                        <a href="{{ url('/owner/venues/create') }}"
                           class="inline-flex items-center gap-2 rounded-full bg-neu-primary px-6 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Venue
                        </a>
                    </div>
                </div>

                <!-- Section: Ringkasan Venue (4 Kartu Statistik Neumorphism) -->
                <section class="mb-12">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-neu-dark">
                            Ringkasan Venue
                        </h2>
                        <p class="mt-1 text-sm font-medium text-neu-muted">
                            Statistik status seluruh venue yang terdaftar di akun Anda.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                        <!-- Card 1: Total Venue -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-neu-muted uppercase tracking-wider">Total Venue</p>
                                <p class="mt-1 text-3xl font-extrabold text-neu-dark">{{ $totalVenues }}</p>
                            </div>
                        </div>

                        <!-- Card 2: Venue Aktif -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-neu-muted uppercase tracking-wider">Venue Aktif</p>
                                <p class="mt-1 text-3xl font-extrabold text-green-600">{{ $activeVenues }}</p>
                            </div>
                        </div>

                        <!-- Card 3: Menunggu Verifikasi -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-amber-500 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-neu-muted uppercase tracking-wider">Menunggu Verifikasi</p>
                                <p class="mt-1 text-3xl font-extrabold text-amber-500">{{ $pendingVenues }}</p>
                            </div>
                        </div>

                        <!-- Card 4: Ditolak -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-red-500 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-neu-muted uppercase tracking-wider">Ditolak</p>
                                <p class="mt-1 text-3xl font-extrabold text-red-500">{{ $rejectedVenues }}</p>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Section: Daftar Venue Saya -->
                <section>
                    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-extrabold text-neu-dark">
                                Daftar Venue Saya
                            </h2>
                            <p class="mt-1 text-sm font-medium text-neu-muted">
                                Kelola detail venue, unit lapangan, jam operasional, dan harga sewa.
                            </p>
                        </div>

                        <a href="{{ url('/owner/venues') }}"
                           class="inline-flex items-center gap-1.5 text-sm font-extrabold text-neu-primary hover:underline">
                            Lihat Semua Pengelolaan Venue
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    @if ($venues->count() > 0)
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($venues as $venue)
                                @php
                                    // Penentuan warna badge status venue
                                    $vStatus = strtolower($venue->venue_status ?? '');
                                    $vBadgeClass = match ($vStatus) {
                                        'active', 'aktif' => 'text-green-600',
                                        'inactive', 'nonaktif' => 'text-red-500',
                                        default => 'text-neu-dark',
                                    };

                                    // Penentuan warna badge status verifikasi
                                    $verStatus = strtolower($venue->verification_status ?? '');
                                    $verBadgeClass = match ($verStatus) {
                                        'verified', 'approved', 'terverifikasi' => 'text-green-600',
                                        'pending', 'menunggu' => 'text-amber-500',
                                        'rejected', 'ditolak' => 'text-red-500',
                                        default => 'text-neu-muted',
                                    };
                                @endphp

                                <div class="flex flex-col justify-between rounded-[24px] bg-neu-base p-6 shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover">
                                    <div>
                                        <!-- Header Card: Kategori Olahraga -->
                                        <div class="mb-4 flex items-center justify-between gap-2">
                                            <span class="rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold text-neu-primary">
                                                {{ $venue->sport->name ?? '-' }}
                                            </span>
                                        </div>

                                        <!-- Nama Venue -->
                                        <h3 class="text-xl font-extrabold text-neu-dark mb-4">
                                            {{ $venue->name }}
                                        </h3>

                                        <!-- Detail Status (Inset Panel) -->
                                        <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4 space-y-3 mb-6">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-neu-muted">Status Venue</span>
                                                <span class="rounded-full bg-neu-base shadow-neu-raised px-3 py-1 text-xs font-extrabold uppercase {{ $vBadgeClass }}">
                                                    {{ $venue->venue_status }}
                                                </span>
                                            </div>

                                            <div class="flex items-center justify-between border-t border-neu-muted/15 pt-3">
                                                <span class="text-xs font-bold text-neu-muted">Status Verifikasi</span>
                                                <span class="rounded-full bg-neu-base shadow-neu-raised px-3 py-1 text-xs font-extrabold uppercase {{ $verBadgeClass }}">
                                                    {{ $venue->verification_status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi ke Detail Venue Owner -->
                                    <a href="{{ url('/owner/venues/' . $venue->id) }}"
                                       class="block w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-3 text-center text-sm font-extrabold text-neu-primary transition-all duration-300 hover:shadow-neu-pressed">
                                        Kelola Venue Ini
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State jika Owner belum memiliki venue -->
                        <div class="flex flex-col items-center justify-center rounded-[28px] bg-neu-base shadow-neu-inset px-6 py-16 text-center">
                            <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-neu-primary">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-extrabold text-neu-dark">
                                Anda belum memiliki venue
                            </h3>
                            <p class="mt-2 max-w-md text-sm font-medium text-neu-muted">
                                Daftarkan venue olahraga pertama Anda sekarang untuk mulai menerima pemesanan lapangan dari pengguna Sportix.
                            </p>
                            <a href="{{ url('/owner/venues/create') }}"
                               class="mt-6 inline-flex items-center gap-2 rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                + Daftarkan Venue Pertama
                            </a>
                        </div>
                    @endif
                </section>

            </div>
        </main>
    </div>

</body>
</html>