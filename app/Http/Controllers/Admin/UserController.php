<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    // Menampilkan daftar seluruh pengguna biasa.
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $users = User::where('role', 'user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalUsers = User::where('role', 'user')->count();

        $activeUsers = User::where('role', 'user')
            ->where('account_status', 'active')
            ->count();

        $inactiveUsers = User::where('role', 'user')
            ->where('account_status', 'inactive')
            ->count();

        return view('admin.users.index', compact(
            'users',
            'search',
            'totalUsers',
            'activeUsers',
            'inactiveUsers'
        ));
    }

    // Menampilkan detail seorang pengguna.
    public function show(User $user): View
    {
        abort_unless($user->role === 'user', 404);

        return view('admin.users.show', compact('user'));
    }

    // Mengubah status akun pengguna.
    public function updateStatus(User $user): RedirectResponse
    {
        abort_unless($user->role === 'user', 404);

        $user->account_status =
            $user->account_status === 'active'
                ? 'inactive'
                : 'active';

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Status akun pengguna berhasil diperbarui.');
    }
}
