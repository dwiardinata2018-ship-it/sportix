
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aturan Harga - Sportix</title>
</head>
<body>

    <h1>Tambah Aturan Harga</h1>

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
          action="{{ route('owner.venues.pricing-rules.store', $venue->id) }}">

        @csrf

        <p>
            <label>Nama Aturan Harga</label><br>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   maxlength="120"
                   required
                   placeholder="Contoh: Harga Weekend">
        </p>

        <p>
            <label>Unit Lapangan</label><br>
            <select name="unit_id">
                <option value="">Semua Unit</option>

                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Hari Berlaku</label><br>
            <select name="weekday">
                <option value="">Semua Hari</option>
                <option value="1" {{ old('weekday') == '1' ? 'selected' : '' }}>Senin</option>
                <option value="2" {{ old('weekday') == '2' ? 'selected' : '' }}>Selasa</option>
                <option value="3" {{ old('weekday') == '3' ? 'selected' : '' }}>Rabu</option>
                <option value="4" {{ old('weekday') == '4' ? 'selected' : '' }}>Kamis</option>
                <option value="5" {{ old('weekday') == '5' ? 'selected' : '' }}>Jumat</option>
                <option value="6" {{ old('weekday') == '6' ? 'selected' : '' }}>Sabtu</option>
                <option value="7" {{ old('weekday') == '7' ? 'selected' : '' }}>Minggu</option>
            </select>
        </p>

        <p>
            <label>Jam Mulai</label><br>
            <input type="time"
                   name="start_time"
                   value="{{ old('start_time', '08:00') }}"
                   required>
        </p>

        <p>
            <label>Jam Selesai</label><br>
            <input type="time"
                   name="end_time"
                   value="{{ old('end_time', '22:00') }}"
                   required>
        </p>

        <p>
            <label>Harga per Jam (Rp)</label><br>
            <input type="number"
                   name="price_per_hour"
                   value="{{ old('price_per_hour') }}"
                   min="0"
                   step="1000"
                   required
                   placeholder="Contoh: 70000">
        </p>

        <p>
            <label>Berlaku Mulai (Opsional)</label><br>
            <input type="date"
                   name="effective_from"
                   value="{{ old('effective_from') }}">
        </p>

        <p>
            <label>Berlaku Sampai (Opsional)</label><br>
            <input type="date"
                   name="effective_until"
                   value="{{ old('effective_until') }}">
        </p>

        <p>
            <label>Status Aturan Harga</label><br>
            <select name="is_active" required>
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </p>

        <button type="submit">Simpan Aturan Harga</button>

    </form>

</body>
</html>
