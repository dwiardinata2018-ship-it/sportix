<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.notifications.index', compact('notifications'));
    }

    public function markAsRead(int $id): RedirectResponse
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()
            ->route('user.notifications')
            ->with('success', 'Notifikasi berhasil ditandai sudah dibaca.');
    }
}
