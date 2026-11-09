
<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">
                    QR Check-in Scanner
                </h1>
                <p class="mt-2 text-slate-500">
                    Pindai QR Code atau masukkan kode check-in pelanggan.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-xl bg-green-100 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-xl bg-red-100 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-100 p-4 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <!-- SCANNER KAMERA -->
                <div class="mb-5 text-center">
                    <h2 class="text-xl font-bold text-slate-800">
                        Kamera Scanner
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Arahkan kamera ke QR Code pelanggan.
                    </p>
                </div>

                <div id="qr-reader"
                     class="mx-auto w-full max-w-lg overflow-hidden rounded-xl">
                </div>

                <div id="scanner-message"
                     class="mt-5 rounded-xl bg-slate-100 p-4 text-center text-sm text-slate-600">
                    Scanner belum dimulai.
                </div>

                <div class="mt-5 flex flex-wrap justify-center gap-3">

                    <button type="button"
                            id="start-scanner"
                            class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Mulai Scanner
                    </button>

                    <button type="button"
                            id="stop-scanner"
                            disabled
                            class="rounded-xl bg-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-300 disabled:cursor-not-allowed disabled:opacity-50">
                        Hentikan Scanner
                    </button>

                </div>

                <!-- PEMISAH -->
                <div class="my-8 flex items-center gap-4">
                    <div class="h-px flex-1 bg-slate-200"></div>
                    <span class="text-sm font-semibold text-slate-400">
                        ATAU
                    </span>
                    <div class="h-px flex-1 bg-slate-200"></div>
                </div>

                <!-- CHECK-IN MANUAL -->
                <div class="rounded-xl border border-slate-200 p-5">
                    <h2 class="text-xl font-bold text-slate-800">
                        Check-in Manual
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Masukkan kode booking pelanggan jika kamera tidak dapat digunakan.
                    </p>

                    <form action="{{ route('owner.bookings.checkin.store') }}"
                          method="POST"
                          class="mt-5"
                          id="manual-checkin-form">

                        @csrf

                        <label for="manual-token"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Kode Booking
                        </label>

                        <input type="text"
                               name="token"
                               id="manual-token"
                               required
                               maxlength="255"
                               autocomplete="off"
                              placeholder="Contoh: SPX-VO0XQELLKYBD"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <button type="submit"
                                class="mt-4 w-full rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700">
                            Proses Check-in Manual
                        </button>
                    </form>
                </div>

                <!-- FORM UNTUK HASIL SCANNER -->
                <form id="checkin-form"
                      action="{{ route('owner.bookings.checkin.store') }}"
                      method="POST"
                      class="hidden">

                    @csrf

                    <input type="hidden"
                           name="token"
                           id="checkin-token">
                </form>

                <div class="mt-8 border-t border-slate-100 pt-5">
                    <a href="{{ route('owner.bookings.index') }}"
                       class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                        ← Kembali ke Manajemen Booking
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startButton = document.getElementById('start-scanner');
            const stopButton = document.getElementById('stop-scanner');
            const message = document.getElementById('scanner-message');
            const tokenInput = document.getElementById('checkin-token');
            const form = document.getElementById('checkin-form');

            let scanner = null;
            let isScanning = false;
            let isProcessing = false;

            function showMessage(text, isError = false) {
                message.textContent = text;
                message.className = isError
                    ? 'mt-5 rounded-xl bg-red-100 p-4 text-center text-sm text-red-700'
                    : 'mt-5 rounded-xl bg-slate-100 p-4 text-center text-sm text-slate-600';
            }

            async function stopScanner() {
                if (scanner && isScanning) {
                    try {
                        await scanner.stop();
                    } catch (error) {
                        console.error(error);
                    }

                    isScanning = false;
                }

                startButton.disabled = false;
                stopButton.disabled = true;
            }

            startButton.addEventListener('click', async function () {
                if (!window.Html5Qrcode) {
                    showMessage('Library scanner belum berhasil dimuat.', true);
                    return;
                }

                try {
                    scanner = new window.Html5Qrcode('qr-reader');

                    await scanner.start(
                        { facingMode: 'environment' },
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 }
                        },
                        async function (decodedText) {
                            if (isProcessing) return;

                            isProcessing = true;
                            tokenInput.value = decodedText;

                            showMessage('QR berhasil dibaca. Memproses check-in...');

                            await stopScanner();
                            form.submit();
                        },
                        function () {
                            // Abaikan hasil pemindaian yang belum menemukan QR.
                        }
                    );

                    isScanning = true;
                    startButton.disabled = true;
                    stopButton.disabled = false;

                    showMessage('Kamera aktif. Silakan arahkan ke QR Code.');
                } catch (error) {
                    console.error(error);
                    showMessage(
                        'Kamera tidak dapat dibuka. Periksa izin kamera browser.',
                        true
                    );
                }
            });

            stopButton.addEventListener('click', async function () {
                await stopScanner();
                showMessage('Scanner dihentikan.');
            });
        });
    </script>
</x-app-layout>
