
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

            <div class="mt-4">
                @if ($isFavorited)
                    <form
                        action="{{ route('user.favorites.destroy', $venue->id) }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-semibold"
                        >
                            ♥ Hapus dari Favorit
                        </button>
                    </form>
                @else
                    <form
                        action="{{ route('user.favorites.store', $venue->id) }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-semibold"
                        >
                            ♡ Tambah ke Favorit
                        </button>
                    </form>
                @endif
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

                    
                    <!-- Rating dan Ulasan -->
                    <section class="rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-xl font-bold text-slate-800">
                            Rating dan Ulasan Pelanggan
                        </h2>

                        <!-- Ringkasan Rating -->
                        <div class="mb-6 rounded-xl bg-blue-50 p-5">
                            <div class="flex items-center gap-4">
                                <div class="text-4xl font-bold text-slate-800">
                                    {{ number_format($averageRating, 1) }}
                                </div>

                                <div>
                                    <div class="text-xl text-yellow-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= round($averageRating) ? '★' : '☆' }}
                                        @endfor
                                    </div>

                                    <p class="text-sm text-slate-500">
                                        {{ $reviewCount }}
                                        {{ $reviewCount === 1 ? 'ulasan' : 'ulasan' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Ulasan -->
                        @forelse ($venue->reviews as $review)
                            <div class="border-b border-slate-100 py-5 last:border-0">
                                <div class="flex flex-col justify-between gap-2 sm:flex-row">
                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $review->user->name ?? 'Pengguna Sportix' }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            {{ $review->created_at->format('d M Y') }}
                                        </p>
                                    </div>

                                    <div class="text-lg text-yellow-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= $review->rating ? '★' : '☆' }}
                                        @endfor
                                    </div>
                                </div>

                                @if ($review->comment)
                                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                        {{ $review->comment }}
                                    </p>
                                @else
                                    <p class="mt-3 text-sm italic text-slate-400">
                                        Tidak ada komentar.
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <div class="mb-3 text-4xl">💬</div>

                                <p class="font-semibold text-slate-700">
                                    Belum Ada Ulasan
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Jadilah pelanggan pertama yang memberikan ulasan
                                    untuk venue ini.
                                </p>
                            </div>
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

    <form
        id="bookingForm"
        action="{{ route('user.booking.store') }}"
        method="POST"
    >
        @csrf

        <input type="hidden" name="venue_id" value="{{ $venue->id }}">

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
                class="w-full rounded-xl border-slate-300 text-sm"
            >

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
                class="w-full rounded-xl border-slate-300 text-sm"
            >

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
                class="w-full rounded-xl border-slate-300 text-sm"
            >

            @error('end_time')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Cek Ketersediaan -->
        <button
            type="button"
            id="checkAvailabilityButton"
            class="mb-4 w-full rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white hover:bg-blue-700"
        >
            Cek Ketersediaan
        </button>

        <!-- Hasil Pemeriksaan -->
        <div id="availabilityResult" class="mb-4 hidden rounded-xl border p-4">
        </div>

        <!-- Pilih Unit -->
        <div class="mb-4">
            <label for="unit_id" class="mb-2 block text-sm font-medium text-slate-700">
                Pilih Unit Olahraga
            </label>

            <select
                id="unit_id"
                name="unit_id"
                required
                disabled
                class="w-full rounded-xl border-slate-300 text-sm disabled:bg-slate-100"
            >
                <option value="">Cek ketersediaan terlebih dahulu</option>
            </select>

            @error('unit_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estimasi Harga -->
        <div id="priceResult" class="mb-4 hidden rounded-xl bg-blue-50 p-4">
            <p class="text-sm text-slate-500">Estimasi total harga</p>
            <p id="estimatedPrice" class="mt-1 text-xl font-bold text-blue-700"></p>
            <p id="pricingInformation" class="mt-1 text-xs text-slate-500"></p>
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
                class="w-full rounded-xl border-slate-300 text-sm"
            >{{ old('user_notes') }}</textarea>

            @error('user_notes')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <button
            type="submit"
            id="submitBookingButton"
            disabled
            class="w-full rounded-xl bg-slate-400 px-4 py-3 font-semibold text-white disabled:cursor-not-allowed"
        >
            Cek Ketersediaan Terlebih Dahulu
        </button>

        <p class="mt-3 text-center text-xs text-slate-400">
            Pemesanan akan diperiksa sebelum dikirim kepada Owner.
        </p>

    </form>
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

        unitSelect.innerHTML = '<option value="">Cek ketersediaan terlebih dahulu</option>';
        unitSelect.disabled = true;

        priceBox.classList.add('hidden');

        submitButton.disabled = true;
        submitButton.textContent = 'Cek Ketersediaan Terlebih Dahulu';
        submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        submitButton.classList.add('bg-slate-400');

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
            ' • ' +
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
                resultBox.className = 'mb-4 rounded-xl border border-green-200 bg-green-50 p-4';

                resultBox.innerHTML = `
                    <p class="font-semibold text-green-700">
                        ${availableUnits.length} unit tersedia!
                    </p>
                    <p class="mt-1 text-sm text-green-600">
                        Silakan pilih unit yang ingin dipesan.
                    </p>
                `;

                if (data.unavailable_units && data.unavailable_units.length > 0) {
                    const unavailableList = data.unavailable_units.map(function (unit) {
                        return `<li>${unit.unit_name}: ${unit.reason}</li>`;
                    }).join('');

                    resultBox.innerHTML += `
                        <div class="mt-3 border-t border-green-200 pt-3">
                            <p class="text-sm font-semibold text-slate-700">
                                Unit tidak tersedia:
                            </p>
                            <ul class="mt-1 list-disc pl-5 text-sm text-slate-600">
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

                submitButton.disabled = false;
                submitButton.textContent = 'Pesan Sekarang';
                submitButton.classList.remove('bg-slate-400');
                submitButton.classList.add('bg-blue-600', 'hover:bg-blue-700');

            } else {
                resultBox.className = 'mb-4 rounded-xl border border-red-200 bg-red-50 p-4';

                resultBox.innerHTML = `
                    <p class="font-semibold text-red-700">
                        Tidak ada unit yang tersedia.
                    </p>
                    <p class="mt-1 text-sm text-red-600">
                        ${data.message || 'Silakan pilih waktu lain.'}
                    </p>
                `;
            }

        } catch (error) {
            resultBox.className = 'mb-4 rounded-xl border border-red-200 bg-red-50 p-4';
            resultBox.classList.remove('hidden');

            const message = document.createElement('p');
            message.className = 'text-sm text-red-700 whitespace-pre-line';
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


                        </div>


                    </div>
                </aside>

            </div>

        </div>
    </div>
</x-app-layout>
