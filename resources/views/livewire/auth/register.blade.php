<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Toko</b>Revalina</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Daftar Akun Baru</p>

            <form wire:submit.prevent="register">
                <div class="input-group mb-3">
                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input wire:model="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        {{-- Opsional: Term & Conditions --}}
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                    </div>
            </form>

            <a href="{{ route('login') }}" class="text-center">Saya sudah punya akun</a>
        </div>
        </div></div>