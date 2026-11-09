<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Unit Venue - Sportix</title>
</head>
<body>

    <h1>Edit Unit Venue</h1>

    <p>
        <a href="{{ route('owner.venues.units.index', $venue->id) }}">
            &larr; Kembali ke Daftar Unit
        </a>
    </p>

    <hr>

    <h2>{{ $venue->name }}</h2>
    <p>Perbarui informasi unit olahraga milik venue ini.</p>

    <hr>

    @if ($errors->any())
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('owner.venues.units.update', [$venue->id, $unit->id]) }}">

        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Unit</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $unit->name) }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="unit_type">Jenis Unit</label><br>
            <select id="unit_type" name="unit_type" required>
                <option value="court" {{ old('unit_type', $unit->unit_type) == 'court' ? 'selected' : '' }}>Lapangan (Court)</option>
                <option value="room" {{ old('unit_type', $unit->unit_type) == 'room' ? 'selected' : '' }}>Ruangan (Room)</option>
                <option value="pool" {{ old('unit_type', $unit->unit_type) == 'pool' ? 'selected' : '' }}>Kolam (Pool)</option>
                <option value="field" {{ old('unit_type', $unit->unit_type) == 'field' ? 'selected' : '' }}>Lapangan Besar (Field)</option>
                <option value="other" {{ old('unit_type', $unit->unit_type) == 'other' ? 'selected' : '' }}>Lainnya (Other)</option>
            </select>
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label><br>
            <textarea
                id="description"
                name="description"
            >{{ old('description', $unit->description) }}</textarea>
        </div>

        <br>

        <div>
            <label for="capacity">Kapasitas (orang)</label><br>
            <input
                type="number"
                id="capacity"
                name="capacity"
                value="{{ old('capacity', $unit->capacity) }}"
                min="1"
            >
        </div>

        <br>

        <div>
            <label for="default_price">Harga Default per Jam (Rp)</label><br>
            <input
                type="number"
                id="default_price"
                name="default_price"
                value="{{ old('default_price', $unit->default_price) }}"
                min="0"
                required
            >
        </div>

        <br>

        <div>
            <label for="is_active">Status Unit</label><br>
            <select id="is_active" name="is_active" required>
                <option value="1" {{ old('is_active', $unit->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $unit->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <br>

        <button type="submit">Simpan Perubahan</button>

    </form>

</body>
</html>