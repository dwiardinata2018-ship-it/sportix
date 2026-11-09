
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - SPORTIX</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7f5;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            background: #14532d;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            margin: 0 10px 35px;
        }

        .menu-title {
            font-size: 11px;
            color: #bbf7d0;
            margin: 25px 10px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu a {
            display: block;
            color: #dcfce7;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .menu a:hover,
        .menu a.active {
            background: #166534;
            color: white;
        }

        .content {
            flex: 1;
            padding: 30px;
            min-width: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .topbar h2 {
            font-size: 23px;
        }

        .admin-info {
            font-size: 13px;
            color: #64748b;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #64748b;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .stat-card p {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .stat-card h2 {
            font-size: 27px;
            color: #14532d;
        }

        .panel {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .panel-header h3 {
            font-size: 18px;
        }

        .search-form {
            display: flex;
            gap: 8px;
        }

        .search-form input {
            width: 260px;
            max-width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            outline: none;
        }

        .search-form button,
        .reset-btn {
            border: none;
            padding: 10px 15px;
            border-radius: 7px;
            background: #14532d;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
        }

        .reset-btn {
            background: #64748b;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        th {
            color: #64748b;
            background: #f8fafc;
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .active-status {
            background: #dcfce7;
            color: #166534;
        }

        .inactive-status {
            background: #fee2e2;
            color: #991b1b;
        }

        .action {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .detail-btn {
            padding: 7px 11px;
            background: #e0f2fe;
            color: #075985;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
        }

        .status-btn {
            padding: 7px 11px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }

        .deactivate-btn {
            background: #fee2e2;
            color: #991b1b;
        }

        .activate-btn {
            background: #dcfce7;
            color: #166534;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .empty {
            text-align: center;
            color: #64748b;
            padding: 35px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media(max-width: 850px) {
            .sidebar {
                width: 190px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 20px;
            }
        }

        @media(max-width: 600px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 18px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .search-form {
                width: 100%;
                flex-wrap: wrap;
            }

            .search-form input {
                flex: 1;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">SPORTIX.</div>

        <div class="menu-title">Main Menu</div>

        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="active">Kelola Pengguna</a>
            <a href="{{ route('admin.owners.index') }}">Kelola Owner</a>
            <a href="#">Kelola Lapangan</a>
            <a href="#">Monitoring Booking</a>
            <a href="#">Ulasan</a>
        </nav>

        <div class="menu-title">System</div>

        <nav class="menu">
            <a href="#">Log Aktivitas</a>
            <a href="#">Pengaturan</a>
        </nav>
    </aside>

    <main class="content">

        <div class="topbar">
            <h2>Kelola Pengguna</h2>

            <div class="admin-info">
                {{ auth()->user()->name }} · Administrator
            </div>
        </div>

        <section class="welcome">
            <h1>Manajemen Pengguna</h1>
            <p>Kelola akun pengguna yang terdaftar di platform Sportix.</p>
        </section>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <section class="stats">

            <div class="stat-card">
                <p>Total Pengguna</p>
                <h2>{{ number_format($totalUsers) }}</h2>
            </div>

            <div class="stat-card">
                <p>Pengguna Aktif</p>
                <h2>{{ number_format($activeUsers) }}</h2>
            </div>

            <div class="stat-card">
                <p>Pengguna Nonaktif</p>
                <h2>{{ number_format($inactiveUsers) }}</h2>
            </div>

        </section>

        <section class="panel">

            <div class="panel-header">
                <h3>Daftar Pengguna</h3>

                <form action="{{ route('admin.users.index') }}"
                      method="GET"
                      class="search-form">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama, email, atau telepon..."
                    >

                    <button type="submit">Cari</button>

                    @if($search)
                        <a href="{{ route('admin.users.index') }}"
                           class="reset-btn">Reset</a>
                    @endif
                </form>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Status</th>
                            <th>Terakhir Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>{{ $user->phone ?? '-' }}</td>

                                <td>
                                    @if($user->account_status === 'active')
                                        <span class="status active-status">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="status inactive-status">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->last_login_at
                                        ? $user->last_login_at->format('d-m-Y H:i')
                                        : 'Belum pernah login' }}
                                </td>

                                <td>
                                    <div class="action">

                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                           class="detail-btn">
                                            Detail
                                        </a>

                                        <form
                                            action="{{ route('admin.users.updateStatus', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengubah status akun ini?')">

                                            @csrf
                                            @method('PATCH')

                                            @if($user->account_status === 'active')
                                                <button type="submit"
                                                        class="status-btn deactivate-btn">
                                                    Nonaktifkan
                                                </button>
                                            @else
                                                <button type="submit"
                                                        class="status-btn activate-btn">
                                                    Aktifkan
                                                </button>
                                            @endif

                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="empty">
                                    Tidak ada pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $users->links() }}
            </div>

        </section>

    </main>
</div>
</body>
</html>
