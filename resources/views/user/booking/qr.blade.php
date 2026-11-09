
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Code Check-in Sportix
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 text-center">

                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    QR Code Booking
                </h3>

                <p class="text-gray-500 mb-6">
                    Tunjukkan QR Code ini kepada Owner saat tiba di venue.
                </p>

                <div class="flex justify-center mb-6">
                    <div class="p-4 border rounded-lg bg-white">
                        {!! $qrCode !!}
                    </div>
                </div>

                <div class="text-left space-y-3 border-t pt-5">

                    <div>
                        <p class="text-sm text-gray-500">Kode Booking</p>
                        <p class="font-semibold">
                            {{ $booking->booking_code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Venue</p>
                        <p class="font-semibold">
                            {{ $booking->venue->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Unit Olahraga</p>
                        <p class="font-semibold">
                            {{ $booking->unit->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal</p>
                        <p class="font-semibold">
                            {{ $booking->booking_date->format('d-m-Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Waktu</p>
                        <p class="font-semibold">
                            {{ substr($booking->start_time, 0, 5) }}
                            -
                            {{ substr($booking->end_time, 0, 5) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="font-semibold">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status Booking</p>
                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                            {{ ucfirst(str_replace('_', ' ', $booking->booking_status)) }}
                        </span>
                    </div>

                </div>

                <div class="mt-6">
                    <a href="{{ route('user.booking') }}"
                       class="inline-block px-5 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Kembali ke Booking Saya
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
