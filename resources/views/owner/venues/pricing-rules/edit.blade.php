
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Aturan Harga - Sportix</title>
</head>
<body>

    <h1>Edit Aturan Harga</h1>

    <h2>{{ $venue->name }}</h2>

    <a href="{{ route('owner.venues.pricing-rules.index', $venue->id) }}">
        Kembali ke Daftar Harga
    </a>

    <hr>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('owner.venues.pricing-rules.update', [$venue->id, $pricingRule->id]) }}">

        @csrf
        @method('PUT')

        <p>
            <label>Nama Aturan Harga</label><br>
            <input type="text"
                   name="name"
                   value="{{ old('name', $pricingRule->name) }}"
                   maxlength="120"
                   required>
        </p>

        <p>
            <label>Unit Lapangan</label><br>
            <select name="unit_id">
                <option value="">Semua Unit</option>

                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('unit_id', $pricingRule->unit_id) == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Hari Berlaku</label><br>
            <select name="weekday">
                <option value="">Semua Hari</option>

                @foreach ([
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jumat',
                    6 => 'Sabtu',
                    7 => 'Minggu'
                ] as $number => $day)

                    <option value="{{ $number }}"
                        {{ (string) old('weekday', $pricingRule->weekday) === (string) $number ? 'selected' : '' }}>
                        {{ $day }}
                    </option>

                @endforeach
            </select>
        </p>

        <p>
            <label>Jam Mulai</label><br>
            <input type="time"
                   name="start_time"
                   value="{{ old('start_time', substr($pricingRule->start_time, 0, 5)) }}"
                   required>
        </p>

        <p>
            <label>Jam Selesai</label><br>
            <input type="time"
                   name="end_time"
                   value="{{ old('end_time', substr($pricingRule->end_time, 0, 5)) }}"
                   required>
        </p>

        <p>
            <label>Harga per Jam (Rp)</label><br>
            <input type="number"
                   name="price_per_hour"
                   value="{{ old('price_per_hour', $pricingRule->price_per_hour) }}"
                   min="0"
                   step="1000"
                   required>
        </p>

        <p>
            <label>Berlaku Mulai (Opsional)</label><br>
            <input type="date"
                   name="effective_from"
                   value="{{ old('effective_from', optional($pricingRule->effective_from)->format('Y-m-d')) }}">
        </p>

        <p>
            <label>Berlaku Sampai (Opsional)</label><br>
            <input type="date"
                   name="effective_until"
                   value="{{ old('effective_until', optional($pricingRule->effective_until)->format('Y-m-d')) }}">
        </p>

        <p>
            <label>Status Aturan Harga</label><br>
            <select name="is_active" required>
                <option value="1"
                    {{ (string) old('is_active', (int) $pricingRule->is_active) === '1' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="0"
                    {{ (string) old('is_active', (int) $pricingRule->is_active) === '0' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </p>

        <button type="submit">Simpan Perubahan</button>

    </form>

</body>
</html>
