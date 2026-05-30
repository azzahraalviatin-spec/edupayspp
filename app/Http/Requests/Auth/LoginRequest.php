<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Cek jika yang login adalah siswa berdasarkan input hidden login_type
        if ($this->input('login_type') === 'siswa') {
            return [
                'nama'     => ['required', 'string'],
                'password' => ['required', 'string'], // Password di sini berisi NIS
            ];
        }

        // Default untuk Admin & Petugas
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // LOGIK LOGIN SISWA (Nama Lengkap + NIS sebagai password)
        if ($this->input('login_type') === 'siswa') {
            // Pastikan di database field 'name' sesuai dengan nama lengkap siswa
            $user = User::where('name', $this->nama)->first();

            // Memeriksa apakah user ada dan password (NIS) cocok
            if (!$user || !Hash::check($this->password, $user->password)) {
                RateLimiter::hit($this->throttleKey());
                
                throw ValidationException::withMessages([
                    'nama' => 'Nama lengkap atau NIS Anda salah.',
                ]);
            }

            Auth::login($user, $this->boolean('remember'));
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // LOGIK LOGIN ADMIN & PETUGAS (Email + Password biasa)
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        // Gabungkan identitas login agar fitur pembatasan (rate limiting) tetap akurat
        $identity = $this->input('login_type') === 'siswa' ? $this->string('nama') : $this->string('email');
        return Str::transliterate(Str::lower($identity) . '|' . $this->ip());
    }
}