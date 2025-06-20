<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-tags mr-1"></i> {{ $title }}</h1> {{-- Icon untuk Kategori --}}
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home mr-1"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-tags mr-1"></i> {{-- Icon untuk Kategori --}}
                                {{ $title }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            {{-- Tombol Tambah Data KATEGORI --}}
                            <button wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createKategoriModal">
                                <i class="fas fa-plus mr-1"></i> Tambah Data
                            </button>
                        </div>
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-print mr-1"></i> Cetak
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item text-success" href="#">
                                    <i class="fas fa-file-excel mr-1"></i> Excel
                                </a>
                                <a class="dropdown-item text-danger" href="#">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="col-3">
                            <select wire:model.live="paginate" class="form-control" id="paginate">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col-4">
                            <input wire:model.live="search" type="text" name="search" class="form-control" placeholder="Search...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th> {{-- Kolom untuk Kategori --}}
                                    <th><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategoris as $item) {{-- Looping untuk Kategori --}}
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_kategori }}</td> {{-- Tampilkan nama_kategori --}}
                                        <td>
                                            {{-- Tombol Edit Kategori --}}
                                            <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editKategoriModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            {{-- Tombol Hapus Kategori --}}
                                            <button wire:click="deleteConfirmation({{ $item->id }})" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteKategoriModal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Data kategori tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $kategoris->links() }} {{-- Pagination untuk Kategori --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Include Modals untuk Kategori --}}
        @include('livewire.superadmin.kategori.create')
        @include('livewire.superadmin.kategori.edit')
        @include('livewire.superadmin.kategori.delete')

        {{-- JavaScript Listeners untuk Kategori Modals (pastikan SweetAlert sudah dimuat di layout utama) --}}
        @script
        <script>
            $wire.on('success', (message) => {
                Swal.fire({
                    title: "Sukses!",
                    text: message,
                    icon: "success"
                });
            });

            $wire.on('error', (message) => {
                Swal.fire({
                    title: "Gagal!",
                    text: message,
                    icon: "error"
                });
            });

            $wire.on('showCreateKategoriModal', () => {
                $('#createKategoriModal').modal('show');
            });

            $wire.on('closeCreateKategoriModal', () => {
                $('#createKategoriModal').modal('hide');
                Swal.fire({
                    title: "Sukses!",
                    text: "Data berhasil ditambahkan!",
                    icon: "success"
                });
            });

            $wire.on('showEditKategoriModal', () => {
                $('#editKategoriModal').modal('show');
            });

            $wire.on('closeEditKategoriModal', () => {
                $('#editKategoriModal').modal('hide');
                Swal.fire({
                    title: "Sukses!",
                    text: "Data berhasil diperbarui!",
                    icon: "success"
                });
            });

            $wire.on('closeDeleteKategoriModal', () => {
                $('#deleteKategoriModal').modal('hide');
                Swal.fire({
                    title: "Terhapus!",
                    text: "Data berhasil dihapus!",
                    icon: "success"
                });
            });
        </script>
        @endscript

    </div>
</div>