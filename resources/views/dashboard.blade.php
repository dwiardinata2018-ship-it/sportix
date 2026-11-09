
<x-app-layout>
    <div class="min-h-screen bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">
                    Temukan Tempat Olahragamu!
                </h1>

                <p class="mt-2 text-slate-500">
                    Cari dan booking tempat olahraga favoritmu bersama Sportix.
                </p>
            </div>

            <!-- Search Section -->
            <div class="rounded-2xl bg-blue-600 p-6 shadow-lg">
                <h2 class="mb-4 text-xl font-bold text-white">
                    Mau olahraga di mana hari ini?
                </h2>

                <form action="#" method="GET"
                    class="flex flex-col gap-3 md:flex-row">

                    <input
                        type="text"
                        name="search"
                        placeholder="Cari nama venue atau olahraga..."
                        class="flex-1 rounded-xl border-0 px-4 py-3 text-slate-700 focus:ring-2 focus:ring-blue-300"
                    >

                    <button
                        type="submit"
                        class="rounded-xl bg-white px-7 py-3 font-semibold text-blue-600 hover:bg-blue-50">
                        Cari Venue
                    </button>

                </form>
            </div>

            <!-- Sport Categories -->
            <section class="mt-10">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-800">
                        Kategori Olahraga
                    </h2>

                    <a href="#" class="text-sm font-semibold text-blue-600">
                        Lihat Semua
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">

                    @foreach ([
                        ['name' => 'Badminton', 'icon' => '🏸'],
                        ['name' => 'Futsal', 'icon' => '⚽'],
                        ['name' => 'Basket', 'icon' => '🏀'],
                        ['name' => 'Tenis', 'icon' => '🎾'],
                        ['name' => 'Voli', 'icon' => '🏐'],
                        ['name' => 'Renang', 'icon' => '🏊'],
                    ] as $sport)

                        <div class="rounded-xl border border-slate-100 bg-white p-5 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                            <div class="mb-3 text-3xl">
                                {{ $sport['icon'] }}
                            </div>

                            <h3 class="font-semibold text-slate-700">
                                {{ $sport['name'] }}
                            </h3>
                        </div>

                    @endforeach

                </div>
            </section>

            <!-- Recommended Venues -->
            <section class="mt-10">

                <div class="mb-5">
                    <h2 class="text-xl font-bold text-slate-800">
                        Rekomendasi Venue
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Temukan tempat olahraga yang sesuai dengan kebutuhanmu.
                    </p>
                </div>

                <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-12 text-center">

                    <div class="mb-3 text-5xl">🏟️</div>

                    <h3 class="text-lg font-semibold text-slate-700">
                        Venue akan tampil di sini
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                        Venue yang sudah diverifikasi dan diaktifkan oleh Admin
                        nantinya akan muncul secara otomatis di halaman ini.
                    </p>

                </div>

            </section>

        </div>
    </div>
</x-app-layout>
