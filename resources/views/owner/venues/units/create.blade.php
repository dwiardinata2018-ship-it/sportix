<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Unit Venue - Sportix</title>
</head>
<body>

    <h1>Tambah Unit Venue</h1>

    <p>
        <a href="{{ route('owner.venues.units.index', $venue->id) }}">
            &larr; Kembali ke Daftar Unit
        </a>
    </p>

    <hr>

    <h2>{{ $venue->name }}</h2>
    <p>Tambahkan lapangan atau unit olahraga baru untuk venue ini.</p>

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
        action="{{ route('owner.venues.units.store', $venue->id) }}">

        @csrf

        <div>
            <label for="name">Nama Unit</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: Lapangan Badminton 3"
                required
            >
        </div>

        <br>

        <div>
            <label for="unit_type">Jenis Unit</label><br>
            <select id="unit_type" name="unit_type" required>
                <option value="court">Lapangan (Court)</option>
                <option value="room">Ruangan (Room)</option>
                <option value="pool">Kolam (Pool)</option>
                <option value="field">Lapangan Besar (Field)</option>
                <option value="other">Lainnya (Other)</option>
            </select>
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label><br>
            <textarea
                id="description"
                name="description"
                placeholder="Contoh: Lapangan badminton indoor."
            >{{ old('description') }}</textarea>
        </div>

        <br>

        <div>
            <label for="capacity">Kapasitas (orang)</label><br>
            <input
                type="number"
                id="capacity"
                name="capacity"
                value="{{ old('capacity') }}"
                min="1"
                placeholder="Contoh: 4"
            >
        </div>

        <br>

        <div>
            <label for="default_price">Harga Default per Jam (Rp)</label><br>
            <input
                type="number"
                id="default_price"
                name="default_price"
                value="{{ old('default_price') }}"
                min="0"
                placeholder="Contoh: 50000"
                required
            >
        </div>

        <br>

        <div>
            <label for="is_active">Status Unit</label><br>
            <select id="is_active" name="is_active" required>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <br>

        <button type="submit">Simpan Unit</button>

    </form>

</body>
</html>