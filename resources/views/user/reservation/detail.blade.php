<x-app-layout>
    <div class="min-h-screen bg-neu-base py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Tombol Kembali (Raised Pill) -->
            <div class="mb-8">
                <a href="{{ route('user.reservation') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Reservation
                </a>
            </div>

            <!-- Header Venue -->
            <div class="mb-8 flex flex-col items-start sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="inline-block rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold text-neu-primary mb-3">
                        {{ $venue->sport->name }}
                    </span>

                    <h1 class="text-4xl font-extrabold text-neu-dark tracking-tight">
                        {{ $venue->name }}
                    </h1>

                    <p class="mt-2 text-sm font-medium text-neu-muted flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $venue->address }}, {{ $venue->city }}, {{ $venue->province }}
                    </p>
                </div>

                <!-- Tombol Favorit -->
                <div class="shrink-0">
                    @if ($isFavorited)
                        <form action="{{ route('user.favorites.destroy', $venue->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-2 rounded-full bg-neu-base shadow-neu-inset px-6 py-3 text-sm font-extrabold text-red-500 transition-all duration-300 hover:shadow-neu-pressed">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                Hapus dari Favorit
                            </button>
                        </form>
                    @else
                        <form action="{{ route('user.favorites.store', $venue->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-6 py-3 text-sm font-extrabold text-neu-primary transition-all duration-300 hover:shadow-neu-pressed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                Tambah ke Favorit
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Galeri Foto (Inset Container) -->
            <section class="mb-12 rounded-[24px] bg-neu-base shadow-neu-inset p-4">
                @if ($venue->images->count() > 0)
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($venue->images as $image)
                            <div class="h-64 overflow-hidden rounded-[16px] shadow-neu-raised">
                                <img
                                    src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->caption ?: $venue->name }}"
                                    class="h-full w-full object-cover transition-transform duration-700 hover:scale-110"
                                >
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex h-72 items-center justify-center rounded-[16px] shadow-neu-raised">
                        <span class="text-7xl drop-shadow-sm">🏟️</span>
                    </div>
                @endif
            </section>

            <!-- Informasi Venue & Booking Sidebar -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                <!-- KONTEN UTAMA (KIRI) -->
                <div class="space-y-8 lg:col-span-2">

                    <!-- Deskripsi (Raised Card) -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                        <h2 class="mb-5 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tentang Venue
                        </h2>

                        <p class="leading-relaxed text-neu-dark/80 font-medium">
                            {{ $venue->description ?: 'Belum ada deskripsi venue.' }}
                        </p>

                        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-5">
                                <p class="text-xs font-bold text-neu-muted uppercase tracking-wider mb-1">Jenis Venue</p>
                                <p class="text-lg font-extrabold text-neu-dark">
                                    {{ ucfirst($venue->venue_type) }}
                                </p>
                            </div>
                            <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-5">
                                <p class="text-xs font-bold text-neu-muted uppercase tracking-wider mb-1">Kategori</p>
                                <p class="text-lg font-extrabold text-neu-dark">
                                    {{ $venue->sport->name }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Daftar Unit -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                        <h2 class="mb-6 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Unit Olahraga
                        </h2>

                        <div class="space-y-5">
                            @forelse ($venue->units as $unit)
                                <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-6 transition-all duration-300 hover:shadow-neu-raised">
                                    <div class="flex flex-col justify-between gap-4 sm:flex-row">
                                        <div>
                                            <h3 class="text-xl font-extrabold text-neu-dark">
                                                {{ $unit->name }}
                                            </h3>
                                            <p class="mt-1 flex items-center gap-1.5 text-sm font-bold text-neu-primary">
                                                <span class="w-2 h-2 rounded-full bg-neu-primary"></span>
                                                {{ ucfirst($unit->unit_type) }}
                                            </p>

                                            @if ($unit->description)
                                                <p class="mt-3 text-sm font-medium text-neu-dark/70">
                                                    {{ $unit->description }}
                                                </p>
                                            @endif

                                            @if ($unit->capacity)
                                                <p class="mt-3 inline-block rounded-lg bg-neu-base shadow-neu-raised px-3 py-1 text-xs font-bold text-neu-dark">
                                                    Kapasitas: {{ $unit->capacity }} orang
                                                </p>
                                            @endif
                                        </div>

                                        <div class="sm:text-right flex flex-col justify-center">
                                            <p class="text-xs font-bold text-neu-muted uppercase tracking-wider">
                                                Harga dasar
                                            </p>
                                            <p class="mt-1 text-2xl font-extrabold text-neu-primary drop-shadow-sm">
                                                Rp{{ number_format((float) $unit->default_price, 0, ',', '.') }}
                                            </p>
                                            <p class="mt-1 text-[10px] font-medium text-neu-muted">
                                                (Acuan. Mengikuti aturan harga)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-8 text-center">
                                    <p class="text-sm font-bold text-neu-muted">Belum ada unit olahraga yang tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Jam Operasional -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                        <h2 class="mb-6 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jam Operasional
                        </h2>

                        @if ($venue->operatingHours->count() > 0)
                            <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-5 space-y-4">
                                @foreach ($venue->operatingHours as $hour)
                                    @php
                                        $days = [
                                            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
                                            4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
                                        ];
                                    @endphp
                                    <div class="flex items-center justify-between border-b border-neu-muted/20 pb-4 last:border-0 last:pb-0">
                                        <span class="font-extrabold text-neu-dark">
                                            {{ $days[$hour->weekday] ?? 'Hari tidak diketahui' }}
                                        </span>

                                        @if ($hour->is_closed)
                                            <span class="rounded-full bg-neu-base shadow-neu-raised px-4 py-1 text-xs font-extrabold text-red-500">
                                                Tutup
                                            </span>
                                        @else
                                            <span class="rounded-full bg-neu-base shadow-neu-raised px-4 py-1 text-sm font-extrabold text-neu-primary">
                                                {{ \Carbon\Carbon::parse($hour->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($hour->close_time)->format('H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-8 text-center">
                                <p class="text-sm font-bold text-neu-muted">Informasi jam operasional belum tersedia.</p>
                            </div>
                        @endif
                    </section>

                    <!-- Fasilitas -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                        <h2 class="mb-6 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            Fasilitas Venue
                        </h2>

                        @if ($venue->facilities->count() > 0)
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                                @foreach ($venue->facilities as $facility)
                                    <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4 flex items-center justify-center text-center">
                                        <p class="font-extrabold text-neu-dark text-sm">
                                            {{ $facility->name }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-8 text-center">
                                <p class="text-sm font-bold text-neu-muted">Informasi fasilitas belum tersedia.</p>
                            </div>
                        @endif
                    </section>

                    <!-- Aturan Harga -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                        <h2 class="mb-6 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Aturan Harga
                        </h2>

                        <div class="space-y-4">
                            @forelse ($venue->pricingRules as $rule)
                                <div class="flex flex-col justify-between gap-4 rounded-[20px] bg-neu-base shadow-neu-inset p-5 sm:flex-row sm:items-center">
                                    <div>
                                        <p class="text-lg font-extrabold text-neu-dark">
                                            {{ $rule->name }}
                                        </p>
                                        <p class="mt-1 text-sm font-bold text-neu-primary">
                                            {{ $rule->start_time ? \Carbon\Carbon::parse($rule->start_time)->format('H:i') : 'Sepanjang hari' }}
                                            @if ($rule->end_time)
                                                - {{ \Carbon\Carbon::parse($rule->end_time)->format('H:i') }}
                                            @endif
                                        </p>
                                        @if ($rule->unit_id)
                                            <p class="mt-2 inline-block rounded-md bg-neu-base shadow-neu-raised px-2 py-1 text-xs font-bold text-neu-dark">
                                                Unit: {{ optional($venue->units->firstWhere('id', $rule->unit_id))->name ?? 'Unit tidak aktif' }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="sm:text-right">
                                        <p class="text-xl font-extrabold text-neu-primary drop-shadow-sm">
                                            Rp{{ number_format((float) $rule->price_per_hour, 0, ',', '.') }}/jam
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-8 text-center">
                                    <p class="text-sm font-bold text-neu-muted">
                                        Belum ada aturan harga khusus.<br>Harga dasar unit dapat dilihat pada bagian Unit Olahraga.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                    
                    <!-- Rating dan Ulasan -->
                    <section class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                        <h2 class="mb-6 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                            <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                            Rating dan Ulasan
                        </h2>

                        <!-- Ringkasan Rating -->
                        <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-6 flex items-center gap-6">
                            <div class="text-5xl font-extrabold text-neu-dark drop-shadow-sm">
                                {{ number_format($averageRating, 1) }}
                            </div>
                            <div>
                                <div class="text-2xl text-yellow-500 drop-shadow-sm tracking-widest">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($averageRating) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="mt-1 text-sm font-extrabold text-neu-muted uppercase tracking-wider">
                                    {{ $reviewCount }} Ulasan
                                </p>
                            </div>
                        </div>

                        <!-- Daftar Ulasan -->
                        <div class="space-y-6">
                            @forelse ($venue->reviews as $review)
                                <div class="rounded-[20px] bg-neu-base shadow-neu-raised p-6">
                                    <div class="flex flex-col justify-between gap-3 sm:flex-row">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-full bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary font-bold">
                                                {{ substr($review->user->name ?? 'P', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-extrabold text-neu-dark">
                                                    {{ $review->user->name ?? 'Pengguna Sportix' }}
                                                </p>
                                                <p class="text-xs font-bold text-neu-muted">
                                                    {{ $review->created_at->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-lg text-yellow-500 drop-shadow-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                {{ $i <= $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </div>
                                    </div>
                                    @if ($review->comment)
                                        <div class="mt-4 rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                            <p class="text-sm font-medium leading-relaxed text-neu-dark/80">
                                                {{ $review->comment }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-10 text-center">
                                    <div class="mb-4 text-5xl drop-shadow-sm">💬</div>
                                    <p class="text-lg font-extrabold text-neu-dark">Belum Ada Ulasan</p>
                                    <p class="mt-2 text-sm font-medium text-neu-muted">Jadilah pelanggan pertama yang memberikan ulasan untuk venue ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>

                <!-- SIDEBAR (KANAN) -->
                <aside class="space-y-8">
                    
                    <!-- Informasi Kontak (Sticky Container) -->
                    <div class="lg:sticky lg:top-8 space-y-8">
                        
                        <!-- Card Info Kontak -->
                        <div class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                            <h2 class="mb-6 text-xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-5 h-5 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informasi Kontak
                            </h2>

                            <div class="space-y-5">
                                <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                    <p class="text-xs font-bold text-neu-muted uppercase tracking-wider mb-1">Alamat Lengkap</p>
                                    <p class="text-sm font-bold text-neu-dark">{{ $venue->address }}, {{ $venue->city }}</p>
                                </div>

                                @if ($venue->whatsapp_number)
                                    <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted uppercase tracking-wider mb-1">WhatsApp</p>
                                        <p class="text-sm font-extrabold text-neu-primary">{{ $venue->whatsapp_number }}</p>
                                    </div>
                                @endif

                                @if ($venue->instagram_url)
                                    <div class="rounded-[16px] bg-neu-base shadow-neu-inset p-4">
                                        <p class="text-xs font-bold text-neu-muted uppercase tracking-wider mb-1">Instagram</p>
                                        <a href="{{ $venue->instagram_url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-extrabold text-neu-primary hover:underline break-all">
                                            Kunjungi Profil
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Form Booking -->
                        <div class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8">
                            <h3 class="mb-6 text-2xl font-extrabold text-neu-dark flex items-center gap-2">
                                <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Pesan Venue
                            </h3>

                            <form id="bookingForm" action="{{ route('user.booking.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="venue_id" value="{{ $venue->id }}">

                                <!-- Tanggal -->
                                <div class="mb-5">
                                    <label for="date" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                        Tanggal Booking
                                    </label>
                                    <input type="date" id="date" name="date" min="{{ now()->format('Y-m-d') }}" value="{{ old('date') }}" required
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('date')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jam Mulai -->
                                <div class="mb-5">
                                    <label for="start_time" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                        Jam Mulai
                                    </label>
                                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('start_time')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jam Selesai -->
                                <div class="mb-6">
                                    <label for="end_time" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                        Jam Selesai
                                    </label>
                                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required
                                           class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                                    @error('end_time')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tombol Cek Ketersediaan -->
                                <button type="button" id="checkAvailabilityButton"
                                        class="mb-6 w-full rounded-full bg-neu-primary px-6 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                                    Cek Ketersediaan
                                </button>

                                <!-- Hasil Pemeriksaan -->
                                <div id="availabilityResult" class="mb-6 hidden"></div>

                                <!-- Pilih Unit -->
                                <div class="mb-6">
                                    <label for="unit_id" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                        Pilih Unit Olahraga
                                    </label>
                                    <div class="relative">
                                        <select id="unit_id" name="unit_id" required disabled
                                                class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none appearance-none disabled:text-neu-muted cursor-pointer disabled:cursor-not-allowed"
                                                style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;">
                                            <option value="">Cek ketersediaan dahulu</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-neu-muted">
                                            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                    @error('unit_id')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estimasi Harga -->
                                <div id="priceResult" class="mb-6 hidden rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-neu-primary/20">
                                    <p class="text-xs font-bold text-neu-muted uppercase tracking-wider">Estimasi total harga</p>
                                    <p id="estimatedPrice" class="mt-1 text-3xl font-extrabold text-neu-primary drop-shadow-sm"></p>
                                    <p id="pricingInformation" class="mt-2 text-xs font-bold text-neu-dark whitespace-pre-line"></p>
                                </div>

                                <!-- Catatan -->
                                <div class="mb-8">
                                    <label for="user_notes" class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                        Catatan (Opsional)
                                    </label>
                                    <textarea id="user_notes" name="user_notes" rows="3" maxlength="1000" placeholder="Tambahkan catatan..."
                                              class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-medium text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none resize-none">{{ old('user_notes') }}</textarea>
                                    @error('user_notes')
                                        <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tombol Submit (Disabled by default) -->
                                <button type="submit" id="submitBookingButton" disabled
                                        class="w-full rounded-full bg-neu-base shadow-neu-inset px-6 py-4 text-sm font-extrabold text-neu-muted cursor-not-allowed transition-all duration-300">
                                    Cek Ketersediaan Terlebih Dahulu
                                </button>

                                <p class="mt-4 text-center text-xs font-bold text-neu-muted">
                                    Pemesanan akan diperiksa sebelum dikirim.
                                </p>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    const startInput = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');

    const checkButton = document.getElementById('checkAvailabilityButton');
    const resultBox = document.getElementById('availabilityResult');

    const unitSelect = document.getElementById('unit_id');
    const priceBox = document.getElementById('priceResult');
    const estimatedPrice = document.getElementById('estimatedPrice');
    const pricingInformation = document.getElementById('pricingInformation');

    const submitButton = document.getElementById('submitBookingButton');

    const availabilityUrl = @json(route('user.reservation.availability', $venue->slug));

    let availableUnits = [];
    let checkedSchedule = null;

    function resetAvailability() {
        availableUnits = [];
        checkedSchedule = null;

        unitSelect.innerHTML = '<option value="">Cek ketersediaan dahulu</option>';
        unitSelect.disabled = true;

        priceBox.classList.add('hidden');

        submitButton.disabled = true;
        submitButton.textContent = 'Cek Ketersediaan Terlebih Dahulu';
        // Reset className ke gaya Neumorphism disabled (Inset)
        submitButton.className = 'w-full rounded-full bg-neu-base shadow-neu-inset px-6 py-4 text-sm font-extrabold text-neu-muted cursor-not-allowed transition-all duration-300 mt-2';

        resultBox.classList.add('hidden');
    }

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(value);
    }

    [dateInput, startInput, endInput].forEach(function (input) {
        input.addEventListener('change', resetAvailability);
    });

    unitSelect.addEventListener('change', function () {
        const selectedUnit = availableUnits.find(function (unit) {
            return String(unit.unit_id) === unitSelect.value;
        });

        if (!selectedUnit) {
            priceBox.classList.add('hidden');
            return;
        }

        estimatedPrice.textContent = formatRupiah(selectedUnit.total_price);

        pricingInformation.textContent =
            selectedUnit.pricing_rule +
            '\n' +
            selectedUnit.duration_minutes +
            ' menit • ' +
            formatRupiah(selectedUnit.price_per_hour) +
            '/jam';

        priceBox.classList.remove('hidden');
    });

    checkButton.addEventListener('click', async function () {
        if (!dateInput.value || !startInput.value || !endInput.value) {
            alert('Silakan isi tanggal, jam mulai, dan jam selesai terlebih dahulu.');
            return;
        }

        if (endInput.value <= startInput.value) {
            alert('Jam selesai harus lebih besar dari jam mulai.');
            return;
        }

        resetAvailability();

        checkButton.disabled = true;
        checkButton.textContent = 'Sedang Memeriksa...';

        const params = new URLSearchParams({
            date: dateInput.value,
            start_time: startInput.value,
            end_time: endInput.value
        });

        try {
            const response = await fetch(availabilityUrl + '?' + params.toString(), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                const messages = data.errors
                    ? Object.values(data.errors).flat().join('\n')
                    : (data.message || 'Gagal memeriksa ketersediaan.');

                throw new Error(messages);
            }

            availableUnits = data.available_units || [];
            resultBox.classList.remove('hidden');

            if (availableUnits.length > 0) {
                // UI Sukses Neumorphism
                resultBox.className = 'mb-6 rounded-[20px] shadow-neu-inset bg-neu-base p-5 border border-green-500/30';

                resultBox.innerHTML = `
                    <p class="font-extrabold text-green-600">
                        ${availableUnits.length} unit tersedia!
                    </p>
                    <p class="mt-1 text-sm font-bold text-green-600/80">
                        Silakan pilih unit yang ingin dipesan.
                    </p>
                `;

                if (data.unavailable_units && data.unavailable_units.length > 0) {
                    const unavailableList = data.unavailable_units.map(function (unit) {
                        return `<li>${unit.unit_name}: ${unit.reason}</li>`;
                    }).join('');

                    resultBox.innerHTML += `
                        <div class="mt-4 rounded-[12px] bg-neu-base shadow-neu-raised p-4">
                            <p class="text-xs font-bold text-neu-dark uppercase tracking-wider mb-2">
                                Unit tidak tersedia:
                            </p>
                            <ul class="list-disc pl-4 text-xs font-bold text-neu-muted space-y-1">
                                ${unavailableList}
                            </ul>
                        </div>
                    `;
                }

                unitSelect.innerHTML = '<option value="">Pilih unit tersedia</option>';

                availableUnits.forEach(function (unit) {
                    const option = document.createElement('option');
                    option.value = unit.unit_id;
                    option.textContent = unit.unit_name;
                    unitSelect.appendChild(option);
                });

                unitSelect.disabled = false;

                checkedSchedule = {
                    date: dateInput.value,
                    start_time: startInput.value,
                    end_time: endInput.value
                };

                // Ubah gaya Submit Button menjadi Aktif (Raised Pill)
                submitButton.disabled = false;
                submitButton.textContent = 'Pesan Sekarang';
                submitButton.className = 'w-full rounded-full bg-neu-primary px-6 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark mt-2';

            } else {
                // UI Error Neumorphism
                resultBox.className = 'mb-6 rounded-[20px] shadow-neu-inset bg-neu-base p-5 border border-red-500/30';

                resultBox.innerHTML = `
                    <p class="font-extrabold text-red-500">
                        Tidak ada unit yang tersedia.
                    </p>
                    <p class="mt-1 text-sm font-bold text-red-400">
                        ${data.message || 'Silakan pilih waktu lain.'}
                    </p>
                `;
            }

        } catch (error) {
            resultBox.className = 'mb-6 rounded-[20px] shadow-neu-inset bg-neu-base p-5 border border-red-500/30';
            resultBox.classList.remove('hidden');

            const message = document.createElement('p');
            message.className = 'text-sm font-extrabold text-red-500 whitespace-pre-line';
            message.textContent = error.message || 'Terjadi kesalahan saat memeriksa ketersediaan.';

            resultBox.replaceChildren(message);

        } finally {
            checkButton.disabled = false;
            checkButton.textContent = 'Cek Ketersediaan';
        }
    });

    document.getElementById('bookingForm').addEventListener('submit', function (event) {
        const scheduleStillValid =
            checkedSchedule &&
            checkedSchedule.date === dateInput.value &&
            checkedSchedule.start_time === startInput.value &&
            checkedSchedule.end_time === endInput.value;

        const selectedUnit = availableUnits.find(function (unit) {
            return String(unit.unit_id) === unitSelect.value;
        });

        if (!scheduleStillValid || !selectedUnit) {
            event.preventDefault();
            alert('Silakan periksa ketersediaan dan pilih unit terlebih dahulu.');
        }
    });
});
</script>
</x-app-layout>