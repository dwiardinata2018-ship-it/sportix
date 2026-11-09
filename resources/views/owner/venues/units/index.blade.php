
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Venue - Sportix</title>
</head>
<body>

    <h1>Unit Venue</h1>

    <p>
        <a href="{{ route('owner.venues.show', $venue->id) }}">
            &larr; Kembali ke Detail Venue
        </a>
    </p>

    <hr>

    <h2>{{ $venue->name }}</h2>

    <p>Daftar lapangan atau unit yang tersedia di venue ini.</p>

    <hr>
    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif
    <h3>Daftar Unit</h3>

    @forelse ($units as $unit)

        <div>
            <h4>{{ $unit->name }}</h4>

            <p>Jenis Unit: {{ $unit->unit_type }}</p>

            <p>
                Kapasitas:
                {{ $unit->capacity ?? '-' }} orang
            </p>

            <p>
                Harga Default:
                Rp{{ number_format($unit->default_price, 0, ',', '.') }}/jam
            </p>

            <p>
                Status:
                {{ $unit->is_active ? 'Aktif' : 'Nonaktif' }}
            </p>

            <p>
                <a href="{{ route('owner.venues.units.edit', [$venue->id, $unit->id]) }}">
                    <button type="button">Edit Unit</button>
                </a>
            </p>

            <form method="POST"
                action="{{ route('owner.venues.units.toggle-status', [$venue->id, $unit->id]) }}">

                @csrf
                @method('PATCH')

                <button type="submit">
                    {{ $unit->is_active ? 'Nonaktifkan Unit' : 'Aktifkan Unit' }}
                </button>

            </form>
        </div>

        <hr>
    @empty

        <p>Venue ini belum memiliki unit.</p>

    @endforelse

</body>
</html>
