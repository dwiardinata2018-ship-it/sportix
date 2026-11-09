
<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <!-- Navbar Utama -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">

            <!-- Logo Sportix -->
            <div class="flex items-center">
                <a href="{{ route('user.dashboard') }}"
                   class="text-2xl font-extrabold tracking-tight text-blue-600">
                    SPORTIX<span class="text-slate-800">.</span>
                </a>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden space-x-8 sm:flex sm:items-center">

                <x-nav-link
                    :href="route('user.dashboard')"
                    :active="request()->routeIs('user.dashboard')">
                    Home
                </x-nav-link>

                <x-nav-link
                    :href="route('user.reservation')"
                    :active="request()->routeIs('user.reservation')">
                    Reservation
                </x-nav-link>

                <x-nav-link
                    :href="route('user.booking')"
                    :active="request()->routeIs('user.booking')">
                    Booking
                </x-nav-link>

                <x-nav-link
                    :href="route('user.activity')"
                    :active="request()->routeIs('user.activity')">
                    Activity
                </x-nav-link>

                <x-nav-link
                    :href="route('user.notifications')"
                    :active="request()->routeIs('user.notifications')">
                    Notifikasi

                    @if ($unreadNotificationCount > 0)
                        <span class="ms-2 rounded-full bg-red-500 px-2 py-0.5 text-xs font-bold text-white">
                            {{ $unreadNotificationCount }}
                        </span>
                    @endif
                </x-nav-link>

            </div>

            <!-- Dropdown Profile Desktop -->
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:text-blue-600">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-2">
                                <svg class="h-4 w-4 fill-current"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="block w-full px-4 py-2 text-start text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition duration-150 ease-in-out">
                                Logout
                            </button>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-blue-600">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <path
                            :class="{ 'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path
                            :class="{ 'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Menu Mobile -->
    <div :class="{ 'block': open, 'hidden': ! open }"
         class="hidden sm:hidden">

        <div class="space-y-1 pb-3 pt-2">

            <x-responsive-nav-link
                :href="route('user.dashboard')"
                :active="request()->routeIs('user.dashboard')">
                Home
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('user.reservation')"
                :active="request()->routeIs('user.reservation')">
                Reservation
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('user.booking')"
                :active="request()->routeIs('user.booking')">
                Booking
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('user.activity')"
                :active="request()->routeIs('user.activity')">
                Activity
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('user.notifications')"
                :active="request()->routeIs('user.notifications')">
                Notifikasi

                @if ($unreadNotificationCount > 0)
                    <span class="ms-2 rounded-full bg-red-500 px-2 py-0.5 text-xs font-bold text-white">
                        {{ $unreadNotificationCount }}
                    </span>
                @endif
            </x-responsive-nav-link>

        </div>

        <!-- Informasi User Mobile -->
        <div class="border-t border-slate-200 pb-1 pt-4">

            <div class="px-4">
                <div class="text-base font-medium text-slate-800">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-sm font-medium text-slate-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-700 hover:bg-slate-100 hover:text-blue-600 focus:bg-slate-100 transition duration-150 ease-in-out">
                    Logout
                </button>
            </form>

            </div>
        </div>

    </div>
</nav>
