<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
           <i class="fas fa-plus mr-1"></i>
            Tambah {{ $title }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
                <label for="name" class="form-label">Nama</label>
                <span class="text-danger">*</span>
                <input wire:model="name" type="text" class="form-control 
                @error('name') is-invalid @enderror" 
                placeholder="Masukkan nama">
                @error('name')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                @enderror
        </div>
        <div class="row mt-3">
                <label for="email" class="form-label">Email</label>
                <span class="text-danger">*</span>
                <input wire:model="email" type="email" class="form-control 
                @error('email') is-invalid @enderror" 
                placeholder="Masukkan email">
                @error('email')
                    <small class="text-danger">
                      {{ $message }}
                    </small>
                @enderror
      </div>
      <div class="row mt-2">
        <label for="role" class="form-label">Role</label>
        <span class="text-danger">*</span>
        <select id="role" wire:model="role" class="form-control 
        @error('role') is-invalid @enderror">
          <option selected>-- Pilih role</option>
          <option value="superadmin">Super Admin</option>
          <option value="admin">Admin</option>
        </select>
        @error('role')
            <small class="text-danger">
              {{ $message }}
            </small>
        @enderror
      </div>
      <div class="row mt-2">
        <label for="password" class="form-label">Password</label>
        <span class="text-danger">*</span>
        <input wire:model="password" type="password" class="form-control 
        @error('password') is-invalid @enderror" 
        placeholder="Masukkan password">
        @error('password')
            <small class="text-danger">
              {{ $message }}
            </small>
        @enderror
      </div>
      <div class="row mt-2">
        <label for="password_confirmation" class="form-label">Password Konfirmasi</label>
        <span class="text-danger">*</span>
        <input wire:model="password_confirmation" type="password" class="form-control 
        @error('password_confirmation') is-invalid @enderror" 
        placeholder="Masukkan password konfirmasi">
        @error('password_confirmation')
            <small class="text-danger">
              {{ $message }}
            </small>
        @enderror
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>
            Tutup
        </button>
        <button wire:click='store' type="button" class="btn btn-sm btn-primary">
            <i class="fas fa-save mr-1"></i>
            Simpan
        </button>
      </div>
    </div>
  </div>
</div>