<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pengguna - SPORTIX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neu-base text-neu-dark antialiased selection:bg-neu-primary selection:text-white">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col lg:flex-row">

        <!-- Overlay Mobile Sidebar -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition.opacity
             class="fixed inset-0 z-30 bg-neu-dark/30 backdrop-blur-xs lg:hidden"
             style="display: none;">
        </div>

        <!-- SIDEBAR ADMIN (Neumorphism) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-40 w-72 bg-neu-base p-6 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:shrink-0 flex flex-col justify-between border-r border-neu-muted/15">

            <div>
                <!-- Logo & Badge Admin -->
                <div class="flex items-center justify-between mb-8 px-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-3xl font-extrabold tracking-tight text-neu-primary drop-shadow-sm">
                        SPORTIX<span class="text-neu-muted">.</span>
                    </a>
                    <span class="rounded-full bg-neu-base shadow-neu-inset px-3 py-1 text-[11px] font-extrabold text-neu-primary uppercase tracking-wider">
                        Admin
                    </span>
                </div>

                <!-- Main Menu -->
                <div class="mb-6">
                    <p class="px-4 mb-3 text-[11px] font-extrabold uppercase tracking-widest text-neu-muted">
                        Main Menu
                    </p>
                    <nav class="space-y-2.5">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center gap-3 rounded-full bg-neu-base shadow-neu-raised px-5 py-3 text-sm font-extrabold text-neu-primary transition-all duration-300">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Kelola Pengguna
                        </a>

                        <a href="{{ route('admin.owners.index') }}"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Kelola Owner
                        </a>

                        <a href="#"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Kelola Lapangan
                        </a>

                        <a href="#"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Monitoring Booking
                        </a>

                        <a href="#"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Ulasan
                        </a>
                    </nav>
                </div>

                <!-- System Menu -->
                <div>
                    <p class="px-4 mb-3 text-[11px] font-extrabold uppercase tracking-widest text-neu-muted">
                        System
                    </p>
                    <nav class="space-y-2.5">
                        <a href="#"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Log Aktivitas
                        </a>

                        <a href="#"
                           class="flex items-center gap-3 rounded-full px-5 py-3 text-sm font-bold text-neu-dark transition-all duration-300 hover:shadow-neu-inset hover:text-neu-primary">
                            <svg class="w-5 h-5 shrink-0 text-neu-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Footer Sidebar Info -->
            <div class="mt-8 rounded-[20px] bg-neu-base shadow-neu-inset p-4 text-center">
                <p class="text-xs font-extrabold text-neu-dark">Sportix Admin Panel</p>
                <p class="mt-0.5 text-[11px] font-medium text-neu-muted">Platform Management System</p>
            </div>
        </aside>

        <!-- MAIN AREA -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- TOPBAR -->
            <header class="bg-neu-base px-6 py-5 sm:px-8 border-b border-neu-muted/15">
                <div class="flex items-center justify-between gap-4">

                    <div class="flex items-center gap-3">
                        <!-- Tombol Hamburger Mobile -->
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="inline-flex lg:hidden items-center justify-center h-11 w-11 rounded-full bg-neu-base shadow-neu-raised text-neu-dark hover:shadow-neu-pressed transition-all duration-300 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <h2 class="text-xl font-extrabold text-neu-dark tracking-tight">
                            Kelola Pengguna
                        </h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-inset px-4 py-2.5 text-xs font-extrabold text-neu-dark">
                            <span>{{ auth()->user()->name }}</span>
                            <span class="text-neu-muted">·</span>
                            <span class="text-neu-primary">Administrator</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-full bg-neu-base shadow-neu-raised px-5 py-2.5 text-xs font-extrabold text-red-500 transition-all duration-300 hover:shadow-neu-pressed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>

                </div>
            </header>

            <!-- CONTENT -->
            <main class="flex-1 p-6 sm:p-8 lg:p-10">
                <div class="mx-auto max-w-7xl">

                    <!-- Header Halaman -->
                    <div class="mb-10">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-neu-dark tracking-tight">
                            Manajemen Pengguna
                        </h1>
                        <p class="mt-2 text-base font-medium text-neu-muted">
                            Kelola akun pengguna yang terdaftar di platform Sportix.
                        </p>
                    </div>

                    <!-- Alert Success -->
                    @if(session('success'))
                        <div class="mb-8 rounded-[20px] bg-neu-base shadow-neu-inset p-5 border border-green-500/30 flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-extrabold text-green-600">{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Statistik Pengguna (3 Kolom) -->
                    <section class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">

                        <!-- Total Pengguna -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-neu-primary shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-neu-muted">Total Pengguna</p>
                                <h2 class="mt-1 text-3xl font-extrabold text-neu-primary">
                                    {{ number_format($totalUsers) }}
                                </h2>
                            </div>
                        </div>

                        <!-- Pengguna Aktif -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-neu-muted">Pengguna Aktif</p>
                                <h2 class="mt-1 text-3xl font-extrabold text-green-600">
                                    {{ number_format($activeUsers) }}
                                </h2>
                            </div>
                        </div>

                        <!-- Pengguna Nonaktif -->
                        <div class="rounded-[24px] bg-neu-base p-6 shadow-neu-raised flex items-center gap-5 transition-all duration-300 hover:shadow-neu-hover">
                            <div class="h-14 w-14 rounded-2xl bg-neu-base shadow-neu-inset flex items-center justify-center text-red-500 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-neu-muted">Pengguna Nonaktif</p>
                                <h2 class="mt-1 text-3xl font-extrabold text-red-500">
                                    {{ number_format($inactiveUsers) }}
                                </h2>
                            </div>
                        </div>

                    </section>

                    <!-- Panel Daftar Pengguna -->
                    <section class="rounded-[28px] bg-neu-base p-6 sm:p-8 shadow-neu-raised">

                        <!-- Header & Form Pencarian -->
                        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <h3 class="text-xl font-extrabold text-neu-dark">
                                Daftar Pengguna
                            </h3>

                            <form action="{{ route('admin.users.index') }}"
                                  method="GET"
                                  class="flex flex-wrap items-center gap-3 w-full sm:w-auto">

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ $search }}"
                                    placeholder="Cari nama, email, atau telepon..."
                                    class="flex-1 sm:w-72 rounded-full border-none bg-neu-base shadow-neu-inset px-5 py-3 text-sm font-bold text-neu-dark placeholder-neu-muted focus:ring-0 focus:shadow-neu-pressed transition-all outline-none"
                                >

                                <button type="submit"
                                        class="rounded-full bg-neu-primary px-6 py-3 text-xs font-extrabold text-white shadow-neu-raised transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed active:bg-neu-primary-dark">
                                    Cari
                                </button>

                                @if($search)
                                    <a href="{{ route('admin.users.index') }}"
                                       class="rounded-full bg-neu-base shadow-neu-raised px-5 py-3 text-xs font-extrabold text-neu-muted transition-all duration-300 hover:shadow-neu-pressed hover:text-neu-dark">
                                        Reset
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- Tabel Pengguna -->
                        <div class="overflow-x-auto rounded-[20px] bg-neu-base shadow-neu-inset p-2 sm:p-4">
                            <table class="w-full min-w-[820px] text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-neu-muted/20 text-[11px] font-extrabold uppercase tracking-wider text-neu-muted">
                                        <th class="py-3.5 px-4">No.</th>
                                        <th class="py-3.5 px-4">Nama</th>
                                        <th class="py-3.5 px-4">Email</th>
                                        <th class="py-3.5 px-4">Nomor Telepon</th>
                                        <th class="py-3.5 px-4">Status</th>
                                        <th class="py-3.5 px-4">Terakhir Login</th>
                                        <th class="py-3.5 px-4 text-right">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-neu-muted/15 text-sm">
                                    @forelse($users as $index => $user)
                                        <tr class="transition-colors hover:bg-white/20">
                                            <td class="py-4 px-4 font-extrabold text-neu-muted">
                                                {{ $users->firstItem() + $index }}
                                            </td>

                                            <td class="py-4 px-4 font-extrabold text-neu-dark">
                                                {{ $user->name }}
                                            </td>

                                            <td class="py-4 px-4 font-medium text-neu-dark">
                                                {{ $user->email }}
                                            </td>

                                            <td class="py-4 px-4 font-medium text-neu-muted">
                                                {{ $user->phone ?? '-' }}
                                            </td>

                                            <td class="py-4 px-4">
                                                @if($user->account_status === 'active')
                                                    <span class="inline-block rounded-full bg-neu-base shadow-neu-raised px-3.5 py-1 text-[11px] font-extrabold text-green-600 uppercase tracking-wider">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-block rounded-full bg-neu-base shadow-neu-raised px-3.5 py-1 text-[11px] font-extrabold text-red-500 uppercase tracking-wider">
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="py-4 px-4 text-xs font-bold text-neu-muted">
                                                {{ $user->last_login_at
                                                    ? $user->last_login_at->format('d-m-Y H:i')
                                                    : 'Belum pernah login' }}
                                            </td>

                                            <td class="py-4 px-4">
                                                <div class="flex items-center justify-end gap-2.5">

                                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                                       class="rounded-full bg-neu-base shadow-neu-raised px-4 py-2 text-xs font-extrabold text-neu-primary transition-all duration-300 hover:shadow-neu-pressed">
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
                                                                    class="rounded-full bg-neu-base shadow-neu-raised px-4 py-2 text-xs font-extrabold text-red-500 transition-all duration-300 hover:shadow-neu-pressed">
                                                                Nonaktifkan
                                                            </button>
                                                        @else
                                                            <button type="submit"
                                                                    class="rounded-full bg-neu-base shadow-neu-raised px-4 py-2 text-xs font-extrabold text-green-600 transition-all duration-300 hover:shadow-neu-pressed">
                                                                Aktifkan
                                                            </button>
                                                        @endif

                                                    </form>

                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-12 px-4 text-center text-sm font-bold text-neu-muted">
                                                Tidak ada pengguna yang ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>

                    </section>

                </div>
            </main>

        </div>
    </div>

</body>
</html>