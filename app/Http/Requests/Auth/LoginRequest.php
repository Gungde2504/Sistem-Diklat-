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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string'],  // menampung NIK atau email
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login    = $this->input('email');
        $password = $this->input('password');

        // Coba login dengan NIK (pegawai internal)
        $berhasil = Auth::attempt([
            'nip'      => $login,
            'password' => $password,
            'isActive' => 1,
        ], $this->boolean('remember'));

        // Jika gagal, coba login dengan email (peserta eksternal)
        if (!$berhasil) {
            $berhasil = Auth::attempt([
                'email'    => $login,
                'password' => $password,
                'isActive' => 1,
            ], $this->boolean('remember'));
        }

        if (!$berhasil) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'NIK/Email atau password salah, atau akun tidak aktif.',
            ]);
        }

        // Peserta eksternal yang statusnya sudah selesai tidak dapat login lagi
        if (Auth::user()->eksternalSelesai()) {
            Auth::guard('web')->logout();
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Masa kegiatan Anda sudah selesai, sehingga akun tidak dapat digunakan untuk login lagi. Hubungi Admin Diklat jika ada kendala.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

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

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}