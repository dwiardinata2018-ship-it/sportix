<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Venue - Sportix</title>
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
                    <a href="{{ route('owner.venues.show', $venue->id) }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Detail Venue
                    </a>
                </div>

                <!-- Header Halaman -->
                <div class="mb-10">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                        Edit Venue
                    </h1>
                    <p class="mt-2 text-base font-medium text-neu-muted">
                        Perbarui detail informasi, alamat, kontak, serta galeri foto untuk <strong class="text-neu-dark">{{ $venue->name }}</strong>.
                    </p>
                </div>

                <!-- Notifikasi Flash Message -->
                @if (session('success'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-green-500/30 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-extrabold text-green-600">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Validasi Error -->
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

                <!-- FORM EDIT VENUE -->
                <form method="POST"
                      action="{{ route('owner.venues.update', $venue->id) }}"
                      enctype="multipart/form-data"
                      class="space-y-8">

                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: Informasi Venue -->
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
                                <input type="text" name="name"
                                       value="{{ old('name', $venue->name) }}" required
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                            </div>

                            <!-- Olahraga & Jenis Venue -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Olahraga <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="sport_id" required
                                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none appearance-none cursor-pointer"
                                                style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;">
                                            @foreach ($sports as $sport)
                                                <option value="{{ $sport->id }}"
                                                    {{ old('sport_id', $venue->sport_id) == $sport->id ? 'selected' : '' }}>
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
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Jenis Venue <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="venue_type" required
                                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none appearance-none cursor-pointer"
                                                style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;">
                                            <option value="indoor" {{ old('venue_type', $venue->venue_type) == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                            <option value="outdoor" {{ old('venue_type', $venue->venue_type) == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                            <option value="mixed" {{ old('venue_type', $venue->venue_type) == 'mixed' ? 'selected' : '' }}>Mixed</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-neu-muted">
                                            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Deskripsi</label>
                                <textarea name="description" rows="4"
                                          class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-medium text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none resize-none">{{ old('description', $venue->description) }}</textarea>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 2: Informasi Lokasi -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Informasi Lokasi
                        </h2>

                        <div class="space-y-6">
                            <!-- Alamat -->
                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Alamat <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="3" required
                                          class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-medium text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none resize-none">{{ old('address', $venue->address) }}</textarea>
                            </div>

                            <!-- Kelurahan/Desa & Kecamatan -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kelurahan/Desa</label>
                                    <input type="text" name="village"
                                           value="{{ old('village', $venue->village) }}"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kecamatan</label>
                                    <input type="text" name="district"
                                           value="{{ old('district', $venue->district) }}"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>
                            </div>

                            <!-- Kota, Provinsi, Kode Pos -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                    <input type="text" name="city"
                                           value="{{ old('city', $venue->city) }}" required
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Provinsi <span class="text-red-500">*</span></label>
                                    <input type="text" name="province"
                                           value="{{ old('province', $venue->province) }}" required
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Kode Pos</label>
                                    <input type="text" name="postal_code"
                                           value="{{ old('postal_code', $venue->postal_code) }}"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>
                            </div>

                            <!-- Latitude & Longitude -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 border-t border-neu-muted/15 pt-6">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Latitude</label>
                                    <input type="number" step="any" name="latitude"
                                           value="{{ old('latitude', $venue->latitude) }}"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Longitude</label>
                                    <input type="number" step="any" name="longitude"
                                           value="{{ old('longitude', $venue->longitude) }}"
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 3: Informasi Kontak -->
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
                                <input type="text" name="whatsapp_number"
                                       value="{{ old('whatsapp_number', $venue->whatsapp_number) }}"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Instagram URL</label>
                                <input type="url" name="instagram_url"
                                       value="{{ old('instagram_url', $venue->instagram_url) }}"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 4: Tambah Foto Baru -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8">
                        <div class="mb-5">
                            <h2 class="text-xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Foto Baru
                            </h2>
                            <p class="mt-1 text-sm font-medium text-neu-muted">
                                Foto baru akan ditambahkan ke galeri. Foto lama tidak akan terhapus otomatis.
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Tambah Foto (maksimal 5 foto)</label>
                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple
                                       class="w-full text-sm font-bold text-neu-dark file:mr-4 file:rounded-full file:border-0 file:bg-neu-primary file:px-5 file:py-2.5 file:text-xs file:font-extrabold file:text-white hover:file:bg-neu-primary-dark file:cursor-pointer cursor-pointer">
                            </div>
                        </div>
                    </section>

                    <!-- Tombol Submit Utama -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-2">
                        <a href="{{ route('owner.venues.show', $venue->id) }}"
                           class="w-full sm:w-auto rounded-full bg-neu-base shadow-neu-raised px-8 py-4 text-center text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-red-500">
                            Batal
                        </a>

                        <button type="submit"
                                class="w-full sm:w-auto rounded-full bg-neu-primary px-10 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
                <!-- BATAS FORM EDIT VENUE -->

                <!-- SECTION 5: Foto Venue Saat Ini (Terpisah dari form utama) -->
                <section class="mt-12 rounded-[24px] bg-neu-base shadow-neu-raised p-6 sm:p-8 mb-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Foto Venue Saat Ini
                        </h2>
                        <p class="mt-1 text-sm font-medium text-neu-muted">
                            Atur foto utama yang tampil di kartu depan atau hapus foto yang sudah tidak sesuai.
                        </p>
                    </div>

                    @if ($venue->images->count() > 0)
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                            @foreach ($venue->images as $image)
                                <div class="rounded-[20px] bg-neu-base shadow-neu-raised p-4 flex flex-col justify-between">
                                    <!-- Bingkai Gambar Inset -->
                                    <div class="relative h-40 w-full rounded-[14px] bg-neu-base shadow-neu-inset p-1.5 mb-4">
                                        <div class="relative h-full w-full overflow-hidden rounded-[10px]">
                                            <img
                                                src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="Foto {{ $venue->name }}"
                                                class="h-full w-full object-cover"
                                            >

                                            @if ($image->is_primary)
                                                <span class="absolute top-2 left-2 rounded-full bg-neu-primary px-3 py-1 text-[11px] font-extrabold text-white shadow-md">
                                                    ★ Foto Utama
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Aksi Foto -->
                                    <div class="space-y-2.5 mt-auto">
                                        @if ($image->is_primary)
                                            <div class="w-full rounded-full bg-neu-base shadow-neu-inset px-4 py-2.5 text-center text-xs font-extrabold text-neu-primary">
                                                Foto Utama Aktif
                                            </div>
                                        @else
                                            <form method="POST"
                                                  action="{{ route('owner.venues.images.primary', [$venue->id, $image->id]) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-2.5 text-xs font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                                                    Jadikan Foto Utama
                                                </button>
                                            </form>
                                        @endif

                                        <!-- FORM HAPUS FOTO TERPISAH -->
                                        <form method="POST"
                                              action="{{ route('owner.venues.images.destroy', [$venue->id, $image->id]) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-2.5 text-xs font-extrabold text-red-500 transition-all duration-300 hover:shadow-neu-pressed">
                                                Hapus Foto
                                            </button>
                                        </form>
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

            </div>
        </main>
    </div>

</body>
</html>