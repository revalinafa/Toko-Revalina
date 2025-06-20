<?php

namespace App\Livewire\Auth;

use App\Models\User; // Pastikan model User Anda di-import
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.auth')] // Menggunakan layout khusus untuk autentikasi
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function render()
    {
        return view('livewire.auth.register'); // Ini akan me-render resources/views/livewire/auth/register.blade.php
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'admin', // Atur role default untuk user yang register
        ]);

        Auth::login($user); // Otomatis login user setelah registrasi

        return redirect()->intended('/superadmin/user'); // Redirect ke dashboard utama setelah register
    }
}