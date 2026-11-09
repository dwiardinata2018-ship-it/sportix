
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna - SPORTIX</title>

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

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 25px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header h1 {
            font-size: 25px;
            margin-bottom: 7px;
        }

        .header p {
            color: #78847c;
            font-size: 14px;
        }

        .back-button {
            text-decoration: none;
            background: #e5eee8;
            color: #237345;
            padding: 11px 17px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 22px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 18px;
            padding-bottom: 22px;
            border-bottom: 1px solid #edf0ed;
            margin-bottom: 22px;
        }

        .avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #e0f2e7;
            color: #237345;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            font-weight: bold;
        }

        .profile h3 {
            font-size: 20px;
            margin-bottom: 6px;
        }

        .profile p {
            color: #78847c;
            font-size: 14px;
        }

        .information {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .info-item {
            padding: 5px 0;
        }

        .info-item label {
            display: block;
            font-size: 13px;
            color: #78847c;
            margin-bottom: 8px;
        }

        .info-item p {
            font-size: 15px;
            font-weight: 600;
            word-break: break-word;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .active {
            background: #dcfce7;
            color: #15803d;
        }

        .inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .button {
            border: none;
            padding: 11px 17px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .button-status {
            background: #237345;
            color: white;
        }

        .button-back {
            background: #edf0ed;
            color: #34443a;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .information {
                grid-template-columns: 1fr;
            }

            .container {
                margin-top: 20px;
                padding: 0 15px;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Detail Pengguna</h1>
            <p>Informasi lengkap akun pengguna Sportix.</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="back-button">
            ← Kembali
        </a>
    </div>

    <div class="card">

        <div class="profile">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h3>{{ $user->name }}</h3>
                <p>Pengguna Sportix</p>
            </div>
        </div>

        <h2>Informasi Akun</h2>

        <div class="information">

            <div class="info-item">
                <label>ID Pengguna</label>
                <p>#{{ $user->id }}</p>
            </div>

            <div class="info-item">
                <label>Nama Lengkap</label>
                <p>{{ $user->name }}</p>
            </div>

            <div class="info-item">
                <label>Email</label>
                <p>{{ $user->email }}</p>
            </div>

            <div class="info-item">
                <label>Nomor Telepon</label>
                <p>{{ $user->phone ?: '-' }}</p>
            </div>

            <div class="info-item">
                <label>Role</label>
                <p>Pengguna</p>
            </div>

            <div class="info-item">
                <label>Status Akun</label>
                <p>
                    @if ($user->account_status === 'active')
                        <span class="status active">Aktif</span>
                    @else
                        <span class="status inactive">Nonaktif</span>
                    @endif
                </p>
            </div>

            <div class="info-item">
                <label>Email Terverifikasi</label>
                <p>
                    {{ $user->email_verified_at ? $user->email_verified_at->format('d-m-Y H:i') : 'Belum diverifikasi' }}
                </p>
            </div>

            <div class="info-item">
                <label>Terakhir Login</label>
                <p>
                    {{ $user->last_login_at ? $user->last_login_at->format('d-m-Y H:i') : 'Belum pernah login' }}
                </p>
            </div>

            <div class="info-item">
                <label>Tanggal Registrasi</label>
                <p>
                    {{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}
                </p>
            </div>

            <div class="info-item">
                <label>Terakhir Diperbarui</label>
                <p>
                    {{ $user->updated_at ? $user->updated_at->format('d-m-Y H:i') : '-' }}
                </p>
            </div>

        </div>

        <div class="actions">

            <form action="{{ route('admin.users.updateStatus', $user->id) }}"
                  method="POST"
                  onsubmit="return confirm('Apakah kamu yakin ingin mengubah status akun pengguna ini?')">

                @csrf
                @method('PATCH')

                <button type="submit" class="button button-status">
                    {{ $user->account_status === 'active' ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                </button>

            </form>

            <a href="{{ route('admin.users.index') }}" class="button button-back">
                Kembali ke Daftar
            </a>

        </div>

    </div>

</div>

</body>
</html>
