
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Venue - Sportix</title>
</head>
<body>

    <h1>Edit Venue</h1>

    <p>
        <a href="{{ route('owner.venues.show', $venue->id) }}">
            &larr; Kembali ke Detail Venue
        </a>
    </p>

    <hr>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

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

    <!-- FORM EDIT VENUE -->
    <form method="POST"
          action="{{ route('owner.venues.update', $venue->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <h3>Informasi Venue</h3>

        <p>
            <label>Nama Venue</label><br>
            <input type="text" name="name"
                   value="{{ old('name', $venue->name) }}" required>
        </p>

        <p>
            <label>Olahraga</label><br>
            <select name="sport_id" required>
                @foreach ($sports as $sport)
                    <option value="{{ $sport->id }}"
                        {{ old('sport_id', $venue->sport_id) == $sport->id ? 'selected' : '' }}>
                        {{ $sport->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Deskripsi</label><br>
            <textarea name="description" rows="4">{{ old('description', $venue->description) }}</textarea>
        </p>

        <p>
            <label>Jenis Venue</label><br>
            <select name="venue_type" required>
                <option value="indoor" {{ old('venue_type', $venue->venue_type) == 'indoor' ? 'selected' : '' }}>Indoor</option>
                <option value="outdoor" {{ old('venue_type', $venue->venue_type) == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                <option value="mixed" {{ old('venue_type', $venue->venue_type) == 'mixed' ? 'selected' : '' }}>Mixed</option>
            </select>
        </p>

        <hr>

        <h3>Informasi Lokasi</h3>

        <p>
            <label>Alamat</label><br>
            <textarea name="address" rows="3" required>{{ old('address', $venue->address) }}</textarea>
        </p>

        <p>
            <label>Kelurahan/Desa</label><br>
            <input type="text" name="village"
                   value="{{ old('village', $venue->village) }}">
        </p>

        <p>
            <label>Kecamatan</label><br>
            <input type="text" name="district"
                   value="{{ old('district', $venue->district) }}">
        </p>

        <p>
            <label>Kota/Kabupaten</label><br>
            <input type="text" name="city"
                   value="{{ old('city', $venue->city) }}" required>
        </p>

        <p>
            <label>Provinsi</label><br>
            <input type="text" name="province"
                   value="{{ old('province', $venue->province) }}" required>
        </p>

        <p>
            <label>Kode Pos</label><br>
            <input type="text" name="postal_code"
                   value="{{ old('postal_code', $venue->postal_code) }}">
        </p>

        <p>
            <label>Latitude</label><br>
            <input type="number" step="any" name="latitude"
                   value="{{ old('latitude', $venue->latitude) }}">
        </p>

        <p>
            <label>Longitude</label><br>
            <input type="number" step="any" name="longitude"
                   value="{{ old('longitude', $venue->longitude) }}">
        </p>

        <hr>

        <h3>Informasi Kontak</h3>

        <p>
            <label>Nomor WhatsApp</label><br>
            <input type="text" name="whatsapp_number"
                   value="{{ old('whatsapp_number', $venue->whatsapp_number) }}">
        </p>

        <p>
            <label>Instagram URL</label><br>
            <input type="url" name="instagram_url"
                   value="{{ old('instagram_url', $venue->instagram_url) }}">
        </p>

        <hr>

        <h3>Tambah Foto Baru</h3>

        <p>
            <label>Tambah Foto (maksimal 5 foto)</label><br>
            <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple>
        </p>

        <p>
            <small>
                Foto baru akan ditambahkan. Foto lama tidak dihapus.
            </small>
        </p>

        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('owner.venues.show', $venue->id) }}">Batal</a>

    </form>
    <!-- BATAS FORM EDIT VENUE -->

    <hr>

    <h3>Foto Venue Saat Ini</h3>

    @forelse ($venue->images as $image)

        <div>
            <img
                src="{{ asset('storage/' . $image->image_path) }}"
                alt="Foto {{ $venue->name }}"
                width="180"
                style="height: 120px; object-fit: cover;"
            >

            @if ($image->is_primary)
                <p><strong>Foto Utama</strong></p>
            @else
                <form method="POST"
                    action="{{ route('owner.venues.images.primary', [$venue->id, $image->id]) }}">

                    @csrf
                    @method('PATCH')

                    <button type="submit">Jadikan Foto Utama</button>
                </form>
            @endif

            <!-- FORM HAPUS FOTO TERPISAH -->
            <form method="POST"
                  action="{{ route('owner.venues.images.destroy', [$venue->id, $image->id]) }}"
                  onsubmit="return confirm('Yakin ingin menghapus foto ini?')">

                @csrf
                @method('DELETE')

                <button type="submit">Hapus Foto</button>
            </form>
        </div>

        <hr>

    @empty
        <p>Belum ada foto venue.</p>
    @endforelse

</body>
</html>
