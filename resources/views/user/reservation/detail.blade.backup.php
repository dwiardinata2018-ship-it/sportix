
<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route('user.reservation') }}"
                   class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                    ← Kembali ke Reservation
                </a>
            </div>

            <!-- Header Venue -->
            <div class="mb-8">
                <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">
                    {{ $venue->sport->name }}
                </span>

                <h1 class="mt-4 text-3xl font-bold text-slate-800">
                    {{ $venue->name }}
                </h1>

                <p class="mt-2 text-slate-500">
                    📍 {{ $venue->address }},
                    {{ $venue->city }},
                    {{ $venue->province }}
                </p>
            </div>

            <!-- Galeri Foto -->
            <section class="mb-10">
                @if ($venue->images->count() > 0)

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($venue->images as $image)
                            <div class="h-64 overflow-hidden rounded-2xl bg-slate-200">
                                <img
                                    src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->caption ?: $venue->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                        @endforeach

                    </div>

                @else

                    <div class="flex h-72 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-slate-200">
                        <span class="text-7xl">🏟️</span>
                    </div>

                @endif
            </section>

            <!-- Informasi Venue -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                <div class="space-y-8 lg:col-span-2">

                    <!-- Deskripsi -->
                    <section class="rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-xl font-bold text-slate-800">
                            Tentang Venue
                        </h2>

                        <p class="leading-relaxed text-slate-600">
                            {{ $venue->description ?: 'Belum ada deskripsi venue.' }}
                        </p>

                        <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div>
                                <p class="text-sm text-slate-400">Jenis Venue</p>
                                <p class="font-semibold text-slate-700">
                                    {{ ucfirst($venue->venue_type) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-400">Kategori</p>
                                <p class="font-semibold text-slate-700">
                                    {{ $venue->sport->name }}
                                </p>
                            </div>

                        </div>
                    </section>

                    <!-- Daftar Unit -->
                    <section class="rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-xl font-bold text-slate-800">
                            Unit Olahraga
                        </h2>

                        @forelse ($venue->units as $unit)

                            <div class="mb-4 rounded-xl border border-slate-100 p-5 last:mb-0">

                                <div class="flex flex-col justify-between gap-3 sm:flex-row">
                                    <div>
                                        <h3 class="font-bold text-slate-800">
                                            {{ $unit->name }}
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ ucfirst($unit->unit_type) }}
                                        </p>

                                        @if ($unit->description)
                                            <p class="mt-2 text-sm text-slate-600">
                                                {{ $unit->description }}
                                            </p>
                                        @endif

                                        @if ($unit->capacity)
                                            <p class="mt-2 text-sm text-slate-500">
                                                Kapasitas: {{ $unit->capacity }} orang
                                            </p>
                                        @endif
                                    </div>

                                    <div class="sm:text-right">
                                        <p class="text-xs text-slate-400">
                                            Harga dasar (acuan)
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Harga akhir mengikuti aturan harga yang berlaku.
                                        </p>

                                        <p class="text-lg font-bold text-blue-600">
                                            Rp{{ number_format((float) $unit->default_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                            </div>

                        @empty

                            <p class="text-sm text-slate-500">
                                Belum ada unit olahraga yang tersedia.
                            </p>

                        @endforelse
                    </section>

                    <!-- Fasilitas -->
                    <!-- Jam Operasional -->
                    <section class="rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-xl font-bold text-slate-800">
                            Jam Operasional
                        </h2>

                        @if ($venue->operatingHours->count() > 0)

                            <div class="space-y-3">
                                @foreach ($venue->operatingHours as $hour)
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

                                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 last:border-0">
                                        <span class="font-medium text-slate-700">
                                            {{ $days[$hour->weekday] ?? 'Hari tidak diketahui' }}
                                        </span>

                                        @if ($hour->is_closed)
                                            <span class="font-semibold text-red-500">
                                                Tutup
                                            </span>
                                        @else
                                            <span class="text-sm font-semibold text-green-600">
                                                {{ \Carbon\Carbon::parse($hour->open_time)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($hour->close_time)->format('H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        @else
                            <p class="text-sm text-slate-500">
                                Informasi jam operasional belum tersedia.
                            </p>
                        @endif
                    </section>

                    <section class="rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-xl font-bold text-slate-800">
                            Fasilitas Venue
                        </h2>

                        @if ($venue->facilities->count() > 0)

                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">

                                @foreach ($venue->facilities as $facility)
                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="font-medium text-slate-700">
                                            {{ $facility->name }}
                                        </p>
                                    </div>
                                @endforeach

                            </div>

                        @else

                            <p class="text-sm text-slate-500">
                                Informasi fasilitas belum tersedia.
                            </p>

                        @endif
                    </section>

                    <!-- Aturan Harga -->
                    <section class="rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-xl font-bold text-slate-800">
                            Aturan Harga
                        </h2>

                        @forelse ($venue->pricingRules as $rule)

                            <div class="mb-3 flex flex-col justify-between gap-2 rounded-xl border border-slate-100 p-4 sm:flex-row sm:items-center">

                                <div>
                                    <p class="font-semibold text-slate-700">
                                        {{ $rule->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $rule->start_time
                                            ? \Carbon\Carbon::parse($rule->start_time)->format('H:i')
                                            : 'Sepanjang hari' }}

                                        @if ($rule->end_time)
                                            - {{ \Carbon\Carbon::parse($rule->end_time)->format('H:i') }}
                                        @endif
                                    </p>

                                    @if ($rule->unit_id)
                                        <p class="mt-1 text-xs text-slate-400">
                                            Unit:
                                            {{ optional($venue->units->firstWhere('id', $rule->unit_id))->name ?? 'Unit tidak aktif' }}
                                        </p>
                                    @endif
                                </div>

                                <p class="font-bold text-blue-600">
                                    Rp{{ number_format((float) $rule->price_per_hour, 0, ',', '.') }}/jam
                                </p>

                            </div>

                        @empty

                            <p class="text-sm text-slate-500">
                                Belum ada aturan harga khusus.
                                Harga dasar unit dapat dilihat pada bagian Unit Olahraga.
                            </p>

                        @endforelse
                    </section>

                </div>

                <!-- Sidebar Kontak -->
                <aside>
                    <div class="rounded-2xl bg-white p-6 shadow-sm lg:sticky lg:top-6">

                        <h2 class="mb-5 text-xl font-bold text-slate-800">
                            Informasi Venue
                        </h2>

                        <div class="space-y-4">

                            <div>
                                <p class="text-sm text-slate-400">Alamat</p>
                                <p class="mt-1 text-sm text-slate-700">
                                    {{ $venue->address }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-400">Kota</p>
                                <p class="mt-1 text-sm text-slate-700">
                                    {{ $venue->city }}
                                </p>
                            </div>

                            @if ($venue->whatsapp_number)
                                <div>
                                    <p class="text-sm text-slate-400">WhatsApp</p>
                                    <p class="mt-1 text-sm text-slate-700">
                                        {{ $venue->whatsapp_number }}
                                    </p>
                                </div>
                            @endif

                            @if ($venue->instagram_url)
                                <div>
                                    <p class="text-sm text-slate-400">Instagram</p>
                                    <a href="{{ $venue->instagram_url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="mt-1 block break-all text-sm font-semibold text-blue-600 hover:underline">
                                        Kunjungi Instagram
                                    </a>
                                </div>
                            @endif

                        </div>

                        
<div class="mt-6 border-t border-slate-100 pt-5">

    <h3 class="mb-4 text-lg font-bold text-slate-800">
        Pesan Venue
    </h3>

    <form action="{{ route('user.booking.store') }}" method="POST">
        @csrf

        <input
            type="hidden"
            name="venue_id"
            value="{{ $venue->id }}"
        >

        <!-- Pilih Unit -->
        <div class="mb-4">
            <label for="unit_id" class="mb-2 block text-sm font-medium text-slate-700">
                Pilih Unit Olahraga
            </label>

            <select
                id="unit_id"
                name="unit_id"
                required
                class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">

                <option value="">Pilih unit</option>

                @foreach ($venue->units as $unit)
                    <option value="{{ $unit->id }}">
                        {{ $unit->name }}
                    </option>
                @endforeach

            </select>

            @error('unit_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal -->
        <div class="mb-4">
            <label for="date" class="mb-2 block text-sm font-medium text-slate-700">
                Tanggal Booking
            </label>

            <input
                type="date"
                id="date"
                name="date"
                min="{{ now()->format('Y-m-d') }}"
                value="{{ old('date') }}"
                required
                class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">

            @error('date')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jam Mulai -->
        <div class="mb-4">
            <label for="start_time" class="mb-2 block text-sm font-medium text-slate-700">
                Jam Mulai
            </label>

            <input
                type="time"
                id="start_time"
                name="start_time"
                value="{{ old('start_time') }}"
                required
                class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">

            @error('start_time')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jam Selesai -->
        <div class="mb-4">
            <label for="end_time" class="mb-2 block text-sm font-medium text-slate-700">
                Jam Selesai
            </label>

            <input
                type="time"
                id="end_time"
                name="end_time"
                value="{{ old('end_time') }}"
                required
                class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">

            @error('end_time')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Catatan -->
        <div class="mb-5">
            <label for="user_notes" class="mb-2 block text-sm font-medium text-slate-700">
                Catatan (Opsional)
            </label>

            <textarea
                id="user_notes"
                name="user_notes"
                rows="3"
                maxlength="1000"
                placeholder="Tambahkan catatan jika diperlukan..."
                class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('user_notes') }}</textarea>

            @error('user_notes')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
                            </div>

                                <!-- Tombol Submit -->
                                <button
                                    type="submit"
                                    class="w-full rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700">

                                    Pesan Sekarang

                                </button>

                                <p class="mt-3 text-center text-xs text-slate-400">
                                    Pemesanan akan diperiksa sebelum dikirim kepada Owner.
                                </p>

                            </form>

                        </div>


                    </div>
                </aside>

            </div>

        </div>
    </div>
</x-app-layout>
