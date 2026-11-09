
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Owner - SPORTIX</title>

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
            background: #ffffff;
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
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .topbar h2 {
            font-size: 22px;
        }

        .admin-info {
            font-size: 13px;
            color: #68776d;
        }

        .description {
            color: #78847c;
            font-size: 14px;
            margin-top: 7px;
            margin-bottom: 25px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 11px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.03);
        }

        .stat-card p {
            color: #78847c;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .stat-card h3 {
            font-size: 25px;
            color: #176b3a;
        }

        .content-card {
            background: white;
            padding: 23px;
            border-radius: 11px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.03);
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .content-header h3 {
            font-size: 18px;
        }

        .search-form {
            display: flex;
            gap: 8px;
        }

        .search-form input {
            padding: 10px 13px;
            border: 1px solid #dce4de;
            border-radius: 7px;
            outline: none;
            width: 230px;
        }

        .search-form button {
            padding: 10px 17px;
            background: #176b3a;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th, td {
            text-align: left;
            padding: 15px 12px;
            border-bottom: 1px solid #edf0ed;
            font-size: 13px;
            white-space: nowrap;
        }

        th {
            background: #f8faf8;
            color: #68776d;
            font-weight: 600;
        }

        td {
            color: #435047;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
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

        .verified {
            background: #dcfce7;
            color: #15803d;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .unverified {
            background: #e5e7eb;
            color: #4b5563;
        }

        .detail-button {
            display: inline-block;
            text-decoration: none;
            padding: 8px 13px;
            background: #e5eee8;
            color: #176b3a;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #78847c;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(3, 1fr);
            }
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

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .search-form input {
                width: 180px;
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
            <h2>Kelola Owner</h2>

            <div class="admin-info">
                Administrator Sportix · Administrator
            </div>
        </div>

        <p class="description">
            Kelola akun pemilik lapangan, profil usaha, dan status verifikasi Owner Sportix.
        </p>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <section class="stats">

            <div class="stat-card">
                <p>Total Owner</p>
                <h3>{{ $totalOwners }}</h3>
            </div>

            <div class="stat-card">
                <p>Owner Aktif</p>
                <h3>{{ $activeOwners }}</h3>
            </div>

            <div class="stat-card">
                <p>Owner Nonaktif</p>
                <h3>{{ $inactiveOwners }}</h3>
            </div>

            <div class="stat-card">
                <p>Profil Terverifikasi</p>
                <h3>{{ $verifiedOwners }}</h3>
            </div>

            <div class="stat-card">
                <p>Menunggu Verifikasi</p>
                <h3>{{ $pendingOwners }}</h3>
            </div>

        </section>

        <section class="content-card">

            <div class="content-header">

                <h3>Daftar Owner</h3>

                <form action="{{ route('admin.owners.index') }}"
                      method="GET"
                      class="search-form">

                    <input
                        type="text"
                        name="search"
                        placeholder="Cari nama, email, telepon..."
                        value="{{ $search }}"
                    >

                    <button type="submit">Cari</button>

                </form>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Owner</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Nama Usaha</th>
                            <th>Verifikasi Profil</th>
                            <th>Jumlah Lapangan</th>
                            <th>Status Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($owners as $owner)

                            <tr>

                                <td>{{ $owners->firstItem() + $loop->index }}</td>

                                <td>{{ $owner->name }}</td>

                                <td>{{ $owner->email }}</td>

                                <td>{{ $owner->phone ?: '-' }}</td>

                                <td>
                                    {{ $owner->ownerProfile?->business_name ?: 'Belum melengkapi profil' }}
                                </td>

                                <td>

                                    @if (!$owner->ownerProfile)
                                        <span class="badge unverified">
                                            Belum ada profil
                                        </span>

                                    @elseif ($owner->ownerProfile->verification_status === 'verified')
                                        <span class="badge verified">
                                            Terverifikasi
                                        </span>

                                    @elseif ($owner->ownerProfile->verification_status === 'pending')
                                        <span class="badge pending">
                                            Menunggu
                                        </span>

                                    @else
                                        <span class="badge unverified">
                                            {{ ucfirst($owner->ownerProfile->verification_status) }}
                                        </span>
                                    @endif

                                </td>

                                <td>{{ $owner->venues_count }} Lapangan</td>

                                <td>

                                    @if ($owner->account_status === 'active')
                                        <span class="badge active">Aktif</span>
                                    @else
                                        <span class="badge inactive">Nonaktif</span>
                                    @endif

                                </td>

                                <td>
                                   <a href="{{ route('admin.owners.show', $owner->id) }}" class="detail-button">
                                        Detail
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="empty">
                                    Tidak ada data Owner yang ditemukan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination">
                {{ $owners->links() }}
            </div>

        </section>

    </main>

</body>
</html>
