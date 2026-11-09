
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Owner - Sportix</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7f5;
            color: #1f2937;
        }

        .container {
            max-width: 850px;
            margin: 40px auto;
            padding: 20px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .header p {
            color: #6b7280;
            font-size: 14px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #15803d;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
        }

        .help {
            color: #6b7280;
            font-size: 12px;
            margin-top: 6px;
        }

        .submit-button {
            background: #15803d;
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 7px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #166534;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .verified {
            background: #dcfce7;
            color: #166534;
        }

        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .notes {
            margin-top: 15px;
            padding: 14px;
            background: #fff7ed;
            border-left: 4px solid #f97316;
            border-radius: 6px;
            font-size: 14px;
        }

        .current-file {
            margin-top: 10px;
            font-size: 13px;
            color: #4b5563;
        }

        @media (max-width: 600px) {
            .container {
                margin: 15px auto;
                padding: 15px;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('owner.dashboard') }}" class="back-button">
        ← Kembali ke Dashboard
    </a>

    <div class="header">
        <h1>Profil Owner</h1>
        <p>Lengkapi identitas dan informasi usaha untuk proses verifikasi Sportix.</p>
    </div>

    {{-- Pesan berhasil --}}
    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan kesalahan validasi --}}
    @if ($errors->any())
        <div class="alert error">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Status verifikasi --}}
    <div class="card">
        <h2>Status Verifikasi Profil</h2>

        @if ($profile)
            <span class="status {{ $profile->verification_status }}">
                {{ ucfirst($profile->verification_status) }}
            </span>

            @if ($profile->verification_status === 'rejected' && $profile->verification_notes)
                <div class="notes">
                    <strong>Catatan dari Admin:</strong>
                    <p style="margin-top: 7px;">
                        {{ $profile->verification_notes }}
                    </p>
                </div>
            @elseif ($profile->verification_status === 'pending')
                <p style="margin-top: 12px; color: #6b7280; font-size: 14px;">
                    Profil sedang menunggu pemeriksaan Admin.
                </p>
            @elseif ($profile->verification_status === 'verified')
                <p style="margin-top: 12px; color: #15803d; font-size: 14px;">
                    Profil usaha Anda telah berhasil diverifikasi.
                </p>
            @endif
        @else
            <p style="color: #6b7280; font-size: 14px;">
                Anda belum mengirimkan profil untuk diverifikasi.
            </p>
        @endif
    </div>

    {{-- Form profil --}}
    <div class="card">
        <h2>Informasi Usaha dan Identitas</h2>

        <form
            action="{{ route('owner.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="business_name">Nama Usaha / Nama Tempat Olahraga</label>
                <input
                    type="text"
                    id="business_name"
                    name="business_name"
                    value="{{ old('business_name', $profile?->business_name) }}"
                    maxlength="150"
                    placeholder="Contoh: Sportix Badminton Center"
                    required
                >
            </div>

            <div class="form-group">
                <label for="identity_number">Nomor Identitas (NIK)</label>
                <input
                    type="text"
                    id="identity_number"
                    name="identity_number"
                    value="{{ old('identity_number', $profile?->identity_number) }}"
                    maxlength="50"
                    placeholder="Masukkan nomor identitas"
                    required
                >
            </div>

            <div class="form-group">
                <label for="identity_document">Dokumen Identitas</label>

                <input
                    type="file"
                    id="identity_document"
                    name="identity_document"
                    accept=".jpg,.jpeg,.png,.pdf"
                    {{ $profile?->identity_document_path ? '' : 'required' }}
                >

                <p class="help">
                    Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                </p>

                @if ($profile?->identity_document_path)
                    <p class="current-file">
                        Dokumen saat ini:
                        {{ basename($profile->identity_document_path) }}
                    </p>
                    <p class="help">
                        Kosongkan jika tidak ingin mengganti dokumen.
                    </p>
                @endif
            </div>

            <button type="submit" class="submit-button">
                Simpan dan Kirim Verifikasi
            </button>

        </form>
    </div>

</div>

</body>
</html>
