
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Venue - Sportix</title>
</head>
<body>

    <h1>Detail Venue</h1>
    <p>
        <a href="{{ route('owner.venues.edit', $venue->id) }}">
            <button type="button">Edit Venue</button>
        </a>
    </p>

    <p>
        <a href="{{ route('owner.venues.index') }}">
            &larr; Kembali ke Venue Saya
        </a>
    </p>

    <hr>

    <h2>{{ $venue->name }}</h2>

    <p>
        <strong>Olahraga:</strong>
        {{ $venue->sport->name ?? '-' }}
    </p>

    <p>
        <strong>Jenis Venue:</strong>
        {{ ucfirst($venue->venue_type) }}
    </p>

    <p>
        <strong>Deskripsi:</strong>
        {{ $venue->description ?? 'Belum ada deskripsi.' }}
    </p>

    <hr>

    <h3>Galeri Foto</h3>

    @forelse ($venue->images as $image)
        <div>
            <img
                src="{{ asset('storage/' . $image->image_path) }}"
                alt="{{ $image->caption ?? $venue->name }}"
                width="250"
                style="height: 180px; object-fit: cover;"
            >

            @if ($image->is_primary)
                <p>Foto Utama</p>
            @endif
        </div>
    @empty
        <p>Belum ada foto venue.</p>
    @endforelse

    <hr>

    <h3>Informasi Lokasi</h3>

    <p>
        <strong>Alamat:</strong>
        {{ $venue->address }}
    </p>

    <p>
        <strong>Kelurahan/Desa:</strong>
        {{ $venue->village ?? '-' }}
    </p>

    <p>
        <strong>Kecamatan:</strong>
        {{ $venue->district ?? '-' }}
    </p>

    <p>
        <strong>Kota:</strong>
        {{ $venue->city }}
    </p>

    <p>
        <strong>Provinsi:</strong>
        {{ $venue->province }}
    </p>

    <p>
        <strong>Kode Pos:</strong>
        {{ $venue->postal_code ?? '-' }}
    </p>

    <hr>

    <h3>Informasi Kontak</h3>

    <p>
        <strong>WhatsApp:</strong>
        {{ $venue->whatsapp_number ?? '-' }}
    </p>

    <p>
        <strong>Instagram:</strong>
        {{ $venue->instagram_url ?? '-' }}
    </p>

    <hr>

    <h3>Unit Lapangan</h3>

    @forelse ($venue->units as $unit)
        <div>
            <p><strong>{{ $unit->name }}</strong></p>
            <p>Jenis Unit: {{ $unit->unit_type }}</p>
            <p>Kapasitas: {{ $unit->capacity ?? '-' }}</p>
            <p>Harga Default: Rp{{ number_format($unit->default_price, 0, ',', '.') }}</p>
            <p>Status: {{ $unit->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
        </div>
        <hr>
    @empty
        <p>Belum ada unit lapangan.</p>
    @endforelse

    <h3>Fasilitas</h3>

    @forelse ($venue->facilities as $facility)
        <p>{{ $facility->name }}</p>
    @empty
        <p>Belum ada fasilitas.</p>
    @endforelse

    <hr>

    <h3>Jam Operasional</h3>

    @php
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
    @endphp

    @forelse ($venue->operatingHours->sortBy('weekday') as $hour)
        <p>
            <strong>{{ $days[$hour->weekday] ?? 'Hari tidak diketahui' }}:</strong>

            @if ($hour->is_closed)
                Tutup
            @else
                {{ substr($hour->open_time, 0, 5) }}
                -
                {{ substr($hour->close_time, 0, 5) }}
            @endif
        </p>
    @empty
        <p>Jam operasional belum diatur.</p>
    @endforelse

    <hr>

    <h3>Aturan Harga</h3>

    @forelse ($venue->pricingRules as $rule)
        <div>
            <p><strong>{{ $rule->name }}</strong></p>
            <p>
                Harga:
                Rp{{ number_format($rule->price_per_hour, 0, ',', '.') }}/jam
            </p>
            <p>Status: {{ $rule->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
        </div>
    @empty
        <p>Belum ada aturan harga.</p>
    @endforelse

    <hr>

    <h3>Status Venue</h3>

    <p>
        Status Venue: {{ $venue->venue_status }}
    </p>

    <p>
        Status Verifikasi: {{ $venue->verification_status }}
    </p>

</body>
</html>
