<nav x-data="{ open: false }" class="bg-neu-base pt-6 pb-4">
    <!-- Navbar Utama -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">

            <!-- 1. KIRI (Garis Ungu): Logo Sportix -->
            <div class="flex items-center">
                <a href="{{ route('user.dashboard') }}"
                   class="text-3xl font-extrabold tracking-tight text-neu-primary drop-shadow-sm">
                    SPORTIX<span class="text-neu-muted">.</span>
                </a>
            </div>

            <!-- 2. TENGAH (Lingkaran Hitam): Menu Desktop (Gaya TABS UI Kit) -->
            <div class="hidden sm:flex sm:items-center">
                <!-- Inset Container untuk Tabs -->
                <div class="flex items-center space-x-2 bg-neu-base shadow-neu-inset rounded-full p-1.5">
                    
                    <a href="{{ route('user.dashboard') }}"
                       class="{{ request()->routeIs('user.dashboard') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark hover:text-neu-primary' }} px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                        Home
                    </a>

                    <a href="{{ route('user.reservation') }}"
                       class="{{ request()->routeIs('user.reservation') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark hover:text-neu-primary' }} px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                        Reservation
                    </a>

                    <a href="{{ route('user.booking') }}"
                       class="{{ request()->routeIs('user.booking') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark hover:text-neu-primary' }} px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                        Booking
                    </a>

                    <a href="{{ route('user.activity') }}"
                       class="{{ request()->routeIs('user.activity') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark hover:text-neu-primary' }} px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                        Activity
                    </a>

                    <a href="{{ route('user.notifications') }}"
                       class="{{ request()->routeIs('user.notifications') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark hover:text-neu-primary' }} flex items-center px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300">
                        Notifikasi
                        @if ($unreadNotificationCount > 0)
                            <span class="ms-2 rounded-full bg-neu-primary px-2 py-0.5 text-xs font-bold text-white shadow-sm">
                                {{ $unreadNotificationCount }}
                            </span>
                        @endif
                    </a>

                </div>
            </div>

            <!-- 3. KANAN (Garis Merah & Profil): Tombol Logout & Dropdown Profile Desktop -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                
                <!-- Tombol Logout Langsung di Kiri Profil (Posisi Garis Merah) -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-neu-base shadow-neu-raised text-red-500 transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed focus:outline-none" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>

                <!-- Dropdown Profile -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-neu-base shadow-neu-raised text-neu-dark transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed focus:outline-none">
                            <!-- Icon Avatar Placeholder -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-neu-base rounded-2xl shadow-neu-raised p-2 mt-2 ring-0 border-0">
                            <div class="px-4 py-2 border-b border-neu-muted/20 mb-2">
                                <p class="text-sm font-bold text-neu-dark">{{ Auth::user()->name }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                               class="block w-full px-4 py-2 text-start text-sm font-bold text-neu-dark rounded-xl hover:shadow-neu-inset transition-all duration-300 mb-1">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="block w-full px-4 py-2 text-start text-sm font-bold text-red-500 rounded-xl hover:shadow-neu-inset transition-all duration-300">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-neu-base shadow-neu-raised text-neu-dark hover:shadow-neu-pressed transition-all duration-300 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Menu Mobile -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden bg-neu-base mt-6 px-4">
        <div class="bg-neu-base shadow-neu-inset rounded-3xl p-4 space-y-2">
            <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark' }} block w-full px-5 py-3 rounded-full font-bold transition-all duration-300">Home</a>
            <a href="{{ route('user.reservation') }}" class="{{ request()->routeIs('user.reservation') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark' }} block w-full px-5 py-3 rounded-full font-bold transition-all duration-300">Reservation</a>
            <a href="{{ route('user.booking') }}" class="{{ request()->routeIs('user.booking') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark' }} block w-full px-5 py-3 rounded-full font-bold transition-all duration-300">Booking</a>
            <a href="{{ route('user.activity') }}" class="{{ request()->routeIs('user.activity') ? 'bg-neu-base shadow-neu-raised text-neu-primary' : 'text-neu-dark' }} block w-full px-5 py-3 rounded-full font-bold transition-all duration-300">Activity</a>
            
            <div class="border-t border-neu-muted/20 my-2 pt-2">
                <a href="{{ route('profile.edit') }}" class="block w-full px-5 py-3 text-start font-bold text-neu-dark hover:text-neu-primary transition-all duration-300">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-5 py-3 text-start font-bold text-red-500 transition-all duration-300">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>