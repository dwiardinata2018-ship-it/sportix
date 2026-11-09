
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - Sportix</title>
</head>
<body>

    <h1>Dashboard Owner Sportix</h1>

    <p>
        Selamat datang, {{ Auth::user()->name }}!
    </p>

    <!-- Tombol Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

    <hr>

    <h2>Ringkasan Venue</h2>

    <p>Total Venue: {{ $totalVenues }}</p>
    <p>Venue Aktif: {{ $activeVenues }}</p>
    <p>Menunggu Verifikasi: {{ $pendingVenues }}</p>
    <p>Ditolak: {{ $rejectedVenues }}</p>

    <hr>

    <h2>Daftar Venue Saya</h2>

    @forelse ($venues as $venue)
        <div>
            <h3>{{ $venue->name }}</h3>

            <p>Olahraga: {{ $venue->sport->name ?? '-' }}</p>

            <p>Status Venue: {{ $venue->venue_status }}</p>

            <p>Status Verifikasi: {{ $venue->verification_status }}</p>
        </div>

        <hr>
    @empty
        <p>Anda belum memiliki venue.</p>
    @endforelse

</body>
</html>
