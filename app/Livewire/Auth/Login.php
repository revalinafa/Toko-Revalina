<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.auth')] // Menggunakan layout khusus untuk autentikasi
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function render()
    {
        return view('livewire.auth.login'); // Ini akan me-render resources/views/livewire/auth/login.blade.php
    }

    public function authenticate()
    {
        $this->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cek apakah ada rate limit (percobaan login berlebihan)
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Jika autentikasi gagal
            RateLimiter::hit($this->throttleKey()); // Tambah hit ke rate limiter

            throw ValidationException::withMessages([
                'email' => __('auth.failed'), // Menggunakan pesan standar Laravel
            ]);
        }

        // Jika autentikasi berhasil
        RateLimiter::clear($this->throttleKey()); // Bersihkan rate limiter

        return redirect()->intended('/superadmin/user'); // Redirect ke dashboard utama setelah login
    }

    // Metode untuk rate limiting
    protected function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) { // 5 percobaan dalam 1 menit
            return;
        }

        event(new \Illuminate\Auth\Events\Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey()
    {
        return strtolower($this->email).'|'.request()->ip();
    }
}