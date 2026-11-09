<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-800">
                    Notifikasi
                </h1>

                <p class="mt-2 text-slate-500">
                    Lihat informasi terbaru mengenai aktivitas booking kamu.
                </p>
            </div>

            <!-- Daftar Notifikasi -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                @forelse ($notifications as $notification)
                    <div class="flex gap-4 border-b border-slate-100 p-5
                        {{ !$notification->is_read ? 'bg-blue-50/60' : 'bg-white' }}">

                        <!-- Icon -->
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full
                            {{ $notification->notification_type === 'booking_confirmed'
                                ? 'bg-green-100 text-green-600'
                                : ($notification->notification_type === 'booking_rejected'
                                    ? 'bg-red-100 text-red-600'
                                    : 'bg-blue-100 text-blue-600') }}">

                            @if ($notification->notification_type === 'booking_confirmed')
                                ✓
                            @elseif ($notification->notification_type === 'booking_rejected')
                                ✕
                            @else
                                !
                            @endif
                        </div>

                        <!-- Isi Notifikasi -->
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-2">

                                <h3 class="font-bold text-slate-800">
                                    {{ $notification->title }}
                                </h3>

                                @if (!$notification->is_read)
                                    <span class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">
                                        Baru
                                    </span>
                                @endif

                            </div>

                            <p class="mt-1 text-sm leading-relaxed text-slate-600">
                                {{ $notification->message }}
                            </p>

                            <p class="mt-3 text-xs text-slate-400">
                                {{ $notification->created_at->format('d M Y, H:i') }}
                            </p>

                            @if (!$notification->is_read)
                                <form
                                    method="POST"
                                    action="{{ route('user.notifications.read', $notification->id) }}"
                                    class="mt-3"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                    >
                                        Tandai sudah dibaca
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @empty

                    <div class="p-12 text-center">
                        <div class="mb-4 text-5xl">🔔</div>

                        <h3 class="text-lg font-bold text-slate-800">
                            Belum Ada Notifikasi
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Notifikasi booking kamu akan muncul di sini.
                        </p>
                    </div>

                @endforelse

            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
