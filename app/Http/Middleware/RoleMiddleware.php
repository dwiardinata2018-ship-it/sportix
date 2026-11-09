<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memeriksa hak akses berdasarkan role pengguna.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        // Mengambil pengguna yang sedang login
        $user = $request->user();

        // Jika belum login, arahkan ke halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // Memeriksa apakah role pengguna diizinkan
        if (!in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika role sesuai, lanjutkan request
        return $next($request);
    }
}
