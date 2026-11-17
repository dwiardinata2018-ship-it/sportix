<x-app-layout>
    <div class="min-h-screen bg-neu-base py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $payment = $booking->paymentRecord;

                $isExpired = $payment->midtrans_expired_at
                    && $payment->midtrans_expired_at->isPast();

                $transactionStatus = $payment->midtrans_transaction_status;

                $isTerminal = in_array(
                    $transactionStatus,
                    ['expire', 'cancel', 'deny'],
                    true
                );

                $showQr = $payment->midtrans_qr_url
                    && !$isExpired
                    && !$isTerminal;
            @endphp

            {{-- Kartu Utama Neumorphism --}}
            <div class="rounded-[32px] bg-neu-base shadow-neu-raised p-8 sm:p-10">

                <h2 class="text-3xl font-extrabold text-neu-dark tracking-tight mb-8 flex items-center gap-3">
                    <div class="h-12 w-12 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h2m4 0h2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>
                    </div>
                    <span>Pembayaran Booking Sportix</span>
                </h2>

                {{-- Notifikasi Berhasil --}}
                @if (session('success'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 text-sm font-extrabold text-green-600 flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Notifikasi Gagal --}}
                @if (session('error'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 text-sm font-extrabold text-red-500 flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Informasi Booking --}}
                <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-7 mb-8">
                    <h3 class="font-extrabold text-lg text-neu-dark mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Detail Booking
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm font-medium">
                        <div class="rounded-xl bg-neu-base shadow-neu-raised p-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-neu-muted block mb-1">Kode Booking</span>
                            <span class="font-extrabold text-neu-dark text-base">{{ $booking->booking_code }}</span>
                        </div>
                        <div class="rounded-xl bg-neu-base shadow-neu-raised p-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-neu-muted block mb-1">Venue</span>
                            <span class="font-extrabold text-neu-dark text-base">{{ $booking->venue->name ?? '-' }}</span>
                        </div>
                        <div class="rounded-xl bg-neu-base shadow-neu-raised p-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-neu-muted block mb-1">Unit / Lapangan</span>
                            <span class="font-extrabold text-neu-dark text-base">{{ $booking->unit->name ?? '-' }}</span>
                        </div>
                        <div class="rounded-xl bg-neu-base shadow-neu-raised p-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-neu-muted block mb-1">Jadwal Main</span>
                            <span class="font-extrabold text-neu-dark text-base">{{ $booking->booking_date->format('d-m-Y') }} | {{ $booking->start_time }} - {{ $booking->end_time }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-neu-muted/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <span class="text-sm font-bold text-neu-muted">Total Pembayaran</span>
                        <span class="text-3xl font-extrabold text-neu-primary">
                            Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Informasi Metode Pembayaran --}}
                <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-7 mb-8">
                    <h3 class="font-extrabold text-lg text-neu-dark mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Metode Pembayaran
                    </h3>

                    @if ($payment->payment_status !== 'paid')
                        <div class="mb-6 rounded-[20px] bg-neu-base shadow-neu-raised p-5">
                            <p class="font-extrabold text-neu-dark text-base">
                                Pilih Metode Pembayaran
                            </p>
                            <p class="mt-1 text-sm font-medium text-neu-muted">
                                Kamu dapat membayar langsung kepada Owner secara Cash sebelum check-in atau menggunakan QRIS otomatis di bawah.
                            </p>

                            @if ($payment->payment_method !== 'cash')
                                <form action="{{ route('user.booking.payment.cash', $booking->id) }}" method="POST" class="mt-5">
                                    @csrf
                                    <button type="submit"
                                            class="rounded-full bg-green-600 px-7 py-3 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                        Pilih Pembayaran Cash
                                    </button>
                                </form>
                            @else
                                <div class="mt-5 rounded-[16px] bg-neu-base shadow-neu-inset p-4 text-green-700 flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <div>
                                        <p class="font-extrabold text-sm">Pembayaran Cash Dipilih</p>
                                        <p class="text-xs font-medium mt-0.5">Silakan bayar langsung kepada Owner sebelum melakukan check-in.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($payment->payment_status === 'paid')

                        <div class="rounded-[20px] bg-neu-base shadow-neu-raised p-6 flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="font-extrabold text-base text-green-700">Pembayaran Berhasil!</p>
                                <p class="text-xs font-medium text-neu-muted mt-0.5">Pembayaran booking ini sudah lunas. Terima kasih telah menggunakan Sportix.</p>
                            </div>
                        </div>

                    @elseif ($isExpired || $isTerminal)
                        <div class="rounded-[20px] bg-neu-base shadow-neu-raised p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="h-12 w-12 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-red-500 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="font-extrabold text-base text-red-600">QRIS Sudah Tidak Dapat Digunakan</p>
                                    <p class="text-xs font-medium text-neu-muted mt-0.5">Transaksi sebelumnya telah kedaluwarsa atau dibatalkan. Kamu dapat meminta QRIS baru.</p>
                                </div>
                            </div>

                            <form action="{{ route('user.booking.payment.retry', $booking->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit"
                                        class="rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                    Buat QRIS Baru
                                </button>
                            </form>
                        </div>

                    @elseif ($showQr)

                        <div class="text-center py-4">
                            <p class="text-sm font-medium text-neu-muted mb-6">
                                Silakan scan QRIS berikut menggunakan aplikasi pembayaran yang mendukung QRIS.
                            </p>

                            <div class="inline-block rounded-[24px] bg-neu-base shadow-neu-raised p-4 mb-6">
                                <img src="{{ $payment->midtrans_qr_url }}"
                                     alt="QRIS Sportix"
                                     class="w-64 h-64 object-contain rounded-xl mx-auto">
                            </div>

                            <div class="rounded-[20px] bg-neu-base shadow-neu-inset p-5 max-w-md mx-auto space-y-2">
                                <p class="text-sm font-extrabold text-neu-dark">
                                    Status: <span class="text-neu-primary uppercase">{{ ucfirst($transactionStatus ?? 'pending') }}</span>
                                </p>

                                @if ($payment->midtrans_expired_at)
                                    <p class="text-xs font-bold text-red-500">
                                        Berlaku sampai: {{ $payment->midtrans_expired_at->format('d-m-Y H:i') }}
                                    </p>
                                @endif

                                <p class="text-xs font-medium text-neu-muted pt-2 border-t border-neu-muted/15">
                                    Jika sudah membayar, muat ulang halaman ini untuk memeriksa status pembayaran.
                                </p>
                            </div>
                        </div>

                    @else

                        <div class="rounded-[20px] bg-neu-base shadow-neu-raised p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="h-12 w-12 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-yellow-600 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="font-extrabold text-base text-yellow-700">QRIS Belum Tersedia</p>
                                    <p class="text-xs font-medium text-neu-muted mt-0.5">Silakan coba membuat QRIS atau hubungi Owner.</p>
                                </div>
                            </div>

                            <form action="{{ route('user.booking.payment.retry', $booking->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit"
                                        class="rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                    Buat QRIS
                                </button>
                            </form>
                        </div>

                    @endif

                </div>

                {{-- Tombol Navigasi Bawah --}}
                <div class="flex flex-wrap items-center justify-end gap-4 pt-4">
                    <a href="{{ route('user.booking.payment', $booking->id) }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-base px-7 py-3.5 text-sm font-extrabold text-neu-dark shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                        <svg class="w-4 h-4 text-neu-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Muat Ulang Status
                    </a>

                    <a href="{{ route('user.booking') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                        Kembali ke Booking
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>