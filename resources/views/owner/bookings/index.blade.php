
<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <!-- Header -->
                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('owner.bookings.checkin') }}"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        📷 QR Check-in Scanner
                    </a>

                    <a href="{{ route('owner.dashboard') }}"
                    class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        ← Kembali ke Dashboard
                    </a>

                </div>

            <!-- Pesan Berhasil -->
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-100 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Ringkasan -->
            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Booking</p>
                    <h2 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $bookings->total() }}
                    </h2>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Halaman Saat Ini</p>
                    <h2 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $bookings->currentPage() }}
                    </h2>
                </div>
            </div>

            <!-- Daftar Booking -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                <div class="border-b border-slate-100 p-6">
                    <h2 class="text-xl font-bold text-slate-800">
                        Daftar Permintaan Booking
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Berikut pemesanan yang masuk ke venue milikmu.
                    </p>
                </div>

                @forelse ($bookings as $booking)
                    <div class="border-b border-slate-100 p-6 last:border-b-0">

                        <div class="flex flex-col justify-between gap-4 sm:flex-row">

                            <div>
                                <p class="text-sm font-semibold text-blue-600">
                                    {{ $booking->booking_code }}
                                </p>

                                <h3 class="mt-2 text-lg font-bold text-slate-800">
                                    {{ $booking->venue->name }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $booking->unit->name }}
                                </p>
                            </div>

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
                                    'pending_confirmation' => 'bg-yellow-100 text-yellow-700',
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-slate-100 text-slate-700',
                                    'checked_in' => 'bg-blue-100 text-blue-700',
                                    'completed' => 'bg-purple-100 text-purple-700',
                                    'expired' => 'bg-slate-100 text-slate-500',
                                ];
                            @endphp

                            <div>
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $statusColors[$booking->booking_status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $statusLabels[$booking->booking_status] ?? $booking->booking_status }}
                                </span>
                            </div>

                        </div>

                        <!-- Detail -->
                        <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">

                            <div>
                                <p class="text-xs text-slate-400">Nama Pemesan</p>
                                <p class="mt-1 font-semibold text-slate-700">
                                    {{ $booking->user->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Tanggal Booking</p>
                                <p class="mt-1 font-semibold text-slate-700">
                                    {{ $booking->booking_date->format('d F Y') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Waktu</p>
                                <p class="mt-1 font-semibold text-slate-700">
                                    {{ substr($booking->start_time, 0, 5) }}
                                    -
                                    {{ substr($booking->end_time, 0, 5) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Durasi</p>
                                <p class="mt-1 font-semibold text-slate-700">
                                    {{ $booking->duration_minutes }} menit
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Total Harga</p>
                                <p class="mt-1 font-bold text-blue-600">
                                    Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Catatan Pemesan</p>
                                <p class="mt-1 text-sm text-slate-700">
                                    {{ $booking->user_notes ?: '-' }}
                                </p>
                            </div>

                        </div>

                        <!-- Tombol Aksi Owner -->
                         {{-- Konfirmasi Pembayaran Cash --}}
                        @if (
                            $booking->booking_status === 'confirmed' &&
                            $booking->paymentRecord &&
                            $booking->paymentRecord->payment_method === 'cash'
                        )
                            <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-5">

                                <h4 class="font-semibold text-slate-800">
                                    Pembayaran Cash
                                </h4>

                                @if ($booking->paymentRecord->payment_status === 'paid')

                                    <p class="mt-2 text-sm font-medium text-green-700">
                                        ✓ Pembayaran sudah diterima dan dikonfirmasi.
                                    </p>

                                @elseif ($booking->paymentRecord->payment_status === 'unpaid')

                                    <p class="mt-2 text-sm text-slate-600">
                                        User memilih pembayaran Cash. Pastikan uang sudah diterima
                                        secara langsung sebelum mengonfirmasi pembayaran.
                                    </p>

                                    <form
                                        action="{{ route('owner.bookings.cash.confirm', $booking->id) }}"
                                        method="POST"
                                        class="mt-4"
                                        onsubmit="return confirm('Apakah pembayaran Cash untuk booking ini sudah benar-benar diterima?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700"
                                        >
                                            ✓ Konfirmasi Pembayaran Cash
                                        </button>
                                    </form>

                                @else

                                    <p class="mt-2 text-sm text-amber-700">
                                        Status pembayaran:
                                        {{ $booking->paymentRecord->payment_status }}
                                    </p>

                                @endif

                            </div>
                        @endif
                        @if ($booking->booking_status === 'pending_confirmation')
                            <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-5">

                                <!-- Form Terima Booking -->
                                <form action="{{ route('owner.bookings.confirm', $booking->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah kamu yakin ingin menerima booking ini?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:bg-green-700">
                                        ✓ Terima Booking
                                    </button>
                                </form>

                                <!-- Form Tolak Booking -->
                                <form action="{{ route('owner.bookings.reject', $booking->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah kamu yakin ingin menolak booking ini?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700">
                                        ✕ Tolak Booking
                                    </button>
                                </form>

                            </div>
                        @endif

                        {{-- Tombol Selesaikan Booking --}}
                        @if ($booking->booking_status === 'checked_in')
                            <div class="mt-6 border-t border-slate-100 pt-5">

                                <form action="{{ route('owner.bookings.complete', $booking->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah booking ini sudah benar-benar selesai?')">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="rounded-xl bg-purple-600 px-5 py-3 text-sm font-semibold text-white hover:bg-purple-700">
                                        ✓ Selesaikan Booking
                                    </button>

                                </form>

                            </div>
                        @endif

                    </div>

                @empty

                    <div class="p-12 text-center">
                        <div class="mb-4 text-5xl">📋</div>

                        <h3 class="text-lg font-bold text-slate-800">
                            Belum Ada Booking
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Belum ada pemesanan yang masuk ke venue milikmu.
                        </p>
                    </div>

                @endforelse

                <!-- Pagination -->
                @if ($bookings->hasPages())
                    <div class="border-t border-slate-100 p-6">
                        {{ $bookings->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
