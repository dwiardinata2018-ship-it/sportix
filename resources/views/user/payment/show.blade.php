<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h2 class="text-2xl font-bold mb-6">
                        Pembayaran Booking Sportix
                    </h2>

                    {{-- Notifikasi Berhasil --}}
                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Notifikasi Gagal --}}
                    @if (session('error'))
                        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Informasi Booking --}}
                    <div class="border rounded-lg p-5 mb-6">
                        <h3 class="font-semibold text-lg mb-4">
                            Detail Booking
                        </h3>

                        <div class="space-y-2 text-sm">
                            <p>
                                <strong>Kode Booking:</strong>
                                {{ $booking->booking_code }}
                            </p>

                            <p>
                                <strong>Venue:</strong>
                                {{ $booking->venue->name ?? '-' }}
                            </p>

                            <p>
                                <strong>Unit:</strong>
                                {{ $booking->unit->name ?? '-' }}
                            </p>

                            <p>
                                <strong>Tanggal:</strong>
                                {{ $booking->booking_date->format('d-m-Y') }}
                            </p>

                            <p>
                                <strong>Waktu:</strong>
                                {{ $booking->start_time }} -
                                {{ $booking->end_time }}
                            </p>
                        </div>

                        <div class="border-t mt-4 pt-4">
                            <p class="text-sm text-gray-500">
                                Total Pembayaran
                            </p>

                            <p class="text-2xl font-bold text-blue-600">
                                Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Informasi Pembayaran --}}
                    <div class="border rounded-lg p-5">
                        <h3 class="font-semibold text-lg mb-4">
                            Metode Pembayaran
                        </h3>

                        @if ($payment->payment_status !== 'paid')
                        <div class="mb-5 rounded-lg bg-blue-50 p-4 text-blue-800">
                            <p class="font-semibold">
                                Pilih metode pembayaran
                            </p>

                            <p class="mt-1 text-sm">
                                Kamu dapat membayar langsung kepada Owner secara Cash
                                sebelum check-in.
                            </p>

                            @if ($payment->payment_method !== 'cash')
                                <form
                                    action="{{ route('user.booking.payment.cash', $booking->id) }}"
                                    method="POST"
                                    class="mt-4"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg"
                                    >
                                        Pilih Pembayaran Cash
                                    </button>
                                </form>
                            @else
                                <div class="mt-4 rounded-lg bg-green-100 p-4 text-green-800">
                                    <p class="font-semibold">
                                        Pembayaran Cash dipilih
                                    </p>

                                    <p class="mt-1 text-sm">
                                        Silakan bayar langsung kepada Owner sebelum melakukan
                                        check-in.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                        @if ($payment->payment_status === 'paid')

                            <div class="bg-green-100 text-green-800 p-4 rounded-lg">
                                <p class="font-semibold">
                                    Pembayaran berhasil!
                                </p>

                                <p class="text-sm mt-1">
                                    Pembayaran booking ini sudah lunas.
                                    Terima kasih telah menggunakan Sportix.
                                </p>
                            </div>

                        @elseif ($isExpired || $isTerminal)
                            <div class="bg-red-100 text-red-800 p-4 rounded-lg">
                                <p class="font-semibold">
                                    QRIS sudah tidak dapat digunakan.
                                </p>

                                <p class="text-sm mt-1">
                                    Transaksi sebelumnya telah kedaluwarsa atau dibatalkan.
                                    Kamu dapat meminta QRIS baru.
                                </p>
                            </div>

                            <form
                                action="{{ route('user.booking.payment.retry', $booking->id) }}"
                                method="POST"
                                class="mt-4"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
                                >
                                    Buat QRIS Baru
                                </button>
                            </form>

                        @elseif ($showQr)

                            <div class="text-center">
                                <p class="mb-4 text-gray-600">
                                    Silakan scan QRIS berikut menggunakan
                                    aplikasi pembayaran yang mendukung QRIS.
                                </p>

                                <img
                                    src="{{ $payment->midtrans_qr_url }}"
                                    alt="QRIS Sportix"
                                    class="mx-auto w-64 h-64 object-contain border rounded-lg p-2"
                                >

                                <p class="mt-4 font-semibold">
                                    Status:
                                    {{ ucfirst($transactionStatus ?? 'pending') }}
                                </p>

                                @if ($payment->midtrans_expired_at)
                                    <p class="text-sm text-red-600 mt-2">
                                        Berlaku sampai:
                                        {{ $payment->midtrans_expired_at->format('d-m-Y H:i') }}
                                    </p>
                                @endif

                                <p class="text-sm text-gray-500 mt-3">
                                    Jika sudah membayar, muat ulang halaman
                                    ini untuk memeriksa status pembayaran.
                                </p>
                            </div>

                        @else

                            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                                <p class="font-semibold">
                                    QRIS belum tersedia.
                                </p>

                                <p class="text-sm mt-1">
                                    Silakan coba membuat QRIS atau hubungi Owner.
                                </p>
                            </div>

                            <form
                                action="{{ route('user.booking.payment.retry', $booking->id) }}"
                                method="POST"
                                class="mt-4"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
                                >
                                    Buat QRIS
                                </button>
                            </form>

                        @endif
                    </div>

                    {{-- Tombol Navigasi --}}
                    <div class="mt-6 flex flex-wrap gap-3">

                        <a
                            href="{{ route('user.booking.payment', $booking->id) }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg"
                        >
                            Muat Ulang Status
                        </a>

                        <a
                            href="{{ route('user.booking') }}"
                            class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg"
                        >
                            Kembali ke Booking
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>