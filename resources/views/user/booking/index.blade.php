<x-app-layout>

    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">
                        My Booking
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Pantau dan lihat seluruh riwayat pemesanan tempat olahraga kamu.
                    </p>
                </div>

                <a
                    href="{{ route('user.reservation') }}"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">
                    + Booking Venue
                </a>
            </div>

            {{-- Notifikasi Berhasil --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Ringkasan --}}
            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Total Booking
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $bookings->total() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Halaman Saat Ini
                    </p>

                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $bookings->currentPage() }}
                    </p>
                </div>
            </div>

            {{-- Daftar Booking --}}
            <section>
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-800">
                        Riwayat Pemesanan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Berikut daftar pemesanan yang pernah kamu lakukan.
                    </p>
                </div>

                @if ($bookings->count() > 0)

                    <div class="space-y-5">

                        @foreach ($bookings as $booking)

                            @php
                                $statusLabels = [
                                    'pending_confirmation' => 'Menunggu Konfirmasi',
                                    'confirmed' => 'Dikonfirmasi',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                    'checked_in' => 'Sudah Check-in',
                                    'completed' => 'Selesai',
                                    'expired' => 'Kedaluwarsa',
                                ];

                                $statusColors = [
                                    'pending_confirmation' => 'bg-yellow-50 text-yellow-700',
                                    'confirmed' => 'bg-green-50 text-green-700',
                                    'rejected' => 'bg-red-50 text-red-700',
                                    'cancelled' => 'bg-slate-100 text-slate-600',
                                    'checked_in' => 'bg-blue-50 text-blue-700',
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'expired' => 'bg-orange-50 text-orange-700',
                                ];

                                $status = $booking->booking_status;
                            @endphp

                            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

                                <div class="flex flex-col justify-between gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center">

                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                            Kode Booking
                                        </p>

                                        <p class="mt-1 font-bold text-slate-800">
                                            {{ $booking->booking_code }}
                                        </p>
                                    </div>

                                    <span class="w-fit rounded-full px-4 py-2 text-xs font-semibold {{ $statusColors[$status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>

                                </div>

                                <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                                    {{-- Informasi Venue --}}
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                            Venue
                                        </p>

                                        <h3 class="mt-2 text-lg font-bold text-slate-800">
                                            {{ $booking->venue->name ?? 'Venue tidak tersedia' }}
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $booking->unit->name ?? 'Unit tidak tersedia' }}
                                        </p>
                                    </div>

                                    {{-- Informasi Jadwal --}}
                                    <div class="grid grid-cols-2 gap-4">

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Tanggal
                                            </p>

                                            <p class="mt-2 text-sm font-semibold text-slate-700">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Waktu
                                            </p>

                                            <p class="mt-2 text-sm font-semibold text-slate-700">
                                                {{ substr($booking->start_time, 0, 5) }}
                                                -
                                                {{ substr($booking->end_time, 0, 5) }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Durasi
                                            </p>

                                            <p class="mt-2 text-sm font-semibold text-slate-700">
                                                {{ $booking->duration_minutes }} menit
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Total Harga
                                            </p>

                                            <p class="mt-2 text-sm font-bold text-blue-600">
                                                Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                {{-- Catatan User --}}
                                @if ($booking->user_notes)
                                    <div class="border-t border-slate-100 px-5 py-4">
                                        <p class="text-xs text-slate-400">
                                            Catatan
                                        </p>

                                        <p class="mt-1 text-sm text-slate-600">
                                            {{ $booking->user_notes }}
                                        </p>
                                    </div>
                                @endif

                                
                                {{-- Informasi dan Tombol Pembayaran --}}
                                @if ($booking->booking_status === 'confirmed' && $booking->paymentRecord)

                                    <div class="border-t border-slate-100 px-5 py-4">

                                        @if ($booking->paymentRecord->payment_status === 'paid')

                                            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4">
                                                <p class="text-sm font-semibold text-green-700">
                                                    ✓ Pembayaran Sudah Berhasil
                                                </p>

                                                <p class="mt-1 text-xs text-green-600">
                                                    Booking ini sudah dibayar.
                                                </p>
                                            </div>

                                        @else

                                            <div class="mb-4">
                                                <p class="text-sm font-semibold text-slate-700">
                                                    Pembayaran QRIS
                                                </p>

                                                <p class="mt-1 text-xs text-slate-500">
                                                    Silakan lanjutkan pembayaran untuk menyelesaikan booking.
                                                </p>
                                            </div>

                                            <a
                                                href="{{ route('user.booking.payment', $booking->id) }}"
                                                class="mb-4 inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700">

                                                Bayar Sekarang
                                            </a>

                                        @endif

                                    </div>

                                @endif

                                {{-- Tombol QR Check-in --}}
                                @if ($booking->booking_status === 'confirmed')

                                    <div class="border-t border-slate-100 px-5 py-4">

                                        <a
                                            href="{{ route('user.booking.qr', $booking->id) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h2v2h-2zM18 14h2v2h-2zM14 18h2v2h-2zM18 18h2v2h-2z" />
                                            </svg>

                                            Lihat QR Check-in
                                        </a>

                                        <p class="mt-2 text-xs text-slate-500">
                                            Tunjukkan QR Code ini kepada Owner saat tiba di venue.
                                        </p>

                                    </div>

                                @endif

                                {{-- Reviews dan Rating --}}
                                @if ($booking->booking_status === 'completed')

                                    <div class="border-t border-slate-100 px-5 py-5">

                                        @if ($booking->review)

                                            {{-- Booking Sudah Diulas --}}
                                            <div class="rounded-xl border border-green-200 bg-green-50 p-4">

                                                <p class="text-sm font-semibold text-green-700">
                                                    ✓ Terima kasih, kamu sudah memberikan ulasan!
                                                </p>

                                                <div class="mt-3 flex items-center gap-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="text-xl {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-slate-300' }}">
                                                            ★
                                                        </span>
                                                    @endfor

                                                    <span class="ml-2 text-sm font-semibold text-slate-700">
                                                        {{ $booking->review->rating }}/5
                                                    </span>
                                                </div>

                                                @if ($booking->review->comment)
                                                    <p class="mt-3 text-sm text-slate-600">
                                                        {{ $booking->review->comment }}
                                                    </p>
                                                @endif

                                            </div>

                                        @else

                                            {{-- Formulir Ulasan --}}
                                            <div>
                                                <h3 class="text-lg font-bold text-slate-800">
                                                    Berikan Ulasan
                                                </h3>

                                                <p class="mt-1 text-sm text-slate-500">
                                                    Bagaimana pengalamanmu menggunakan venue ini?
                                                </p>

                                                <form
                                                    action="{{ route('user.booking.review.store', $booking->id) }}"
                                                    method="POST"
                                                    class="mt-4 space-y-4">

                                                    @csrf

                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                                            Rating
                                                        </label>

                                                        <select
                                                            name="rating"
                                                            required
                                                            class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">

                                                            <option value="">Pilih Rating</option>

                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                                                    {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                                                </option>
                                                            @endfor

                                                        </select>

                                                        @error('rating')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="mb-2 block text-sm font-medium text-slate-700">
                                                            Komentar (Opsional)
                                                        </label>

                                                        <textarea
                                                            name="comment"
                                                            rows="3"
                                                            maxlength="2000"
                                                            placeholder="Ceritakan pengalamanmu menggunakan venue ini..."
                                                            class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('comment') }}</textarea>

                                                        @error('comment')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                                                        Kirim Ulasan
                                                    </button>

                                                </form>
                                            </div>

                                        @endif

                                    </div>

                                @endif


                            </div>

                        @endforeach

                    </div>

                    

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $bookings->links() }}
                    </div>

                @else

                    {{-- Belum Ada Booking --}}
                    <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                        <div class="mb-4 text-5xl">
                            📅
                        </div>

                        <h3 class="text-lg font-bold text-slate-700">
                            Belum Ada Pemesanan
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Kamu belum memiliki riwayat booking.
                            Yuk, temukan tempat olahraga favoritmu!
                        </p>

                        <a
                            href="{{ route('user.reservation') }}"
                            class="mt-6 inline-block rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Cari Venue Sekarang
                        </a>

                    </div>

                @endif

            </section>

        </div>
    </div>

</x-app-layout>
