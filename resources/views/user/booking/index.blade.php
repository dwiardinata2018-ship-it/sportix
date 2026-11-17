<x-app-layout>
    <div class="min-h-screen bg-neu-base py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header Halaman --}}
            <div class="mb-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-4xl font-extrabold text-neu-dark tracking-tight">
                        My Booking
                    </h1>
                    <p class="mt-2 text-base font-medium text-neu-muted">
                        Pantau dan kelola seluruh riwayat pemesanan tempat olahraga kamu dengan mudah.
                    </p>
                </div>

                <a href="{{ route('user.reservation') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-7 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Booking Venue Baru
                </a>
            </div>

            {{-- Notifikasi Berhasil / Error --}}
            @if (session('success'))
                <div class="mb-8 rounded-[20px] border border-green-500/30 bg-neu-base shadow-neu-inset p-5 text-sm font-extrabold text-green-600 flex items-center gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-8 rounded-[20px] border border-red-500/30 bg-neu-base shadow-neu-inset p-5 text-sm font-extrabold text-red-500 flex items-center gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Widget Ringkasan Statistik --}}
            <div class="mb-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-[24px] bg-neu-base p-7 shadow-neu-raised flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">
                            Total Pemesanan
                        </p>
                        <p class="text-4xl font-extrabold text-neu-primary drop-shadow-sm">
                            {{ $bookings->total() }}
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
                            Halaman Aktif
                        </p>
                        <p class="text-4xl font-extrabold text-neu-primary drop-shadow-sm">
                            {{ $bookings->currentPage() }}
                        </p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Daftar Riwayat Booking --}}
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-neu-dark">
                        Riwayat Pemesanan
                    </h2>
                    <p class="mt-1 text-sm font-medium text-neu-muted">
                        Daftar lengkap seluruh aktivitas booking yang pernah kamu buat.
                    </p>
                </div>

                @if ($bookings->count() > 0)

                    <div class="space-y-8">
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

                                $statusConfig = [
                                    'pending_confirmation' => ['color' => 'text-yellow-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'confirmed' => ['color' => 'text-green-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>'],
                                    'rejected' => ['color' => 'text-red-500', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>'],
                                    'cancelled' => ['color' => 'text-neu-muted', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>'],
                                    'checked_in' => ['color' => 'text-neu-primary', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'completed' => ['color' => 'text-teal-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                    'expired' => ['color' => 'text-orange-500', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'],
                                ];

                                $status = $booking->booking_status;
                                $currentStatus = $statusConfig[$status] ?? ['color' => 'text-neu-muted', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'];
                            @endphp

                            {{-- Kartu Utama Booking --}}
                            <div class="overflow-hidden rounded-[28px] bg-neu-base shadow-neu-raised flex flex-col transition-all duration-300">

                                {{-- Bagian Atas: Kode Booking & Badge Status (Sudah Berupa Ikon) --}}
                                <div class="flex flex-col justify-between gap-4 border-b border-neu-muted/20 px-8 py-5 sm:flex-row sm:items-center bg-neu-base/50">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-neu-base shadow-neu-inset flex items-center justify-center font-bold text-neu-primary text-xs">
                                            ID
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-extrabold uppercase tracking-widest text-neu-muted">
                                                Kode Booking
                                            </p>
                                            <p class="text-lg font-extrabold text-neu-dark tracking-wide">
                                                {{ $booking->booking_code }}
                                            </p>
                                        </div>
                                    </div>

                                    <span class="inline-flex items-center gap-2 w-fit rounded-full bg-neu-base shadow-neu-inset px-5 py-2.5 text-xs font-extrabold tracking-wide {{ $currentStatus['color'] }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $currentStatus['icon'] !!}
                                        </svg>
                                        <span>{{ $statusLabels[$status] ?? ucfirst($status) }}</span>
                                    </span>
                                </div>

                                {{-- Bagian Tengah: Detail Venue & Kotak Grid Jadwal --}}
                                <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                                    {{-- Kolom Kiri: Info Venue (5 Span) --}}
                                    <div class="lg:col-span-5 flex flex-col justify-center">
                                        <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">
                                            Venue Olahraga
                                        </p>
                                        <h3 class="text-2xl font-extrabold text-neu-dark leading-snug">
                                            {{ $booking->venue->name ?? 'Venue tidak tersedia' }}
                                        </h3>
                                        <div class="mt-3 inline-flex items-center gap-2 rounded-xl bg-neu-base shadow-neu-inset px-4 py-2 w-fit">
                                            <svg class="w-4 h-4 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <span class="text-xs font-extrabold text-neu-dark">
                                                {{ $booking->unit->name ?? 'Unit tidak tersedia' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan: Grid Jadwal & Harga (7 Span) --}}
                                    <div class="lg:col-span-7 rounded-[22px] bg-neu-base shadow-neu-inset p-6 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center sm:text-left">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Tanggal</p>
                                            <p class="text-sm font-extrabold text-neu-dark">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Waktu</p>
                                            <p class="text-sm font-extrabold text-neu-dark">
                                                {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Durasi</p>
                                            <p class="text-sm font-extrabold text-neu-dark">
                                                {{ $booking->duration_minutes }} Menit
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold uppercase text-neu-muted tracking-wider mb-1">Total Harga</p>
                                            <p class="text-sm font-extrabold text-neu-primary">
                                                Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                </div>

                                {{-- Catatan Pengguna (Jika Ada) --}}
                                @if ($booking->user_notes)
                                    <div class="mx-8 mb-6 rounded-2xl bg-neu-base shadow-neu-inset px-6 py-4">
                                        <p class="text-xs font-bold uppercase tracking-wider text-neu-muted mb-1">
                                            Catatan Pemesanan
                                        </p>
                                        <p class="text-sm font-medium text-neu-dark/80 italic">
                                            "{{ $booking->user_notes }}"
                                        </p>
                                    </div>
                                @endif

                                {{-- Bagian Bawah: Aksi Pembayaran & QR Check-in --}}
                                @if ($booking->booking_status === 'confirmed' && $booking->paymentRecord)
                                    <div class="border-t border-neu-muted/20 px-8 py-5 bg-neu-base/30">
                                        @if ($booking->paymentRecord->payment_status === 'paid')
                                            <div class="rounded-2xl bg-neu-base shadow-neu-inset border border-green-500/30 p-4 flex items-center gap-4">
                                                <div class="w-9 h-9 rounded-full bg-neu-base shadow-neu-raised flex items-center justify-center text-green-500 shrink-0 font-bold">
                                                    ✓
                                                </div>
                                                <div>
                                                    <p class="text-sm font-extrabold text-green-600">Pembayaran Sudah Berhasil</p>
                                                    <p class="text-xs font-bold text-neu-muted">Transaksi pembayaran diverifikasi lunas.</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                                <div>
                                                    <p class="text-sm font-extrabold text-neu-dark">Menunggu Pembayaran QRIS</p>
                                                    <p class="text-xs font-medium text-neu-muted mt-0.5">Selesaikan pembayaran untuk mengonfirmasi jadwal.</p>
                                                </div>
                                                <a href="{{ route('user.booking.payment', $booking->id) }}"
                                                   class="inline-flex items-center justify-center gap-2 rounded-full bg-green-600 px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                                    Bayar Sekarang
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Tombol QR Check-in --}}
                                @if ($booking->booking_status === 'confirmed')
                                    <div class="border-t border-neu-muted/20 px-8 py-5 bg-neu-base/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <p class="text-xs font-bold text-neu-muted flex items-center gap-2">
                                            <svg class="w-4 h-4 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Tunjukkan QR Code ini kepada Owner saat tiba di venue.
                                        </p>
                                        <a href="{{ route('user.booking.qr', $booking->id) }}"
                                           class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h2v2h-2zM18 14h2v2h-2zM14 18h2v2h-2zM18 18h2v2h-2z" />
                                            </svg>
                                            Lihat QR Check-in
                                        </a>
                                    </div>
                                @endif

                                {{-- Form Ulasan & Rating (Jika Booking Selesai) --}}
                                @if ($booking->booking_status === 'completed')
                                    <div class="border-t border-neu-muted/25 px-8 py-7 bg-neu-base shadow-neu-inset">
                                        @if ($booking->review)
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                                                <div class="w-12 h-12 rounded-2xl bg-neu-base shadow-neu-raised flex items-center justify-center text-teal-600 shrink-0 font-bold text-xl">
                                                    ★
                                                </div>
                                                <div>
                                                    <p class="text-sm font-extrabold text-teal-700">
                                                        Terima kasih! Kamu sudah memberikan ulasan untuk venue ini.
                                                    </p>
                                                    <div class="mt-2 flex items-center gap-3">
                                                        <div class="text-lg text-yellow-500 tracking-widest">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                {{ $i <= $booking->review->rating ? '★' : '☆' }}
                                                            @endfor
                                                        </div>
                                                        <span class="text-xs font-extrabold text-neu-dark bg-neu-base shadow-neu-raised px-3 py-1 rounded-full">
                                                            Rating: {{ $booking->review->rating }}/5
                                                        </span>
                                                    </div>
                                                    @if ($booking->review->comment)
                                                        <p class="mt-3 text-sm font-medium text-neu-dark/80 italic">
                                                            "{{ $booking->review->comment }}"
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div>
                                                <h3 class="text-lg font-extrabold text-neu-dark flex items-center gap-2 mb-1">
                                                    <svg class="w-5 h-5 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                                    Berikan Ulasan & Rating
                                                </h3>
                                                <p class="text-sm font-medium text-neu-muted mb-6">
                                                    Bagaimana pengalamanmu bermain di venue ini? Masukanmu sangat berharga.
                                                </p>

                                                <form action="{{ route('user.booking.review.store', $booking->id) }}" method="POST" class="space-y-5">
                                                    @csrf
                                                    
                                                    <div>
                                                        <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Pilih Rating Bintang</label>
                                                        <div class="relative">
                                                            <select name="rating" required
                                                                    class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-bold text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none appearance-none cursor-pointer">
                                                                <option value="">-- Pilih Rating --</option>
                                                                @for ($i = 5; $i >= 1; $i--)
                                                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                                                        {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-neu-muted">
                                                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                            </div>
                                                        </div>
                                                        @error('rating')
                                                            <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="mb-2 block text-sm font-bold text-neu-dark ml-1">Komentar atau Ulasan (Opsional)</label>
                                                        <textarea name="comment" rows="3" maxlength="2000" placeholder="Ceritakan pengalamanmu..."
                                                                  class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-medium text-neu-dark focus:ring-0 focus:shadow-neu-pressed transition-all outline-none resize-none">{{ old('comment') }}</textarea>
                                                        @error('comment')
                                                            <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <button type="submit"
                                                            class="rounded-full bg-neu-primary px-8 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                                        Kirim Ulasan Sekarang
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
                    <div class="mt-12">
                        <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-4">
                            {{ $bookings->links() }}
                        </div>
                    </div>

                @else

                    {{-- State Kosong / Belum Ada Pemesanan --}}
                    <div class="flex flex-col items-center justify-center rounded-[32px] bg-neu-base shadow-neu-inset px-6 py-24 text-center">
                        <div class="mb-6 flex h-28 w-28 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-neu-primary">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-extrabold text-neu-dark">
                            Belum Ada Pemesanan
                        </h3>
                        <p class="mt-3 text-base font-medium text-neu-muted max-w-md">
                            Kamu belum memiliki riwayat pemesanan lapangan. Yuk, cari dan temukan tempat olahraga favoritmu sekarang!
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