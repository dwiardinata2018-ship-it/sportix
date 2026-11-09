<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Venue - Sportix</title>
</head>
<body>

    <h1>Daftarkan Venue Baru</h1>
    <p>Lengkapi informasi venue olahraga Anda.</p>

    <hr>

    <form method="POST" action="{{ route('owner.venues.store') }}" enctype="multipart/form-data">
        @csrf
                <label>Pilih Foto Venue</label><br>

        <input
            type="file"
            name="images[]"
            accept="image/jpeg,image/png,image/webp"
            multiple
        >

        @error('images')
            <p>{{ $message }}</p>
        @enderror

        @error('images.*')
            <p>{{ $message }}</p>
        @enderror
        
        <h2>Informasi Venue</h2>

        <label>Nama Venue</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Kategori Olahraga</label><br>
        <select name="sport_id" required>
            <option value="">Pilih Olahraga</option>
            @foreach ($sports as $sport)
                <option value="{{ $sport->id }}"
                    {{ old('sport_id') == $sport->id ? 'selected' : '' }}>
                    {{ $sport->name }}
                </option>
            @endforeach
        </select>
        @error('sport_id')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Deskripsi Venue</label><br>
        <textarea name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Tipe Venue</label><br>
        <select name="venue_type" required>
            <option value="indoor" {{ old('venue_type') == 'indoor' ? 'selected' : '' }}>Indoor</option>
            <option value="outdoor" {{ old('venue_type') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
            <option value="mixed" {{ old('venue_type') == 'mixed' ? 'selected' : '' }}>Mixed</option>
        </select>

        <hr>

        <h2>Alamat Venue</h2>

        <label>Alamat Lengkap</label><br>
        <textarea name="address" rows="3" required>{{ old('address') }}</textarea>
        @error('address')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Desa / Kelurahan</label><br>
        <input type="text" name="village" value="{{ old('village') }}">

        <br><br>

        <label>Kecamatan</label><br>
        <input type="text" name="district" value="{{ old('district') }}">

        <br><br>

        <label>Kota / Kabupaten</label><br>
        <input type="text" name="city" value="{{ old('city') }}" required>

        <br><br>

        <label>Provinsi</label><br>
        <input type="text" name="province" value="{{ old('province') }}" required>

        <br><br>

        <label>Kode Pos</label><br>
        <input type="text" name="postal_code" value="{{ old('postal_code') }}">

        <hr>

        <h2>Informasi Kontak</h2>

        <label>Nomor WhatsApp</label><br>
        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}">

        <br><br>

        <label>Link Instagram</label><br>
        <input type="url" name="instagram_url" value="{{ old('instagram_url') }}">

        <hr>

        <h2>Koordinat Lokasi (Opsional)</h2>

        <label>Latitude</label><br>
        <input type="number" step="any" name="latitude" value="{{ old('latitude') }}">

        <br><br>

        <label>Longitude</label><br>
        <input type="number" step="any" name="longitude" value="{{ old('longitude') }}">
        <hr>

        <h2>Foto Venue</h2>

        <p>Unggah foto venue untuk ditampilkan kepada pengguna Sportix.</p>

        <hr>

        <button type="submit">Daftarkan Venue</button>

        <a href="{{ route('owner.venues.index') }}">Batal</a>

    </form>

</body>
</html>