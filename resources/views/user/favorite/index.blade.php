
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Venue Favorit Saya
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    Daftar Venue Favorit
                </h3>
                <p class="text-sm text-gray-600">
                    Venue yang kamu simpan agar mudah ditemukan kembali.
                </p>
            </div>

            @forelse ($favorites as $favorite)
                @php
                    $venue = $favorite->venue;
                    $primaryImage = $venue?->images
                        ->firstWhere('is_primary', true)
                        ?? $venue?->images->first();
                @endphp

                @if ($venue)
                    <div class="mb-5 bg-white rounded-xl shadow-sm border p-4 flex flex-col sm:flex-row gap-5">

                        <div class="w-full sm:w-48 h-36 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if ($primaryImage)
                                <img
                                    src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                    alt="{{ $venue->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    Tidak ada foto
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-800">
                                {{ $venue->name }}
                            </h4>

                            <p class="text-sm text-gray-600 mt-1">
                                {{ $venue->sport->name ?? 'Kategori olahraga' }}
                            </p>

                            <p class="text-sm text-gray-500 mt-2">
                                {{ $venue->city ?? $venue->address ?? 'Lokasi belum tersedia' }}
                            </p>

                            <div class="flex flex-wrap gap-3 mt-4">
                                <a
                                    href="{{ route('user.reservation.detail', $venue->slug) }}"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm"
                                >
                                    Lihat Venue
                                </a>

                                <form
                                    action="{{ route('user.favorites.destroy', $venue->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus venue ini dari favorit?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm"
                                    >
                                        Hapus Favorit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="bg-white rounded-xl shadow-sm border p-10 text-center">
                    <h4 class="text-lg font-semibold text-gray-800">
                        Belum Ada Venue Favorit
                    </h4>
                    <p class="text-gray-500 mt-2">
                        Kamu belum menyimpan venue apa pun ke daftar favorit.
                    </p>

                    <a
                        href="{{ route('user.reservation') }}"
                        class="inline-block mt-5 px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"
                    >
                        Cari Venue
                    </a>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $favorites->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
