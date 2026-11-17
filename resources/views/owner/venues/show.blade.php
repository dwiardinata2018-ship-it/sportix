<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Venue - {{ $venue->name }} - Sportix</title>
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
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Dashboard
                            </a>
                            <a href="{{ route('owner.venues.index') }}"
                               class="bg-neu-base shadow-neu-raised text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
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
                    <a href="{{ url('/owner/dashboard') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Dashboard</a>
                    <a href="{{ route('owner.venues.index') }}" class="bg-neu-base shadow-neu-raised text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Kelola Venue</a>
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
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <!-- Top Navigation & Action Bar -->
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <a href="{{ route('owner.venues.index') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary w-fit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Venue Saya
                    </a>

                    <a href="{{ route('owner.venues.edit', $venue->id) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark w-fit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Venue
                    </a>
                </div>

                @php
                    $vStatus = strtolower($venue->venue_status ?? '');
                    $vBadgeClass = match ($vStatus) {
                        'active' => 'text-green-600',
                        'inactive' => 'text-neu-muted',
                        'suspended' => 'text-red-500',
                        default => 'text-neu-dark',
                    };

                    $verStatus = strtolower($venue->verification_status ?? '');
                    $verBadgeClass = match ($verStatus) {
                        'verified' => 'text-green-600',
                        'pending' => 'text-amber-500',
                        'rejected' => 'text-red-500',
                        default => 'text-neu-muted',
                    };
                @endphp

                <!-- Header Card Venue -->
                <section class="mb-8 rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold text-neu-primary">
                            {{ $venue->sport->name ?? '-' }}
                        </span>
                        <span class="rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold text-neu-dark">
                            {{ ucfirst($venue->venue_type) }}
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight mb-4">
                        {{ $venue->name }}
                    </h1>

                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">Deskripsi Venue</p>
                        <p class="text-sm sm:text-base font-medium text-neu-dark leading-relaxed">
                            {{ $venue->description ?? 'Belum ada deskripsi.' }}
                        </p>
                    </div>
                </section>

                <!-- Galeri Foto -->
                <section class="mb-8 rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                    <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                        <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Galeri Foto
                    </h2>

                    @if ($venue->images->count() > 0)
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($venue->images as $image)
                                <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-2.5">
                                    <div class="relative h-48 w-full overflow-hidden rounded-[14px]">
                                        <img
                                            src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $image->caption ?? $venue->name }}"
                                            class="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                                        >

                                        @if ($image->is_primary)
                                            <span class="absolute top-3 left-3 rounded-full bg-neu-primary px-3.5 py-1 text-xs font-extrabold text-white shadow-md">
                                                ★ Foto Utama
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-8 text-center">
                            <p class="text-sm font-bold text-neu-muted">Belum ada foto venue.</p>
                        </div>
                    @endif
                </section>

                <!-- Grid 2 Kolom: Lokasi & Kontak / Status -->
                <div class="mb-8 grid grid-cols-1 gap-8 lg:grid-cols-3">

                    <!-- Informasi Lokasi (2 Kolom) -->
                    <section class="lg:col-span-2 rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Informasi Lokasi
                        </h2>

                        <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-5 mb-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">Alamat Lengkap</p>
                            <p class="text-sm font-extrabold text-neu-dark">{{ $venue->address }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <p class="text-xs font-bold text-neu-muted">Kelurahan/Desa</p>
                                <p class="mt-1 text-sm font-extrabold text-neu-dark">{{ $venue->village ?? '-' }}</p>
                            </div>

                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <p class="text-xs font-bold text-neu-muted">Kecamatan</p>
                                <p class="mt-1 text-sm font-extrabold text-neu-dark">{{ $venue->district ?? '-' }}</p>
                            </div>

                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <p class="text-xs font-bold text-neu-muted">Kota</p>
                                <p class="mt-1 text-sm font-extrabold text-neu-dark">{{ $venue->city }}</p>
                            </div>

                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <p class="text-xs font-bold text-neu-muted">Provinsi</p>
                                <p class="mt-1 text-sm font-extrabold text-neu-dark">{{ $venue->province }}</p>
                            </div>

                            <div class="sm:col-span-2 rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <p class="text-xs font-bold text-neu-muted">Kode Pos</p>
                                <p class="mt-1 text-sm font-extrabold text-neu-dark">{{ $venue->postal_code ?? '-' }}</p>
                            </div>
                        </div>
                    </section>

                    <!-- Kolom Kanan: Status Venue & Informasi Kontak -->
                    <div class="space-y-8">
                        <!-- Status Venue -->
                        <section class="rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                            <h2 class="mb-5 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status Venue
                            </h2>

                            <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-neu-muted">Status Venue</span>
                                    <span class="rounded-full bg-neu-base shadow-neu-raised px-3.5 py-1 text-xs font-extrabold uppercase {{ $vBadgeClass }}">
                                        {{ $venue->venue_status }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between border-t border-neu-muted/15 pt-3">
                                    <span class="text-xs font-bold text-neu-muted">Status Verifikasi</span>
                                    <span class="rounded-full bg-neu-base shadow-neu-raised px-3.5 py-1 text-xs font-extrabold uppercase {{ $verBadgeClass }}">
                                        {{ $venue->verification_status }}
                                    </span>
                                </div>
                            </div>
                        </section>

                        <!-- Informasi Kontak -->
                        <section class="rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                            <h2 class="mb-5 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Informasi Kontak
                            </h2>

                            <div class="space-y-4">
                                <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                    <p class="text-xs font-bold text-neu-muted">WhatsApp</p>
                                    <p class="mt-1 text-sm font-extrabold text-neu-dark break-all">{{ $venue->whatsapp_number ?? '-' }}</p>
                                </div>

                                <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                    <p class="text-xs font-bold text-neu-muted">Instagram</p>
                                    <p class="mt-1 text-sm font-extrabold text-neu-dark break-all">{{ $venue->instagram_url ?? '-' }}</p>
                                </div>
                            </div>
                        </section>
                    </div>

                </div>

                <!-- Unit Lapangan -->
                <section class="mb-8 rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                    <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                        <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Unit Lapangan
                    </h2>

                    @if ($venue->units->count() > 0)
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($venue->units as $unit)
                                <div class="rounded-[20px] bg-neu-base shadow-neu-raised p-5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-start justify-between gap-2 mb-3">
                                            <h3 class="text-lg font-extrabold text-neu-dark">{{ $unit->name }}</h3>
                                            <span class="rounded-full bg-neu-base shadow-neu-inset px-3 py-1 text-xs font-extrabold {{ $unit->is_active ? 'text-green-600' : 'text-red-500' }} shrink-0">
                                                {{ $unit->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>

                                        <div class="rounded-[14px] bg-neu-base shadow-neu-inset p-4 space-y-2 text-xs">
                                            <div class="flex justify-between">
                                                <span class="font-bold text-neu-muted">Jenis Unit</span>
                                                <span class="font-extrabold text-neu-dark">{{ $unit->unit_type }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="font-bold text-neu-muted">Kapasitas</span>
                                                <span class="font-extrabold text-neu-dark">{{ $unit->capacity ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between border-t border-neu-muted/15 pt-2">
                                                <span class="font-bold text-neu-muted">Harga Default</span>
                                                <span class="font-extrabold text-neu-primary">Rp{{ number_format($unit->default_price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-8 text-center">
                            <p class="text-sm font-bold text-neu-muted">Belum ada unit lapangan.</p>
                        </div>
                    @endif
                </section>

                <!-- Grid 3 Kolom: Fasilitas, Jam Operasional, Aturan Harga -->
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 mb-8">

                    <!-- Fasilitas -->
                    <section class="rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-5 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Fasilitas
                        </h2>

                        @if ($venue->facilities->count() > 0)
                            <div class="flex flex-wrap gap-2.5">
                                @foreach ($venue->facilities as $facility)
                                    <span class="rounded-full bg-neu-base shadow-neu-inset px-4 py-2 text-xs font-extrabold text-neu-dark">
                                        {{ $facility->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-6 text-center">
                                <p class="text-sm font-bold text-neu-muted">Belum ada fasilitas.</p>
                            </div>
                        @endif
                    </section>

                    <!-- Jam Operasional -->
                    <section class="rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-5 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Jam Operasional
                        </h2>

                        @php
                            $days = [
                                1 => 'Senin',
                                2 => 'Selasa',
                                3 => 'Rabu',
                                4 => 'Kamis',
                                5 => 'Jumat',
                                6 => 'Sabtu',
                                7 => 'Minggu',
                            ];
                        @endphp

                        @if ($venue->operatingHours->count() > 0)
                            <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4 space-y-2.5">
                                @foreach ($venue->operatingHours->sortBy('weekday') as $hour)
                                    <div class="flex items-center justify-between text-xs border-b border-neu-muted/15 pb-2 last:border-none last:pb-0">
                                        <span class="font-extrabold text-neu-dark">{{ $days[$hour->weekday] ?? 'Hari tidak diketahui' }}</span>
                                        @if ($hour->is_closed)
                                            <span class="font-extrabold text-red-500">Tutup</span>
                                        @else
                                            <span class="font-bold text-neu-primary">
                                                {{ substr($hour->open_time, 0, 5) }} - {{ substr($hour->close_time, 0, 5) }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-6 text-center">
                                <p class="text-sm font-bold text-neu-muted">Jam operasional belum diatur.</p>
                            </div>
                        @endif
                    </section>

                    <!-- Aturan Harga -->
                    <section class="rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-5 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aturan Harga
                        </h2>

                        @if ($venue->pricingRules->count() > 0)
                            <div class="space-y-3">
                                @foreach ($venue->pricingRules as $rule)
                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4">
                                        <div class="flex items-start justify-between gap-2 mb-1">
                                            <p class="text-sm font-extrabold text-neu-dark">{{ $rule->name }}</p>
                                            <span class="text-[11px] font-extrabold {{ $rule->is_active ? 'text-green-600' : 'text-red-500' }}">
                                                {{ $rule->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                        <p class="text-xs font-extrabold text-neu-primary">
                                            Rp{{ number_format($rule->price_per_hour, 0, ',', '.') }}/jam
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-6 text-center">
                                <p class="text-sm font-bold text-neu-muted">Belum ada aturan harga.</p>
                            </div>
                        @endif
                    </section>

                </div>

            </div>
        </main>
    </div>

</body>
</html>