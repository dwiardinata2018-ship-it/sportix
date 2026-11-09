
<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">
                    Activity
                </h1>

                <p class="mt-2 text-slate-500">
                    Lihat seluruh aktivitas booking dan pembayaran yang pernah kamu lakukan.
                </p>
            </div>

            {{-- Ringkasan --}}
            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Total Aktivitas
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $activities->total() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Halaman Saat Ini
                    </p>

                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $activities->currentPage() }}
                    </p>
                </div>
            </div>

            {{-- Daftar Aktivitas --}}
            <section>
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-800">
                        Riwayat Aktivitas
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Aktivitas terbaru ditampilkan terlebih dahulu.
                    </p>
                </div>

                @if ($activities->count() > 0)

                    <div class="space-y-4">
                        @foreach ($activities as $activity)

                            @php
                                $isPayment = $activity['type'] === 'payment';

                                $statusColors = [
                                    'pending_confirmation' => 'bg-yellow-50 text-yellow-700',
                                    'confirmed' => 'bg-green-50 text-green-700',
                                    'rejected' => 'bg-red-50 text-red-700',
                                    'cancelled' => 'bg-slate-100 text-slate-600',
                                    'checked_in' => 'bg-blue-50 text-blue-700',
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'expired' => 'bg-orange-50 text-orange-700',

                                    'unpaid' => 'bg-yellow-50 text-yellow-700',
                                    'awaiting_verification' => 'bg-blue-50 text-blue-700',
                                    'paid' => 'bg-green-50 text-green-700',
                                    'payment_disputed' => 'bg-red-50 text-red-700',
                                    'refunded' => 'bg-purple-50 text-purple-700',
                                ];

                                $statusLabels = [
                                    'pending_confirmation' => 'Menunggu Konfirmasi',
                                    'confirmed' => 'Dikonfirmasi',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                    'checked_in' => 'Sudah Check-in',
                                    'completed' => 'Selesai',
                                    'expired' => 'Kedaluwarsa',

                                    'unpaid' => 'Belum Lunas',
                                    'awaiting_verification' => 'Menunggu Verifikasi',
                                    'paid' => 'Berhasil Dibayar',
                                    'payment_disputed' => 'Pembayaran Bermasalah',
                                    'refunded' => 'Dikembalikan',
                                ];

                                $status = $activity['status'];
                            @endphp

                            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

                                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">

                                    <div class="flex items-start gap-4">

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl
                                            {{ $isPayment ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600' }}">

                                            @if ($isPayment)
                                                {{-- Ikon Pembayaran --}}
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3 10h18M7 15h2m4 0h2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                                </svg>
                                            @else
                                                {{-- Ikon Booking --}}
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z" />
                                                </svg>
                                            @endif

                                        </div>

                                        <div>
                                            <h3 class="font-bold text-slate-800">
                                                {{ $activity['title'] }}
                                            </h3>

                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $activity['description'] }}
                                            </p>
                                        </div>

                                    </div>

                                    <span class="w-fit shrink-0 rounded-full px-4 py-2 text-xs font-semibold
                                        {{ $statusColors[$status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>

                                </div>

                                <div class="mt-5 grid grid-cols-1 gap-3 border-t border-slate-100 pt-4 sm:grid-cols-2">

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Kode Booking
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $activity['booking_code'] }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Venue
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $activity['venue'] }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Unit
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $activity['unit'] }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">
                                            Waktu Aktivitas
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700">
                                            {{ $activity['created_at']?->translatedFormat('d F Y, H:i') ?? '-' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="mt-4 border-t border-slate-100 pt-4">

                                    @if ($isPayment)

                                        <a href="{{ route('user.booking.payment', $activity['booking_id']) }}"
                                            class="inline-flex items-center rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                                            Lihat Pembayaran →
                                        </a>

                                    @else

                                        <a href="{{ route('user.booking') }}"
                                            class="text-sm font-semibold text-blue-600 transition hover:text-blue-700">
                                            Lihat My Booking →
                                        </a>

                                    @endif

                                </div>

                            </div>

                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $activities->links() }}
                    </div>

                @else

                    {{-- Belum Ada Aktivitas --}}
                    <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                        <div class="mb-4 text-5xl">
                            📋
                        </div>

                        <h3 class="text-lg font-bold text-slate-700">
                            Belum Ada Aktivitas
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Aktivitas booking dan pembayaran kamu akan muncul di sini.
                        </p>

                        <a href="{{ route('user.reservation') }}"
                            class="mt-6 inline-block rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Cari Venue Sekarang
                        </a>

                    </div>

                @endif

            </section>

        </div>
    </div>
</x-app-layout>
