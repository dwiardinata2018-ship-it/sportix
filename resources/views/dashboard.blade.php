<x-app-layout>
    <div class="min-h-screen bg-neu-base py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Hero Banner Section dengan Background Gambar Olahraga -->
            <div class="mb-12 rounded-[36px] bg-neu-dark bg-cover bg-center p-8 sm:p-12 shadow-neu-raised relative overflow-hidden"
                 style="background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1600&q=80');">
                
                <!-- Lapisan Overlay Gelap agar teks tetap kontras & jelas terbaca -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-900/50"></div>

                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block rounded-full bg-white/15 backdrop-blur-md border border-white/20 px-4 py-1.5 text-xs font-extrabold text-white mb-4">
                        ⚡ Sportix Arena Booking System
                    </span>
                    
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight drop-shadow-sm">
                        Temukan & Booking Lapangan Impianmu.
                    </h1>
                    
                    <p class="mt-3 text-sm sm:text-base font-medium text-slate-200 leading-relaxed">
                        Nikmati kemudahan menyewa venue olahraga berkualitas dengan sistem check-in QR code instan dan pembayaran aman.
                    </p>

                    <!-- Form Pencarian Terintegrasi di Banner -->
                    <form action="{{ route('user.reservation') }}" method="GET" class="mt-8 flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                name="search"
                                placeholder="Cari nama venue, kota, atau jenis olahraga..."
                                class="w-full rounded-full border-none bg-neu-base shadow-neu-inset px-6 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none"
                            >
                        </div>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-8 py-4 text-sm font-extrabold text-white shadow-lg transition-all duration-300 hover:bg-neu-primary-dark active:scale-95 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Venue
                        </button>
                    </form>

                    <!-- Tombol Pintasan Cepat (Quick Actions) -->
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Akses Cepat:</span>
                        
                        <a href="{{ route('user.booking') }}" class="inline-flex items-center gap-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 px-4 py-2 text-xs font-extrabold text-white transition-all hover:bg-white/25">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Riwayat Booking Saya
                        </a>

                        <a href="{{ route('user.reservation') }}" class="inline-flex items-center gap-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 px-4 py-2 text-xs font-extrabold text-white transition-all hover:bg-white/25">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Semua Venue
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sport Categories -->
            <section class="mb-14">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold text-neu-dark">
                            Kategori Olahraga
                        </h2>
                        <p class="mt-1 text-sm font-medium text-neu-muted">
                            Pilih cabang olahraga favorit yang ingin kamu mainkan hari ini.
                        </p>
                    </div>

                    <a href="{{ route('user.reservation') }}" class="inline-flex items-center gap-1 text-sm font-extrabold text-neu-primary transition-all hover:underline">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-6">

                    @foreach ([
                        // 1. Badminton: Gambar Kok (Shuttlecock)
                        ['name' => 'Badminton', 'image' => 'https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f3f8.svg'],
                        
                        // 2. Futsal: Gambar Bola Sepak / Futsal
                        ['name' => 'Futsal', 'image' => 'https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/26bd.svg'],
                        
                        // 3. Basket: Gambar Bola Basket
                        ['name' => 'Basket', 'image' => 'https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f3c0.svg'],
                        
                        // 4. Tenis: Gambar Bola Tenis
                        ['name' => 'Tenis', 'image' => 'https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f3be.svg'],
                        
                        // 5. Voli: Gambar Bola Voli
                        ['name' => 'Voli', 'image' => 'https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f3d0.svg'],
                        
                        // 6. Renang: Gambar Kacamata Renang
                        ['name' => 'Renang', 'image' => 'https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f93f.svg'],
                    ] as $sport)

                        <a href="{{ route('user.reservation', ['search' => $sport['name']]) }}" class="group rounded-[24px] bg-neu-base p-6 text-center shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed flex flex-col items-center justify-center">
                            <div class="mb-4 h-16 w-16 rounded-2xl bg-neu-base shadow-neu-inset p-3 flex items-center justify-center transition-all duration-300 group-hover:scale-110">
                                <img
                                    src="{{ $sport['image'] }}"
                                    alt="{{ $sport['name'] }}"
                                    class="h-full w-full object-contain drop-shadow-sm"
                                >
                            </div>
                            <h3 class="font-extrabold text-neu-dark text-sm sm:text-base">
                                {{ $sport['name'] }}
                            </h3>
                        </a>

                    @endforeach

                </div>
            </section>

            <!-- Recommended Venues -->
            <section class="mb-10">
                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-neu-dark">
                        Rekomendasi Venue
                    </h2>
                    <p class="mt-1 text-sm font-medium text-neu-muted">
                        Temukan tempat olahraga terbaik yang sesuai dengan kebutuhanmu.
                    </p>
                </div>

                <div class="flex flex-col items-center justify-center rounded-[32px] bg-neu-base shadow-neu-inset px-6 py-20 text-center">
                    <div class="mb-6 flex h-28 w-28 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-neu-primary">
                        <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-extrabold text-neu-dark">
                        Venue akan tampil di sini
                    </h3>

                    <p class="mt-2 max-w-md text-sm font-medium text-neu-muted">
                        Venue yang sudah diverifikasi dan diaktifkan oleh Admin nantinya akan muncul secara otomatis di halaman ini.
                    </p>

                    <a href="{{ route('user.reservation') }}"
                       class="mt-8 inline-block rounded-full bg-neu-primary px-8 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                        Jelajahi Semua Venue
                    </a>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>