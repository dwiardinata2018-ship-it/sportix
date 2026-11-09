<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman Register.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Memproses pendaftaran pengguna baru.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data pendaftaran
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Membuat akun pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,

            // Role dan status ditentukan oleh sistem
            'role' => 'user',
            'account_status' => 'active',
        ]);

        // Menjalankan event setelah registrasi
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Mengarahkan pengguna ke Dashboard
        return redirect(route('dashboard', absolute: false));
    }
}
