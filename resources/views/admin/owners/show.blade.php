
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Owner - SPORTIX</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7f5;
            color: #26352c;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #176b3a;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 18px;
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 35px;
            padding-left: 10px;
        }

        .menu-title {
            font-size: 11px;
            color: #b9ddc6;
            margin: 20px 10px 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: block;
            color: #e4f1e8;
            text-decoration: none;
            padding: 12px 13px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: white;
            color: #176b3a;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .topbar h2 {
            font-size: 22px;
        }

        .admin-info {
            font-size: 13px;
            color: #68776d;
        }

        .back-button {
            display: inline-block;
            text-decoration: none;
            color: #176b3a;
            background: #e5eee8;
            padding: 10px 15px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .status-button {
        border: none;
        padding: 11px 17px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }

    .status-button.deactivate {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-button.activate {
        background: #dcfce7;
        color: #15803d;
    }

    .status-button:hover {
        opacity: 0.85;
    }

    .success-message {
        background: #dcfce7;
        color: #166534;
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

        .content-card {
            background: white;
            padding: 23px;
            border-radius: 11px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.03);
            margin-bottom: 22px;
        }

        .content-card h3 {
            font-size: 17px;
            margin-bottom: 20px;
            color: #26352c;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .info-item p:first-child {
            color: #78847c;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .info-item p:last-child {
            font-size: 14px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .active, .verified {
            background: #dcfce7;
            color: #15803d;
        }

        .inactive, .rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .unverified {
            background: #e5e7eb;
            color: #4b5563;
        }

        .verification-button {
            border: none;
            padding: 11px 17px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .verification-button.approve {
            background: #dcfce7;
            color: #15803d;
        }

        .verification-button.reject {
            background: #fee2e2;
            color: #b91c1c;
        }

        .verification-button:hover {
            opacity: 0.85;
        }

        .verification-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .reject-form {
            margin-top: 20px;
        }

        .reject-form textarea {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
            resize: vertical;
            margin-top: 8px;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .empty {
            color: #78847c;
            font-size: 14px;
            background: #f8faf8;
            padding: 18px;
            border-radius: 8px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #edf0ed;
            font-size: 13px;
        }

        th {
            background: #f8faf8;
            color: #68776d;
        }

        td {
            color: #435047;
        }

        @media (max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 20px 15px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="brand">SPORTIX.</div>

        <div class="menu-title">Main Menu</div>

        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.users.index') }}">Kelola Pengguna</a>
        <a href="{{ route('admin.owners.index') }}" class="active">Kelola Owner</a>
        <a href="#">Kelola Lapangan</a>
        <a href="#">Monitoring Booking</a>
        <a href="#">Ulasan</a>

        <div class="menu-title">System</div>

        <a href="#">Log Aktivitas</a>
        <a href="#">Pengaturan</a>
    </aside>

    <main class="main">

        <div class="topbar">
            <h2>Detail Owner</h2>

            <div class="admin-info">
                Administrator Sportix · Administrator
            </div>
        </div>

        <a href="{{ route('admin.owners.index') }}" class="back-button">
            ← Kembali ke Daftar Owner
        </a>

        {{-- Informasi Akun Owner --}}
        <section class="content-card">

            <h3>Informasi Akun</h3>

            <div class="info-grid">

                <div class="info-item">
                    <p>ID Owner</p>
                    <p>{{ $owner->id }}</p>
                </div>

                <div class="info-item">
                    <p>Nama Owner</p>
                    <p>{{ $owner->name }}</p>
                </div>

                <div class="info-item">
                    <p>Email</p>
                    <p>{{ $owner->email }}</p>
                </div>

                <div class="info-item">
                    <p>Nomor Telepon</p>
                    <p>{{ $owner->phone ?: '-' }}</p>
                </div>

                <div class="info-item">
                    <p>Status Akun</p>
                    <p>
                        @if ($owner->account_status === 'active')
                            <span class="badge active">Aktif</span>
                        @else
                            <span class="badge inactive">Nonaktif</span>
                        @endif
                    </p>
                </div>

                <div class="info-item">
                    <p>Email Terverifikasi</p>
                    <p>
                        {{ $owner->email_verified_at ? 'Sudah' : 'Belum' }}
                    </p>
                </div>

                <div class="info-item">
                    <p>Terakhir Login</p>
                    <p>
                        {{ $owner->last_login_at
                            ? $owner->last_login_at->format('d-m-Y H:i')
                            : 'Belum tersedia' }}
                    </p>
                </div>

                <div class="info-item">
                    <p>Tanggal Bergabung</p>
                    <p>
                        {{ $owner->created_at
                            ? $owner->created_at->format('d-m-Y H:i')
                            : '-' }}
                    </p>
                </div>

            </div>

            {{-- Pesan keberhasilan --}}
            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tombol Aktifkan / Nonaktifkan Owner --}}
            <form
                action="{{ route('admin.owners.updateStatus', $owner->id) }}"
                method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin mengubah status akun Owner ini?')"
            >
                @csrf
                @method('PATCH')

                @if ($owner->account_status === 'active')
                    <button type="submit" class="status-button deactivate">
                        Nonaktifkan Akun Owner
                    </button>
                @else
                    <button type="submit" class="status-button activate">
                        Aktifkan Akun Owner
                    </button>
                @endif
            </form>

        </section>

        
{{-- Informasi Profil Usaha --}}
<section class="content-card">

    <h3>Informasi Profil Usaha</h3>

    {{-- Pesan keberhasilan --}}
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan kesalahan --}}
    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-message">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($owner->ownerProfile)

        <div class="info-grid">

            <div class="info-item">
                <p>Nama Usaha</p>
                <p>{{ $owner->ownerProfile->business_name ?: '-' }}</p>
            </div>

            <div class="info-item">
                <p>Nomor Identitas</p>
                <p>{{ $owner->ownerProfile->identity_number ?: '-' }}</p>
            </div>

            <div class="info-item">
                <p>Status Verifikasi</p>
                <p>
                    @php
                        $verificationStatus = $owner->ownerProfile->verification_status;
                    @endphp

                    <span class="badge {{ $verificationStatus === 'verified' ? 'verified' : ($verificationStatus === 'pending' ? 'pending' : ($verificationStatus === 'rejected' ? 'rejected' : 'unverified')) }}">
                        {{ ucfirst($verificationStatus ?? 'Belum diketahui') }}
                    </span>
                </p>
            </div>

            <div class="info-item">
                <p>Diverifikasi Oleh</p>
                <p>{{ $owner->ownerProfile->verifier?->name ?: '-' }}</p>
            </div>

            <div class="info-item">
                <p>Tanggal Verifikasi</p>
                <p>
                    {{ $owner->ownerProfile->verified_at
                        ? $owner->ownerProfile->verified_at->format('d-m-Y H:i')
                        : '-' }}
                </p>
            </div>

            <div class="info-item">
                <p>Dokumen Identitas</p>
                <p>
                    @if ($owner->ownerProfile->identity_document_path)
                        <a href="{{ route('admin.owners.document', $owner->id) }}"
                           target="_blank"
                           style="color: #15803d; font-weight: bold; text-decoration: none;">
                            Lihat Dokumen Identitas
                        </a>
                    @else
                        Belum ada dokumen
                    @endif
                </p>
            </div>

            <div class="info-item" style="grid-column: 1 / -1;">
                <p>Catatan Verifikasi</p>
                <p>{{ $owner->ownerProfile->verification_notes ?: '-' }}</p>
            </div>

        </div>

        {{-- Tombol verifikasi hanya untuk profil pending --}}
        @if ($verificationStatus === 'pending')

            <div class="verification-actions">

                <form action="{{ route('admin.owners.verify', $owner->id) }}"
                      method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menyetujui verifikasi Owner ini?')">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="verification-button approve">
                        Setujui Verifikasi
                    </button>
                </form>

            </div>

            <form action="{{ route('admin.owners.reject', $owner->id) }}"
                  method="POST"
                  class="reject-form">
                @csrf
                @method('PATCH')

                <label for="verification_notes">Alasan Penolakan</label>

                <textarea id="verification_notes"
                          name="verification_notes"
                          maxlength="2000"
                          placeholder="Tuliskan alasan penolakan..."
                          required>{{ old('verification_notes') }}</textarea>

                <button type="submit"
                        class="verification-button reject"
                        style="margin-top: 10px;"
                        onclick="return confirm('Apakah Anda yakin ingin menolak verifikasi Owner ini?')">
                    Tolak Verifikasi
                </button>
            </form>

        @elseif ($verificationStatus === 'verified')

            <p style="margin-top: 20px; color: #15803d; font-size: 13px;">
                Profil ini sudah diverifikasi oleh Admin.
            </p>

        @elseif ($verificationStatus === 'rejected')

            <p style="margin-top: 20px; color: #b91c1c; font-size: 13px;">
                Profil ini pernah ditolak. Owner perlu memperbaiki data dan mengirimkannya kembali.
            </p>

        @endif

    @else

        <div class="empty">
            Owner ini belum melengkapi profil usaha dan dokumen identitas.
        </div>

    @endif

</section>

        {{-- Daftar Lapangan --}}
        <section class="content-card">

            <h3>Daftar Lapangan Milik Owner</h3>

            @if ($owner->venues->count() > 0)

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Lapangan</th>
                                <th>Jenis Olahraga</th>
                                <th>Lokasi</th>
                                <th>Verifikasi</th>
                                <th>Status Lapangan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($owner->venues as $venue)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $venue->name }}</td>

                                    <td>
                                        {{ $venue->sport?->name ?: '-' }}
                                    </td>

                                    <td>
                                        {{ $venue->city ?: $venue->address ?: '-' }}
                                    </td>

                                    <td>
                                        @if ($venue->verification_status === 'verified')
                                            <span class="badge verified">
                                                Terverifikasi
                                            </span>
                                        @elseif ($venue->verification_status === 'pending')
                                            <span class="badge pending">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="badge unverified">
                                                {{ ucfirst($venue->verification_status ?? 'Belum diketahui') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($venue->venue_status === 'active')
                                            <span class="badge active">Aktif</span>
                                        @else
                                            <span class="badge inactive">
                                                {{ ucfirst($venue->venue_status ?? 'Tidak diketahui') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty">
                    Owner ini belum memiliki lapangan yang terdaftar.
                </div>

            @endif

        </section>

    </main>

</body>
</html>
