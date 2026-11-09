<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Menentukan apakah request diizinkan.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi login.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:150'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Memeriksa kredensial pengguna.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Login hanya berhasil jika akun berstatus active
        if (! Auth::attempt([
            'email' => $this->input('email'),
            'password' => $this->input('password'),
            'account_status' => 'active',
        ], $this->boolean('remember'))) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Menghapus penghitung percobaan login
        RateLimiter::clear($this->throttleKey());

        // Memperbarui waktu login terakhir
        Auth::user()->update([
            'last_login_at' => now(),
        ]);
    }

    /**
     * Memeriksa batas percobaan login.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Membuat identitas pembatasan percobaan login.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('email')) . '|' . $this->ip()
        );
    }
}
