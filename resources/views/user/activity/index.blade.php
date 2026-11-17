<x-app-layout>
    <div class="min-h-screen bg-neu-base py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-extrabold text-neu-dark tracking-tight">
                    Activity
                </h1>
                <p class="mt-2 text-base font-medium text-neu-muted">
                    Lihat seluruh aktivitas booking dan pembayaran yang pernah kamu lakukan.
                </p>
            </div>

            {{-- Ringkasan Statistik (Neumorphism Cards) --}}
            <div class="mb-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-[24px] bg-neu-base p-7 shadow-neu-raised flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">
                            Total Aktivitas
                        </p>
                        <p class="text-4xl font-extrabold text-neu-primary drop-shadow-sm">
                            {{ $activities->total() }}
                        </p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </div>

                <div class="rounded-[24px] bg-neu-base p-7 shadow-neu-raised flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">
                            Halaman Saat Ini
                        </p>
                        <p class="text-4xl font-extrabold text-neu-primary drop-shadow-sm">
                            {{ $activities->currentPage() }}
                        </p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Daftar Aktivitas --}}
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-neu-dark">
                        Riwayat Aktivitas
                    </h2>
                    <p class="mt-1 text-sm font-medium text-neu-muted">
                        Aktivitas terbaru ditampilkan terlebih dahulu.
                    </p>
                </div>

                @if ($activities->count() > 0)

                    <div class="space-y-6">
                        @foreach ($activities as $activity)

                            @php
                                $isPayment = $activity['type'] === 'payment';

                                // Definisi warna dan ikon SVG untuk setiap status
                                $statusConfig = [
                                    'confirmed' => ['color' => 'text-green-600', 'label' => 'Dikonfirmasi', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>'],
                                    'completed' => ['color' => 'text-teal-600', 'label' => 'Selesai', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'checked_in' => ['color' => 'text-neu-primary', 'label' => 'Sudah Check-in', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'pending_confirmation' => ['color' => 'text-yellow-600', 'label' => 'Menunggu Konfirmasi', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'rejected' => ['color' => 'text-red-500', 'label' => 'Ditolak', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>'],
                                    'cancelled' => ['color' => 'text-neu-muted', 'label' => 'Dibatalkan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>'],
                                    'expired' => ['color' => 'text-orange-500', 'label' => 'Kedaluwarsa', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'],

                                    'paid' => ['color' => 'text-green-600', 'label' => 'Berhasil Dibayar', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>'],
                                    'awaiting_verification' => ['color' => 'text-neu-primary', 'label' => 'Menunggu Verifikasi', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'unpaid' => ['color' => 'text-yellow-600', 'label' => 'Belum Lunas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'payment_disputed' => ['color' => 'text-red-500', 'label' => 'Pembayaran Bermasalah', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>'],
                                    'refunded' => ['color' => 'text-purple-600', 'label' => 'Dikembalikan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>'],
                                ];

                                $status = $activity['status'];
                                $currentStatus = $statusConfig[$status] ?? ['color' => 'text-neu-muted', 'label' => ucfirst($status), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'];
                            @endphp

                            <div class="overflow-hidden rounded-[28px] bg-neu-base shadow-neu-raised flex flex-col p-8 transition-all duration-300">

                                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-neu-base shadow-neu-inset {{ $isPayment ? 'text-green-600' : 'text-neu-primary' }}">
                                            @if ($isPayment)
                                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h2m4 0h2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                                </svg>
                                            @else
                                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z" />
                                                </svg>
                                            @endif
                                        </div>

                                        <div>
                                            <h3 class="text-xl font-extrabold text-neu-dark">
                                                {{ $activity['title'] }}
                                            </h3>
                                            <p class="mt-1 text-sm font-medium text-neu-muted">
                                                {{ $activity['description'] }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Badge Status Diganti dengan Ikon SVG dan Teks Rapi --}}
                                    <span class="inline-flex items-center gap-2 w-fit rounded-full bg-neu-base shadow-neu-inset px-5 py-2.5 text-xs font-extrabold tracking-wide {{ $currentStatus['color'] }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $currentStatus['icon'] !!}
                                        </svg>
                                        <span>{{ $currentStatus['label'] }}</span>
                                    </span>
                                </div>

                                {{-- Grid Detail Informasi --}}
                                <div class="mt-6 rounded-[22px] bg-neu-base shadow-neu-inset p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Kode Booking</p>
                                        <p class="text-sm font-extrabold text-neu-dark">
                                            {{ $activity['booking_code'] }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Venue</p>
                                        <p class="text-sm font-extrabold text-neu-dark">
                                            {{ $activity['venue'] }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Unit</p>
                                        <p class="text-sm font-extrabold text-neu-dark">
                                            {{ $activity['unit'] }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Waktu Aktivitas</p>
                                        <p class="text-sm font-extrabold text-neu-dark">
                                            {{ $activity['created_at']?->translatedFormat('d M Y, H:i') ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Aksi / Tombol Tautan --}}
                                <div class="mt-6 pt-4 border-t border-neu-muted/20 flex items-center justify-end">
                                    @if ($isPayment)
                                        <a href="{{ route('user.booking.payment', $activity['booking_id']) }}"
                                           class="inline-flex items-center gap-2 rounded-full bg-green-600 px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                            Lihat Pembayaran
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('user.booking') }}"
                                           class="inline-flex items-center gap-2 rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                            Lihat My Booking
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- Custom Neumorphism Pagination --}}
                    @if ($activities->hasPages())
                        <div class="mt-12 flex justify-center">
                            <nav class="inline-flex rounded-[20px] bg-neu-base shadow-neu-inset p-2 gap-1 items-center">
                                
                                {{-- Tombol Previous --}}
                                @if ($activities->onFirstPage())
                                    <span class="flex items-center justify-center w-11 h-11 rounded-[14px] text-neu-muted/40 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                                    </span>
                                @else
                                    <a href="{{ $activities->previousPageUrl() }}" class="flex items-center justify-center w-11 h-11 rounded-[14px] bg-neu-base shadow-neu-raised text-neu-dark font-extrabold transition-all hover:shadow-neu-hover active:shadow-neu-pressed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                                    </a>
                                @endif

                                {{-- Nomor Halaman --}}
                                @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                                    @if ($page == $activities->currentPage())
                                        <span class="flex items-center justify-center w-11 h-11 rounded-[14px] bg-neu-base shadow-neu-pressed text-neu-primary font-extrabold text-sm">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="flex items-center justify-center w-11 h-11 rounded-[14px] bg-neu-base shadow-neu-raised text-neu-dark font-extrabold text-sm transition-all hover:shadow-neu-hover active:shadow-neu-pressed">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Tombol Next --}}
                                @if ($activities->hasMorePages())
                                    <a href="{{ $activities->nextPageUrl() }}" class="flex items-center justify-center w-11 h-11 rounded-[14px] bg-neu-base shadow-neu-raised text-neu-dark font-extrabold transition-all hover:shadow-neu-hover active:shadow-neu-pressed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                @else
                                    <span class="flex items-center justify-center w-11 h-11 rounded-[14px] text-neu-muted/40 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </span>
                                @endif

                            </nav>
                        </div>
                    @endif

                @else

                    {{-- State Kosong --}}
                    <div class="flex flex-col items-center justify-center rounded-[32px] bg-neu-base shadow-neu-inset px-6 py-24 text-center">
                        <div class="mb-6 flex h-28 w-28 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-neu-primary">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>

                        <h3 class="text-3xl font-extrabold text-neu-dark">
                            Belum Ada Aktivitas
                        </h3>

                        <p class="mt-3 text-base font-medium text-neu-muted max-w-md">
                            Aktivitas booking dan pembayaran kamu akan muncul di sini secara otomatis.
                        </p>

                        <a href="{{ route('user.reservation') }}"
                           class="mt-8 inline-block rounded-full bg-neu-primary px-9 py-4 text-base font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                            Cari Venue Sekarang
                        </a>
                    </div>

                @endif
            </section>

        </div>
    </div>
</x-app-layout>