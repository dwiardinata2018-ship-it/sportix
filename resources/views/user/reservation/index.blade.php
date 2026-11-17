<x-app-layout>
    <div class="min-h-screen bg-neu-base py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-4xl font-extrabold text-neu-dark tracking-tight">
                    Reservation
                </h1>
                <p class="mt-3 text-lg font-medium text-neu-muted">
                    Temukan dan pesan tempat olahraga favoritmu bersama Sportix.
                </p>
            </div>

            <!-- Search dan Filter (Raised Panel 24px) -->
            <div class="rounded-[24px] bg-neu-base shadow-neu-raised p-6 md:p-8 mb-12">
                <h2 class="mb-6 text-xl font-bold text-neu-dark flex items-center gap-2">
                    <svg class="w-6 h-6 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Tempat Olahraga
                </h2>

                <form action="{{ route('user.reservation') }}"
                      method="GET"
                      class="grid grid-cols-1 gap-6 md:grid-cols-3">

                    <!-- Pencarian (Inset Input 16px) -->
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Nama venue atau lokasi..."
                            class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all duration-300 outline-none"
                        >
                    </div>

                    <!-- Filter Olahraga (Inset Select 16px) -->
                    <div class="relative">
                        <select
                            name="sport"
                            class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all duration-300 outline-none appearance-none cursor-pointer"
                            style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;"
                        >
                            
                            <option value="">Semua Olahraga</option>

                            @foreach ($sports as $sport)
                                <option
                                    value="{{ $sport->id }}"
                                    {{ request('sport') == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Custom Arrow for Select (UKURAN DIPERBESAR MENJADI h-6 w-6) -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-neu-muted">
                            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>

                    <!-- Tombol Cari (Primary Raised - Rounded Full / Pill) -->
                    <button
                        type="submit"
                        class="w-full rounded-full bg-neu-primary px-6 py-4 text-lg font-bold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                        Cari Venue
                    </button>

                </form>
            </div>

            <!-- Daftar Venue -->
            <section class="mt-10">

                <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <h2 class="text-2xl font-extrabold text-neu-dark">
                            Daftar Venue Olahraga
                        </h2>
                        <p class="mt-1 text-sm font-medium text-neu-muted">
                            Berikut tempat olahraga yang tersedia di Sportix.
                        </p>
                    </div>

                    <div class="rounded-full bg-neu-base shadow-neu-inset px-5 py-2 inline-block">
                        <p class="text-sm font-bold text-neu-primary">
                            {{ $venues->total() }} venue ditemukan
                        </p>
                    </div>
                </div>

                @if ($venues->count() > 0)

                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($venues as $venue)

                            <!-- Card Venue (Raised 24px) -->
                            <div class="flex flex-col overflow-hidden rounded-[24px] bg-neu-base shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover p-4">

                                <!-- Area Gambar dengan bingkai Inset 16px -->
                                <div class="relative h-56 w-full rounded-[16px] bg-neu-base shadow-neu-inset p-2">
                                    <div class="relative h-full w-full overflow-hidden rounded-[12px]">
                                        @php
                                            $primaryImage = $venue->images->first();
                                        @endphp

                                        @if ($primaryImage)
                                            <img
                                                src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                                alt="{{ $primaryImage->caption ?: $venue->name }}"
                                                class="h-full w-full object-cover transition-transform duration-700 hover:scale-110"
                                            >
                                        @else
                                            <div class="flex h-full items-center justify-center bg-neu-base">
                                                <span class="text-6xl drop-shadow-sm">🏟️</span>
                                            </div>
                                        @endif

                                        <!-- Label Jenis Venue (Pill Badge) -->
                                        <span class="absolute right-3 top-3 rounded-full bg-neu-base shadow-neu-raised px-4 py-1.5 text-xs font-extrabold text-neu-dark">
                                            {{ ucfirst($venue->venue_type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Informasi Venue -->
                                <div class="flex flex-col flex-grow pt-6 pb-2 px-2">

                                    <div class="mb-4 flex items-center justify-between gap-2">
                                        <span class="rounded-full bg-neu-base shadow-neu-inset px-4 py-1.5 text-xs font-extrabold text-neu-primary">
                                            {{ $venue->sport->name }}
                                        </span>

                                        <span class="flex items-center gap-1 text-xs font-bold text-neu-primary">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            Terverifikasi
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-extrabold text-neu-dark mb-1">
                                        {{ $venue->name }}
                                    </h3>

                                    <p class="mb-4 text-sm font-medium text-neu-muted flex items-start gap-1.5">
                                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $venue->city }}, {{ $venue->province }}
                                    </p>

                                    <p class="mb-6 line-clamp-2 text-sm leading-relaxed text-neu-dark/80">
                                        {{ $venue->description ?: 'Belum ada deskripsi venue.' }}
                                    </p>

                                    <!-- Informasi Unit & Harga -->
                                    <div class="mt-auto border-t border-neu-muted/20 pt-5">
                                        
                                        <div class="mb-3 flex items-center justify-between">
                                            <span class="text-sm font-semibold text-neu-muted">
                                                Unit aktif
                                            </span>
                                            <span class="rounded-full bg-neu-base shadow-neu-inset px-3 py-1 text-xs font-extrabold text-neu-dark">
                                                {{ $venue->units->count() }} unit
                                            </span>
                                        </div>

                                        @php
                                            $lowestPrice = $venue->units->min('default_price');
                                        @endphp

                                        <div class="mb-6">
                                            <p class="mb-1 text-xs font-semibold text-neu-muted">
                                                Harga mulai dari
                                            </p>

                                            @if ($lowestPrice !== null)
                                                <p class="text-2xl font-extrabold text-neu-primary drop-shadow-sm">
                                                    Rp{{ number_format((float) $lowestPrice, 0, ',', '.') }}
                                                </p>
                                            @else
                                                <p class="text-sm font-bold text-neu-muted">
                                                    Harga belum tersedia
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Tombol Detail (Pill Button Raised to Pressed) -->
                                        <a href="{{ route('user.reservation.detail', $venue->slug) }}"
                                           class="block w-full rounded-full bg-neu-base shadow-neu-raised px-4 py-3.5 text-center text-sm font-extrabold text-neu-primary transition-all duration-300 hover:shadow-neu-pressed">
                                            Lihat Detail Venue
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        <!-- Pagination Container Inset -->
                        <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-4">
                            {{ $venues->links() }}
                        </div>
                    </div>

                @else

                    <!-- Jika Belum Ada Venue (Inset State) -->
                    <div class="flex flex-col items-center justify-center rounded-[24px] bg-neu-base shadow-neu-inset px-6 py-20 text-center">

                        <div class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-5xl">
                            🏟️
                        </div>

                        <h3 class="text-2xl font-extrabold text-neu-dark">
                            Venue belum ditemukan
                        </h3>

                        <p class="mt-3 text-base font-medium text-neu-muted max-w-md">
                            Coba ubah kata pencarian atau pilih kategori olahraga lainnya untuk menemukan tempat yang sesuai.
                        </p>

                    </div>

                @endif

            </section>

        </div>
    </div>
</x-app-layout>