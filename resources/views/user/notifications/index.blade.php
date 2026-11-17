<x-app-layout>
    <div class="min-h-screen bg-neu-base py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-extrabold text-neu-dark tracking-tight">
                    Notifikasi
                </h1>
                <p class="mt-2 text-base font-medium text-neu-muted">
                    Lihat informasi terbaru mengenai status aktivitas dan booking kamu.
                </p>
            </div>

            {{-- Daftar Notifikasi --}}
            <div class="space-y-5">

                @forelse ($notifications as $notification)
                    <div class="rounded-[28px] bg-neu-base shadow-neu-raised p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6 transition-all duration-300 {{ !$notification->is_read ? 'border-2 border-neu-primary/30' : '' }}">

                        <div class="flex items-start gap-5">
                            {{-- Icon Status Notifikasi --}}
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-neu-base shadow-neu-inset
                                {{ $notification->notification_type === 'booking_confirmed'
                                    ? 'text-green-600'
                                    : ($notification->notification_type === 'booking_rejected'
                                        ? 'text-red-500'
                                        : 'text-neu-primary') }}">

                                @if ($notification->notification_type === 'booking_confirmed')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                @elseif ($notification->notification_type === 'booking_rejected')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @else
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>

                            {{-- Isi Teks Notifikasi --}}
                            <div>
                                <div class="flex items-center gap-3 flex-wrap mb-1">
                                    <h3 class="text-lg font-extrabold text-neu-dark">
                                        {{ $notification->title }}
                                    </h3>

                                    @if (!$notification->is_read)
                                        <span class="rounded-full bg-neu-primary px-3.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-neu-raised">
                                            Baru
                                        </span>
                                    @endif
                                </div>

                                <p class="text-sm font-medium text-neu-muted leading-relaxed">
                                    {{ $notification->message }}
                                </p>

                                <p class="mt-3 text-xs font-bold text-neu-muted">
                                    {{ $notification->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Aksi "Tandai Sudah Dibaca" --}}
                        @if (!$notification->is_read)
                            <form method="POST" action="{{ route('user.notifications.read', $notification->id) }}" class="shrink-0">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="inline-flex items-center justify-center rounded-full bg-neu-base shadow-neu-raised px-6 py-3 text-xs font-extrabold text-neu-primary transition-all duration-300 hover:shadow-neu-hover active:shadow-neu-pressed">
                                    Tandai Dibaca
                                </button>
                            </form>
                        @endif

                    </div>
                @empty

                    {{-- State Kosong --}}
                    <div class="flex flex-col items-center justify-center rounded-[32px] bg-neu-base shadow-neu-inset px-6 py-24 text-center">
                        <div class="mb-6 flex h-28 w-28 items-center justify-center rounded-full bg-neu-base shadow-neu-raised text-neu-primary">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>

                        <h3 class="text-3xl font-extrabold text-neu-dark">
                            Belum Ada Notifikasi
                        </h3>

                        <p class="mt-3 text-base font-medium text-neu-muted max-w-md">
                            Segala informasi penting seputar pemesanan dan konfirmasi venue akan muncul di sini.
                        </p>
                    </div>

                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                <div class="rounded-[24px] bg-neu-base shadow-neu-inset p-4">
                    {{ $notifications->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>