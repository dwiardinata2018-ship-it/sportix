<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Check-in Scanner - Sportix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neu-base text-neu-dark antialiased selection:bg-neu-primary selection:text-white">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar Mandiri Khusus Owner -->
        <nav x-data="{ open: false }" class="bg-neu-base pt-6 pb-4">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">

                    <!-- KIRI: Logo & Badge Owner -->
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/owner/dashboard') }}"
                           class="text-3xl font-extrabold tracking-tight text-neu-primary drop-shadow-sm">
                            SPORTIX<span class="text-neu-muted">.</span>
                        </a>
                        <span class="hidden sm:inline-block rounded-full bg-neu-base shadow-neu-inset px-3.5 py-1 text-xs font-extrabold text-neu-primary uppercase tracking-wider">
                            Owner Panel
                        </span>
                    </div>

                    <!-- TENGAH: Menu Navigasi Owner -->
                    <div class="hidden md:flex md:items-center">
                        <div class="flex items-center space-x-2 bg-neu-base shadow-neu-inset rounded-full p-1.5">
                            <a href="{{ url('/owner/dashboard') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Dashboard
                            </a>
                            <a href="{{ url('/owner/venues') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Kelola Venue
                            </a>
                            <a href="{{ url('/owner/bookings') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Booking
                            </a>
                            <a href="{{ url('/owner/bookings/checkin') }}"
                               class="bg-neu-base shadow-neu-raised text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Check-in QR
                            </a>
                            <a href="{{ url('/owner/profile') }}"
                               class="text-neu-dark hover:text-neu-primary px-5 py-2 rounded-full text-sm font-bold transition-all duration-300">
                                Profil Usaha
                            </a>
                        </div>
                    </div>

                    <!-- KANAN: Info Akun & Tombol Logout -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-3">
                        <div class="rounded-full bg-neu-base shadow-neu-inset px-4 py-2.5 text-xs font-extrabold text-neu-dark">
                            {{ Auth::user()->name }}
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-neu-base shadow-neu-raised text-red-500 transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed focus:outline-none"
                                    title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Tombol Menu Mobile -->
                    <div class="flex items-center md:hidden">
                        <button @click="open = ! open"
                                class="inline-flex items-center justify-center h-11 w-11 rounded-full bg-neu-base shadow-neu-raised text-neu-dark hover:shadow-neu-pressed transition-all duration-300 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Menu Mobile -->
            <div :class="{ 'block': open, 'hidden': ! open }" class="hidden md:hidden bg-neu-base mt-4 px-4">
                <div class="bg-neu-base shadow-neu-inset rounded-3xl p-4 space-y-2">
                    <a href="{{ url('/owner/dashboard') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Dashboard</a>
                    <a href="{{ url('/owner/venues') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Kelola Venue</a>
                    <a href="{{ url('/owner/bookings') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Booking</a>
                    <a href="{{ url('/owner/bookings/checkin') }}" class="bg-neu-base shadow-neu-raised text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Check-in QR</a>
                    <a href="{{ url('/owner/profile') }}" class="text-neu-dark hover:text-neu-primary block w-full px-5 py-3 rounded-full font-bold">Profil Usaha</a>
                    <div class="border-t border-neu-muted/20 my-2 pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-5 py-3 text-start font-bold text-red-500">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-1 py-8">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

                <!-- Tombol Kembali -->
                <div class="mb-8">
                    <a href="{{ route('owner.bookings.index') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Manajemen Booking
                    </a>
                </div>

                <!-- Header Halaman -->
                <div class="mb-10">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                        QR Check-in Scanner
                    </h1>
                    <p class="mt-2 text-base font-medium text-neu-muted">
                        Pindai QR Code atau masukkan kode check-in pelanggan.
                    </p>
                </div>

                <!-- Alert Success / Error / Validation -->
                @if (session('success'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-green-500/30 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-extrabold text-green-600">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-red-500/30 flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-extrabold text-red-500">{{ session('error') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-red-500/30 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm font-extrabold text-red-500">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Card Utama Scanner & Check-in Manual -->
                <div class="rounded-[28px] bg-neu-base p-6 sm:p-10 shadow-neu-raised mb-8">

                    <!-- SCANNER KAMERA -->
                    <div class="mb-6 text-center">
                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-neu-base shadow-neu-inset text-neu-primary">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-extrabold text-neu-dark">
                            Kamera Scanner
                        </h2>
                        <p class="mt-1.5 text-sm font-medium text-neu-muted">
                            Arahkan kamera ke QR Code pelanggan.
                        </p>
                    </div>

                    <!-- Area Kamera (Inset Container) -->
                    <div class="mx-auto w-full max-w-lg rounded-[24px] bg-neu-base shadow-neu-inset p-3">
                        <div id="qr-reader"
                             class="w-full overflow-hidden rounded-[18px] min-h-[260px] flex items-center justify-center bg-neu-base">
                        </div>
                    </div>

                    <!-- Pesan Status Scanner -->
                    <div id="scanner-message"
                         class="mt-6 rounded-[18px] bg-neu-base shadow-neu-inset p-4 text-center text-sm font-bold text-neu-muted">
                        Scanner belum dimulai.
                    </div>

                    <!-- Tombol Kontrol Scanner -->
                    <div class="mt-6 flex flex-wrap justify-center gap-4">
                        <button type="button"
                                id="start-scanner"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-primary px-7 py-3.5 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark disabled:cursor-not-allowed disabled:opacity-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mulai Scanner
                        </button>

                        <button type="button"
                                id="stop-scanner"
                                disabled
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-7 py-3.5 text-sm font-extrabold text-neu-dark transition-all duration-300 hover:shadow-neu-pressed hover:text-red-500 disabled:cursor-not-allowed disabled:opacity-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                            </svg>
                            Hentikan Scanner
                        </button>
                    </div>

                    <!-- PEMISAH -->
                    <div class="my-10 flex items-center gap-4">
                        <div class="h-px flex-1 bg-neu-muted/20"></div>
                        <span class="rounded-full bg-neu-base shadow-neu-inset px-4 py-1 text-xs font-extrabold tracking-widest text-neu-muted">
                            ATAU
                        </span>
                        <div class="h-px flex-1 bg-neu-muted/20"></div>
                    </div>

                    <!-- CHECK-IN MANUAL -->
                    <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-6 sm:p-8">
                        <h2 class="text-xl font-extrabold text-neu-dark">
                            Check-in Manual
                        </h2>

                        <p class="mt-1.5 text-sm font-medium text-neu-muted">
                            Masukkan kode booking pelanggan jika kamera tidak dapat digunakan.
                        </p>

                        <form action="{{ route('owner.bookings.checkin.store') }}"
                              method="POST"
                              class="mt-6 space-y-5"
                              id="manual-checkin-form">

                            @csrf

                            <div>
                                <label for="manual-token"
                                       class="mb-2 block text-sm font-bold text-neu-dark ml-1">
                                    Kode Booking
                                </label>

                                <input type="text"
                                       name="token"
                                       id="manual-token"
                                       required
                                       maxlength="255"
                                       autocomplete="off"
                                       placeholder="Contoh: SPX-VO0XQELLKYBD"
                                       class="w-full rounded-[16px] border-none bg-neu-base shadow-neu-inset px-5 py-4 text-sm font-extrabold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none">
                            </div>

                            <button type="submit"
                                    class="w-full rounded-full bg-green-600 px-6 py-4 text-sm font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:bg-green-700 active:shadow-neu-pressed">
                                ✓ Proses Check-in Manual
                            </button>
                        </form>
                    </div>

                    <!-- FORM HIDDEN UNTUK HASIL SCANNER -->
                    <form id="checkin-form"
                          action="{{ route('owner.bookings.checkin.store') }}"
                          method="POST"
                          class="hidden">

                        @csrf

                        <input type="hidden"
                               name="token"
                               id="checkin-token">
                    </form>

                </div>

            </div>
        </main>
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
                    ? 'mt-6 rounded-[18px] bg-neu-base shadow-neu-inset border border-red-500/30 p-4 text-center text-sm font-extrabold text-red-500'
                    : 'mt-6 rounded-[18px] bg-neu-base shadow-neu-inset p-4 text-center text-sm font-bold text-neu-muted';
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

</body>
</html>