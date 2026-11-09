
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Saya - Sportix</title>
</head>
<body>

    <h1>Venue Saya</h1>

    <p>Berikut daftar venue yang Anda miliki.</p>

    <a href="{{ route('owner.venues.create') }}">
        <button type="button">+ Tambah Venue</button>
    </a>

    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p style="color: red;">
            {{ session('error') }}
        </p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <hr>

    @forelse ($venues as $venue)
        <div>
            <h2>{{ $venue->name }}</h2>

            @php
                $primaryImage = $venue->images->first();
            @endphp

            @if ($primaryImage)
                <img
                    src="{{ asset('storage/' . $primaryImage->image_path) }}"
                    alt="Foto {{ $venue->name }}"
                    width="300"
                    style="height: 200px; object-fit: cover;"
                >
            @else
                <p>Belum ada foto venue.</p>
            @endif

            <p>
                Olahraga:
                {{ $venue->sport->name ?? '-' }}
            </p>

            <p>
                Lokasi:
                {{ $venue->city }}, {{ $venue->province }}
            </p>

            <p>
                Status Venue:
                <strong>{{ ucfirst($venue->venue_status) }}</strong>
            </p>

            <p>
                Status Verifikasi:
                <strong>{{ ucfirst($venue->verification_status) }}</strong>
            </p>

            <a href="{{ route('owner.venues.show', $venue->id) }}">
                <button type="button">Detail</button>
            </a>

            <a href="{{ route('owner.venues.edit', $venue->id) }}">
                <button type="button">Edit</button>
            </a>

            @if ($venue->verification_status === 'verified'
                && in_array($venue->venue_status, ['active', 'inactive']))

                <form
                    action="{{ route('owner.venues.status', $venue->id) }}"
                    method="POST"
                    style="display: inline;"
                >
                    @csrf
                    @method('PATCH')

                    @if ($venue->venue_status === 'active')
                        <input
                            type="hidden"
                            name="venue_status"
                            value="inactive"
                        >
                        <button type="submit">
                            Nonaktifkan Venue
                        </button>
                    @else
                        <input
                            type="hidden"
                            name="venue_status"
                            value="active"
                        >
                        <button type="submit">
                            Aktifkan Venue
                        </button>
                    @endif
                </form>

            @elseif ($venue->verification_status !== 'verified')
                <p style="color: orange;">
                    Venue belum dapat diaktifkan karena belum diverifikasi Admin.
                </p>
            @elseif ($venue->venue_status === 'suspended')
                <p style="color: red;">
                    Venue sedang ditangguhkan oleh Admin.
                </p>
            @endif

        </div>

        <hr>
    @empty
        <p>Anda belum memiliki venue.</p>
    @endforelse

    {{ $venues->links() }}

</body>
</html>
