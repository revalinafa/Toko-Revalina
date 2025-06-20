<?php

namespace App\Livewire\Superadmin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] 

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = '';

    public $name,
           $email,
           $role,
           $password,
           $password_confirmation,
           $user_id; // Properti untuk menyimpan ID user yang sedang diedit/dihapus

    public function render()
    {
        $data = array(
            'title' => 'Data User',
            'user' => User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orWhere('role', 'like', '%'.$this->search.'%')
            ->orderBy('role', 'desc')->paginate($this->paginate),
        );
        return view('livewire.superadmin.user.index', $data);
    }

    public function create(){
        $this->resetValidation();
        $this->reset([
            'name',
            'email',
            'role',
            'password',
            'password_confirmation'
        ]);
    }

    public function store(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ],
        [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak cocok',
            'password_confirmation.required' => 'Password konfirmasi tidak boleh kosong',
        ]);
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->password = Hash::make($this->password);
        $user->save();

        $this->dispatch('success', 'User berhasil ditambahkan');
        $this->dispatch('closeCreateModal');
        $this->resetValidation();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id; // Penting: simpan ID user yang akan diedit
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = null; // Reset password fields
        $this->password_confirmation = null; // Reset password confirmation fields

        $this->dispatch('showEditModal');
    }

    public function update($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);

        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
            'password' => 'nullable|min:8|confirmed',
            // 'password_confirmation' tidak perlu divalidasi secara eksplisit jika password nullable
            // Cukup tambahkan rule 'confirmed' pada 'password'
        ],
        [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak cocok',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        $this->dispatch('success', 'User berhasil diperbarui');
        $this->dispatch('closeEditModal');
        $this->resetValidation();
    }

    // --- Tambahkan Fungsi untuk Hapus Data di Sini ---

    public function deleteConfirmation($id)
    {
        // Simpan ID user yang akan dihapus ke properti user_id
        // Ini akan digunakan oleh modal delete.blade.php
        $this->user_id = $id;

        // Tidak perlu dispatch event untuk menampilkan modal karena sudah ada data-target di button
        // Namun, jika ada kebutuhan lain (misal, mereset state), bisa ditambahkan.
    }

    public function destroy($id)
    {
        // Temukan user dan hapus
        $user = User::findOrFail($id);
        $user->delete();

        // Dispatch event untuk menutup modal dan menampilkan notifikasi sukses
        $this->dispatch('success', 'User berhasil dihapus');
        $this->dispatch('closeDeleteModal');

        // Reset user_id setelah penghapusan
        $this->user_id = null;
    }

    // --- End Tambahkan Fungsi untuk Hapus Data ---
}