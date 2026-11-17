<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Venue Saya - Sportix</title>
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
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Header Halaman -->
                <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-extrabold text-neu-dark tracking-tight">
                            Venue Saya
                        </h1>
                        <p class="mt-2 text-base font-medium text-neu-muted">
                            Berikut daftar venue olahraga yang Anda miliki dan kelola di Sportix.
                        </p>
                    </div>

                    <a href="{{ route('owner.venues.create') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-7 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Venue
                    </a>
                </div>

                <!-- Notifikasi Flash Message & Validasi Error -->
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

                @if ($errors->any())
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-red-500/30">
                        <ul class="list-disc pl-5 space-y-1 text-sm font-bold text-red-500">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Daftar Venue Grid -->
                @if ($venues->count() > 0)
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($venues as $venue)
                            @php
                                $primaryImage = $venue->images->first();

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

                            <!-- Card Venue (Raised 24px) -->
                            <div class="flex flex-col overflow-hidden rounded-[24px] bg-neu-base shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover p-4">

                                <!-- Bingkai Foto Utama (Inset 16px) -->
                                <div class="relative h-52 w-full rounded-[16px] bg-neu-base shadow-neu-inset p-2">
                                    <div class="relative h-full w-full overflow-hidden rounded-[12px]">
                                        @if ($primaryImage)
                                            <img
                                                src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                                alt="Foto {{ $venue->name }}"
                                                class="h-full w-full object-cover transition-transform duration-700 hover:scale-110"
                                            >
                                        @else
                                            <div class="flex h-full flex-col items-center justify-center bg-neu-base text-neu-muted">
                                                <span class="text-5xl mb-2 drop-shadow-sm">🏟️</span>
                                                <span class="text-xs font-bold">Belum ada foto venue</span>
                                            </div>
                                        @endif

                                        <!-- Pill Kategori Olahraga -->
                                        <span class="absolute left-3 top-3 rounded-full bg-neu-base shadow-neu-raised px-3.5 py-1 text-xs font-extrabold text-neu-primary">
                                            {{ $venue->sport->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Konten Card -->
                                <div class="flex flex-col flex-grow pt-5 pb-2 px-2">

                                    <h2 class="text-xl font-extrabold text-neu-dark mb-1">
                                        {{ $venue->name }}
                                    </h2>

                                    <p class="mb-5 text-sm font-medium text-neu-muted flex items-start gap-1.5">
                                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $venue->city }}, {{ $venue->province }}
                                    </p>

                                    <!-- Panel Status (Inset) -->
                                    <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-4 space-y-3 mb-5">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-neu-muted">Status Venue</span>
                                            <span class="rounded-full bg-neu-base shadow-neu-raised px-3 py-1 text-xs font-extrabold {{ $vBadgeClass }}">
                                                {{ ucfirst($venue->venue_status) }}
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between border-t border-neu-muted/15 pt-3">
                                            <span class="text-xs font-bold text-neu-muted">Status Verifikasi</span>
                                            <span class="rounded-full bg-neu-base shadow-neu-raised px-3 py-1 text-xs font-extrabold {{ $verBadgeClass }}">
                                                {{ ucfirst($venue->verification_status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Pesan Peringatan Jika Belum Terverifikasi / Ditangguhkan -->
                                    @if ($venue->verification_status !== 'verified')
                                        <div class="mb-5 rounded-[14px] bg-neu-base shadow-neu-inset p-3 border border-amber-500/30">
                                            <p class="text-xs font-bold text-amber-600 leading-relaxed">
                                                ⚠️ Venue belum dapat diaktifkan karena belum diverifikasi Admin.
                                            </p>
                                        </div>
                                    @elseif ($venue->venue_status === 'suspended')
                                        <div class="mb-5 rounded-[14px] bg-neu-base shadow-neu-inset p-3 border border-red-500/30">
                                            <p class="text-xs font-bold text-red-500 leading-relaxed">
                                                ⛔ Venue sedang ditangguhkan oleh Admin.
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Tombol Aksi (Detail, Edit, & Toggle Status) -->
                                    <div class="mt-auto space-y-3 pt-2">
                                        <div class="grid grid-cols-2 gap-3">
                                            <a href="{{ route('owner.venues.show', $venue->id) }}"
                                               class="block w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-3 text-center text-xs font-extrabold text-neu-primary transition-all duration-300 hover:shadow-neu-pressed">
                                                Detail
                                            </a>

                                            <a href="{{ route('owner.venues.edit', $venue->id) }}"
                                               class="block w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-3 text-center text-xs font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                                                Edit
                                            </a>
                                        </div>

                                        @if ($venue->verification_status === 'verified'
                                            && in_array($venue->venue_status, ['active', 'inactive']))

                                            <form action="{{ route('owner.venues.status', $venue->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                @if ($venue->venue_status === 'active')
                                                    <input type="hidden" name="venue_status" value="inactive">
                                                    <button type="submit"
                                                            class="w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-3 text-xs font-extrabold text-red-500 transition-all duration-300 hover:shadow-neu-pressed">
                                                        Nonaktifkan Venue
                                                    </button>
                                                @else
                                                    <input type="hidden" name="venue_status" value="active">
                                                    <button type="submit"
                                                            class="w-full rounded-full bg-neu-primary px-4 py-3 text-xs font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                                        Aktifkan Venue
                                                    </button>
                                                @endif
                                            </form>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($venues->hasPages())
                        <div class="mt-12">
                            <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-4">
                                {{ $venues->links() }}
                            </div>
                        </div>
                    @endif

                @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center rounded-[28px] bg-neu-base shadow-neu-inset px-6 py-20 text-center">
                        <div class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-5xl">
                            🏟️
                        </div>

                        <h3 class="text-2xl font-extrabold text-neu-dark">
                            Anda belum memiliki venue
                        </h3>

                        <p class="mt-2 max-w-md text-sm font-medium text-neu-muted">
                            Mulai daftarkan venue olahraga Anda sekarang untuk mengelola unit lapangan, jadwal, dan menerima reservasi.
                        </p>

                        <a href="{{ route('owner.venues.create') }}"
                           class="mt-8 inline-flex items-center gap-2 rounded-full bg-neu-primary px-8 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                            + Tambah Venue Sekarang
                        </a>
                    </div>
                @endif

            </div>
        </main>
    </div>

</body>
</html>