<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Owner - Sportix</title>
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
                               class="bg-neu-base shadow-neu-raised text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
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
                    <a href="{{ url('/owner/bookings') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Booking</a>
                    <a href="{{ url('/owner/bookings/checkin') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Check-in QR</a>
                    <a href="{{ url('/owner/profile') }}" class="bg-neu-base shadow-neu-raised text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Profil Usaha</a>
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
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

                <!-- Tombol Kembali -->
                <div class="mb-8">
                    <a href="{{ route('owner.dashboard') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>

                <!-- Header Halaman -->
                <div class="mb-10">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                        Profil Owner
                    </h1>
                    <p class="mt-2 text-base font-medium text-neu-muted">
                        Lengkapi identitas dan informasi usaha untuk proses verifikasi Sportix.
                    </p>
                </div>

                {{-- Pesan berhasil --}}
                @if (session('success'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-green-500/30 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-extrabold text-green-600">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Pesan kesalahan validasi --}}
                @if ($errors->any())
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-red-500/30">
                        <p class="text-sm font-extrabold text-red-500 mb-2">Terjadi kesalahan:</p>
                        <ul class="list-disc pl-5 space-y-1 text-xs font-bold text-red-500">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Card 1: Status Verifikasi Profil --}}
                <section class="mb-8 rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                    <h2 class="mb-5 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                        <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Status Verifikasi Profil
                    </h2>

                    @if ($profile)
                        @php
                            $statusBadgeColor = match ($profile->verification_status) {
                                'verified' => 'text-green-600',
                                'pending' => 'text-amber-500',
                                'rejected' => 'text-red-500',
                                default => 'text-neu-muted',
                            };
                        @endphp

                        <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-5">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-neu-muted">Status Saat Ini</span>
                                <span class="rounded-full bg-neu-base shadow-neu-raised px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider {{ $statusBadgeColor }}">
                                    {{ ucfirst($profile->verification_status) }}
                                </span>
                            </div>

                            @if ($profile->verification_status === 'rejected' && $profile->verification_notes)
                                <div class="mt-4 rounded-[14px] bg-neu-base shadow-neu-raised p-4 border-l-4 border-red-500">
                                    <p class="text-xs font-extrabold uppercase tracking-wider text-red-500">Catatan dari Admin:</p>
                                    <p class="mt-1.5 text-sm font-medium text-neu-dark leading-relaxed">
                                        {{ $profile->verification_notes }}
                                    </p>
                                </div>
                            @elseif ($profile->verification_status === 'pending')
                                <p class="mt-4 text-sm font-medium text-amber-600">
                                    ⏳ Profil sedang menunggu pemeriksaan Admin.
                                </p>
                            @elseif ($profile->verification_status === 'verified')
                                <p class="mt-4 text-sm font-extrabold text-green-600">
                                    ✓ Profil usaha Anda telah berhasil diverifikasi.
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="rounded-[18px] bg-neu-base shadow-neu-inset p-5">
                            <p class="text-sm font-bold text-neu-muted">
                                Anda belum mengirimkan profil untuk diverifikasi. Silakan lengkapi formulir di bawah ini.
                            </p>
                        </div>
                    @endif
                </section>

                {{-- Card 2: Form Informasi Usaha dan Identitas --}}
                <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8 mb-8">
                    <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                        <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Informasi Usaha dan Identitas
                    </h2>

                    <form
                        action="{{ route('owner.profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')

                        <!-- Nama Usaha -->
                        <div>
                            <label for="business_name" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                Nama Usaha / Nama Tempat Olahraga <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="business_name"
                                name="business_name"
                                value="{{ old('business_name', $profile?->business_name) }}"
                                maxlength="150"
                                placeholder="Contoh: Sportix Badminton Center"
                                required
                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none"
                            >
                        </div>

                        <!-- Nomor Identitas (NIK) -->
                        <div>
                            <label for="identity_number" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                Nomor Identitas (NIK) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="identity_number"
                                name="identity_number"
                                value="{{ old('identity_number', $profile?->identity_number) }}"
                                maxlength="50"
                                placeholder="Masukkan nomor identitas"
                                required
                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none"
                            >
                        </div>

                        <!-- Dokumen Identitas -->
                        <div>
                            <label for="identity_document" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                Dokumen Identitas {!! $profile?->identity_document_path ? '' : '<span class="text-red-500">*</span>' !!}
                            </label>

                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <input
                                    type="file"
                                    id="identity_document"
                                    name="identity_document"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    {{ $profile?->identity_document_path ? '' : 'required' }}
                                    class="w-full text-sm font-bold text-neu-dark file:mr-4 file:rounded-full file:border-0 file:bg-neu-primary file:px-5 file:py-2.5 file:text-xs file:font-extrabold file:text-white hover:file:bg-neu-primary-dark file:cursor-pointer cursor-pointer"
                                >
                            </div>

                            <p class="mt-2 text-xs font-medium text-neu-muted ml-1">
                                Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                            </p>

                            @if ($profile?->identity_document_path)
                                <div class="mt-4 rounded-[16px] bg-neu-base shadow-neu-inset p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div>
                                        <p class="text-xs font-bold text-neu-muted">Dokumen saat ini:</p>
                                        <p class="mt-0.5 text-sm font-extrabold text-neu-primary break-all">
                                            📄 {{ basename($profile->identity_document_path) }}
                                        </p>
                                    </div>
                                    <span class="text-xs font-medium text-neu-muted">
                                        Kosongkan jika tidak ingin mengganti dokumen.
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Submit -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full sm:w-auto rounded-full bg-neu-primary px-8 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                                Simpan dan Kirim Verifikasi
                            </button>
                        </div>

                    </form>
                </section>

            </div>
        </main>
    </div>

</body>
</html>