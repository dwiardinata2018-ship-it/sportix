
<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">
                    Reservation
                </h1>

                <p class="mt-2 text-slate-500">
                    Temukan dan pesan tempat olahraga favoritmu bersama Sportix.
                </p>
            </div>

            <!-- Search dan Filter -->
            <div class="rounded-2xl bg-blue-600 p-6 shadow-lg">
                <h2 class="mb-4 text-xl font-bold text-white">
                    Cari Tempat Olahraga
                </h2>

                <form action="{{ route('user.reservation') }}"
                      method="GET"
                      class="grid grid-cols-1 gap-3 md:grid-cols-3">

                    <!-- Pencarian -->
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nama venue atau lokasi..."
                        class="rounded-xl border-0 px-4 py-3 text-slate-700 focus:ring-2 focus:ring-blue-300"
                    >

                    <!-- Filter Olahraga -->
                    <select
                        name="sport"
                        class="rounded-xl border-0 px-4 py-3 text-slate-700 focus:ring-2 focus:ring-blue-300">

                        <option value="">Semua Olahraga</option>

                        @foreach ($sports as $sport)
                            <option
                                value="{{ $sport->id }}"
                                {{ request('sport') == $sport->id ? 'selected' : '' }}>
                                {{ $sport->name }}
                            </option>
                        @endforeach

                    </select>

                    <!-- Tombol Cari -->
                    <button
                        type="submit"
                        class="rounded-xl bg-white px-6 py-3 font-semibold text-blue-600 transition hover:bg-blue-50">
                        Cari Venue
                    </button>

                </form>
            </div>

            <!-- Daftar Venue -->
            <section class="mt-10">

                <div class="mb-6 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            Daftar Venue Olahraga
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Berikut tempat olahraga yang tersedia di Sportix.
                        </p>
                    </div>

                    <p class="text-sm text-slate-500">
                        {{ $venues->total() }} venue ditemukan
                    </p>
                </div>

                @if ($venues->count() > 0)

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($venues as $venue)

                            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                                <!-- Area Gambar Sementara -->
                                <!-- Foto Venue -->
                                <div class="relative h-48 overflow-hidden bg-slate-200">

                                    @php
                                        $primaryImage = $venue->images->first();
                                    @endphp

                                    @if ($primaryImage)
                                        <img
                                            src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                            alt="{{ $primaryImage->caption ?: $venue->name }}"
                                            class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-blue-100 to-slate-200">
                                            <span class="text-6xl">🏟️</span>
                                        </div>
                                    @endif

                                    <!-- Label Jenis Venue -->
                                    <span class="absolute right-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm">
                                        {{ ucfirst($venue->venue_type) }}
                                    </span>

                                </div>


                                <!-- Informasi Venue -->
                                <div class="p-5">

                                    <div class="mb-3 flex items-center justify-between gap-2">
                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                            {{ $venue->sport->name }}
                                        </span>

                                        <span class="text-xs text-green-600">
                                            ● Terverifikasi
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-800">
                                        {{ $venue->name }}
                                    </h3>

                                    <p class="mt-2 text-sm text-slate-500">
                                        📍 {{ $venue->city }}, {{ $venue->province }}
                                    </p>

                                    <p class="mt-3 line-clamp-2 text-sm text-slate-600">
                                        {{ $venue->description ?: 'Belum ada deskripsi venue.' }}
                                    </p>

                                    <!-- Informasi Unit -->
                                    <div class="mt-4 border-t border-slate-100 pt-4">

                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-slate-500">
                                                Unit aktif
                                            </span>

                                            <span class="text-sm font-semibold text-slate-700">
                                                {{ $venue->units->count() }} unit
                                            </span>
                                        </div>

                                        @php
                                            $lowestPrice = $venue->units->min('default_price');
                                        @endphp

                                        <div class="mt-3">
                                            <p class="text-xs text-slate-400">
                                                Harga mulai dari
                                            </p>

                                            @if ($lowestPrice !== null)
                                                <p class="text-lg font-bold text-blue-600">
                                                    Rp{{ number_format((float) $lowestPrice, 0, ',', '.') }}
                                                </p>
                                            @else
                                                <p class="text-sm font-medium text-slate-500">
                                                    Harga belum tersedia
                                                </p>
                                            @endif
                                        </div>

                                    </div>

                                    <!-- Tombol Detail -->
                                    <a
                                        href="{{ route('user.reservation.detail', $venue->slug) }}"
                                        class="mt-5 block w-full rounded-xl bg-blue-600 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">
                                        Lihat Detail Venue
                                    </a>

                                </div>
                            </div>

                        @endforeach

                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $venues->links() }}
                    </div>

                @else

                    <!-- Jika Belum Ada Venue -->
                    <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                        <div class="mb-4 text-5xl">🏟️</div>

                        <h3 class="text-lg font-bold text-slate-700">
                            Venue belum ditemukan
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Coba ubah kata pencarian atau pilih kategori olahraga lainnya.
                        </p>

                    </div>

                @endif

            </section>

        </div>
    </div>
</x-app-layout>
