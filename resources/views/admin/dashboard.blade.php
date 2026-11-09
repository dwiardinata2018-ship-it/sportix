
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sportix</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f8f6;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #14532d;
            color: white;
            padding: 25px 18px;
            flex-shrink: 0;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .logo span {
            color: #86efac;
        }

        .menu-title {
            font-size: 11px;
            color: #bbf7d0;
            margin: 25px 10px 12px;
            text-transform: uppercase;
        }

        .menu a {
            display: block;
            color: #dcfce7;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 9px;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .menu a.active,
        .menu a:hover {
            background: #166534;
            color: white;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar h2 {
            font-size: 20px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 13px;
            color: #64748b;
        }

        .logout-button {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            padding: 9px 14px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #fecaca;
        }

        .content {
            padding: 30px;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 25px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #64748b;
            font-size: 14px;
        }

        .section-title {
            font-size: 17px;
            margin-bottom: 15px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 13px;
            border: 1px solid #e5e7eb;
        }

        .stat-label {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 13px;
        }

        .stat-value {
            font-size: 29px;
            font-weight: bold;
            color: #166534;
        }

        .stat-note {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 8px;
        }

        .monitor-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .monitor-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .monitor-card p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .monitor-card h2 {
            font-size: 25px;
        }

        .pending {
            color: #d97706;
        }

        .active {
            color: #16a34a;
        }

        .inactive {
            color: #64748b;
        }

        .summary {
            background: white;
            padding: 22px;
            border: 1px solid #e5e7eb;
            border-radius: 13px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row span {
            color: #64748b;
        }

        @media (max-width: 1000px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .logo {
                margin-bottom: 15px;
            }

            .menu-title {
                margin-top: 15px;
            }

            .topbar {
                padding: 18px;
            }

            .content {
                padding: 20px 15px;
            }

            .stats,
            .monitor-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="logo">SPORT<span>IX.</span></div>

        <div class="menu-title">Main Menu</div>

        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="active">
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}">Kelola Pengguna</a>
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

    <main class="main">

        
    <header class="topbar">
        <h2>Dashboard Admin</h2>

        <div class="admin-info">
            <span>
                {{ auth()->user()->name }} · Administrator
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </div>
    </header>


        <section class="content">

            <div class="welcome">
                <h1>Selamat Datang, Admin!</h1>
                <p>
                    Berikut adalah ringkasan aktivitas platform Sportix.
                </p>
            </div>

            <h3 class="section-title">Statistik Platform</h3>

            <div class="stats">

                <div class="stat-card">
                    <p class="stat-label">Total Pengguna</p>
                    <div class="stat-value">
                        {{ number_format($totalUsers) }}
                    </div>
                    <p class="stat-note">Akun dengan role User</p>
                </div>

                <div class="stat-card">
                    <p class="stat-label">Total Owner</p>
                    <div class="stat-value">
                        {{ number_format($totalOwners) }}
                    </div>
                    <p class="stat-note">Akun pemilik lapangan</p>
                </div>

                <div class="stat-card">
                    <p class="stat-label">Total Lapangan</p>
                    <div class="stat-value">
                        {{ number_format($totalVenues) }}
                    </div>
                    <p class="stat-note">Seluruh lapangan terdaftar</p>
                </div>

                <div class="stat-card">
                    <p class="stat-label">Total Booking</p>
                    <div class="stat-value">
                        {{ number_format($totalBookings) }}
                    </div>
                    <p class="stat-note">Seluruh pemesanan</p>
                </div>

            </div>

            <h3 class="section-title">Monitoring Lapangan</h3>

            <div class="monitor-grid">

                <div class="monitor-card">
                    <p>Menunggu Verifikasi</p>
                    <h2 class="pending">
                        {{ number_format($pendingVenues) }}
                    </h2>
                </div>

                <div class="monitor-card">
                    <p>Lapangan Aktif</p>
                    <h2 class="active">
                        {{ number_format($activeVenues) }}
                    </h2>
                </div>

                <div class="monitor-card">
                    <p>Lapangan Nonaktif</p>
                    <h2 class="inactive">
                        {{ number_format($inactiveVenues) }}
                    </h2>
                </div>

            </div>

            <h3 class="section-title">Informasi Tambahan</h3>

            <div class="summary">

                <div class="summary-row">
                    <span>Total Admin</span>
                    <strong>{{ number_format($totalAdmins) }}</strong>
                </div>

                <div class="summary-row">
                    <span>Pengguna Aktif</span>
                    <strong>{{ number_format($activeUsers) }}</strong>
                </div>

                <div class="summary-row">
                    <span>Owner Aktif</span>
                    <strong>{{ number_format($activeOwners) }}</strong>
                </div>

                <div class="summary-row">
                    <span>Total Ulasan</span>
                    <strong>{{ number_format($totalReviews) }}</strong>
                </div>

            </div>

        </section>
    </main>
</div>
</body>
</html>
