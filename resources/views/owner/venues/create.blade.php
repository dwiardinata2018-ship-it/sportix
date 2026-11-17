<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Venue - Sportix</title>
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
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

                <!-- Tombol Kembali -->
                <div class="mb-8">
                    <a href="{{ route('owner.venues.index') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Venue
                    </a>
                </div>

                <!-- Header Halaman -->
                <div class="mb-10">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                        Daftarkan Venue Baru
                    </h1>
                    <p class="mt-2 text-base font-medium text-neu-muted">
                        Lengkapi informasi venue olahraga Anda agar dapat diverifikasi dan dipesan oleh pengguna Sportix.
                    </p>
                </div>

                <!-- Validasi Error Global (Jika ada) -->
                @if ($errors->any())
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-red-500/30">
                        <p class="text-sm font-extrabold text-red-500 mb-2">Mohon periksa kembali input Anda:</p>
                        <ul class="list-disc pl-5 space-y-1 text-xs font-bold text-red-500">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('owner.venues.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- SECTION 1: Foto Venue -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <div class="mb-5">
                            <h2 class="text-xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Foto Venue
                            </h2>
                            <p class="mt-1 text-sm font-medium text-neu-muted">
                                Unggah foto venue (JPG, PNG, atau WEBP) untuk ditampilkan kepada pengguna Sportix. Dapat memilih lebih dari satu foto.
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Pilih Foto Venue</label>
                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <input
                                    type="file"
                                    name="images[]"
                                    accept="image/jpeg,image/png,image/webp"
                                    multiple
                                    class="w-full text-sm font-bold text-neu-dark file:mr-4 file:rounded-full file:border-0 file:bg-neu-primary file:px-5 file:py-2.5 file:text-xs file:font-extrabold file:text-white hover:file:bg-neu-primary-dark file:cursor-pointer cursor-pointer"
                                >
                            </div>

                            @error('images')
                                <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                            @enderror

                            @error('images.*')
                                <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <!-- SECTION 2: Informasi Venue -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Informasi Venue
                        </h2>

                        <div class="space-y-6">
                            <!-- Nama Venue -->
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Nama Venue <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       placeholder="Contoh: Sportix Arena Futsal & Badminton"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                @error('name')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori Olahraga & Tipe Venue -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <!-- Kategori Olahraga -->
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kategori Olahraga <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="sport_id" required
                                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none appearance-none cursor-pointer"
                                                style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;">
                                            <option value="">Pilih Olahraga</option>
                                            @foreach ($sports as $sport)
                                                <option value="{{ $sport->id }}"
                                                    {{ old('sport_id') == $sport->id ? 'selected' : '' }}>
                                                    {{ $sport->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-neu-muted">
                                            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('sport_id')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tipe Venue -->
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Tipe Venue <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="venue_type" required
                                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none appearance-none cursor-pointer"
                                                style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;">
                                            <option value="indoor" {{ old('venue_type') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                            <option value="outdoor" {{ old('venue_type') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                            <option value="mixed" {{ old('venue_type') == 'mixed' ? 'selected' : '' }}>Mixed</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-neu-muted">
                                            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('venue_type')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deskripsi Venue -->
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Deskripsi Venue</label>
                                <textarea name="description" rows="4"
                                          placeholder="Jelaskan fasilitas unggulan, jenis lantai lapangan, area parkir, dll..."
                                          class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-medium text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none resize-none">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 3: Alamat Venue -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Venue
                        </h2>

                        <div class="space-y-6">
                            <!-- Alamat Lengkap -->
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="3" required
                                          placeholder="Nama jalan, nomor bangunan, patokan lokasi..."
                                          class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-medium text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none resize-none">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Desa & Kecamatan -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Desa / Kelurahan</label>
                                    <input type="text" name="village" value="{{ old('village') }}"
                                           placeholder="Contoh: Jimbaran"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('village')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kecamatan</label>
                                    <input type="text" name="district" value="{{ old('district') }}"
                                           placeholder="Contoh: Kuta Selatan"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('district')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kota, Provinsi, Kode Pos -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kota / Kabupaten <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                           placeholder="Contoh: Badung"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('city')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Provinsi <span class="text-red-500">*</span></label>
                                    <input type="text" name="province" value="{{ old('province') }}" required
                                           placeholder="Contoh: Bali"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('province')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kode Pos</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                           placeholder="Contoh: 80361"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('postal_code')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 4: Informasi Kontak -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Informasi Kontak
                        </h2>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Nomor WhatsApp</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}"
                                       placeholder="Contoh: 081234567890"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                @error('whatsapp_number')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Link Instagram</label>
                                <input type="url" name="instagram_url" value="{{ old('instagram_url') }}"
                                       placeholder="https://instagram.com/namavenue"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                @error('instagram_url')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 5: Koordinat Lokasi (Opsional) -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <div class="mb-6">
                            <h2 class="text-xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                Koordinat Lokasi <span class="text-xs font-bold text-neu-muted uppercase ml-1">(Opsional)</span>
                            </h2>
                            <p class="mt-1 text-sm font-medium text-neu-muted">
                                Masukkan titik koordinat Google Maps jika ingin lokasi venue tampil presisi di peta.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Latitude</label>
                                <input type="number" step="any" name="latitude" value="{{ old('latitude') }}"
                                       placeholder="Contoh: -8.798501"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                @error('latitude')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Longitude</label>
                                <input type="number" step="any" name="longitude" value="{{ old('longitude') }}"
                                       placeholder="Contoh: 115.172421"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                @error('longitude')
                                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Tombol Submit & Batal -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-2 pb-8">
                        <a href="{{ route('owner.venues.index') }}"
                           class="w-full sm:w-auto rounded-full bg-neu-base shadow-neu-raised px-8 py-4 text-center text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-red-500">
                            Batal
                        </a>

                        <button type="submit"
                                class="w-full sm:w-auto rounded-full bg-neu-primary px-10 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                            Daftarkan Venue
                        </button>
                    </div>

                </form>

            </div>
        </main>
    </div>

</body>
</html>