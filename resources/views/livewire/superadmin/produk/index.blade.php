<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> <i class="fas fa-box mr-1"></i>
                            {{ $title }}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">
                                <i class="fas fa-home mr-1"></i>
                                Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-box mr-1"></i>
                                {{ $title }}</li>
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
                            {{-- Tombol Tambah Produk --}}
                            <button wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createProdukModal">
                                <i class="fas fa-plus mr-1"></i>
                                Tambah Data
                            </button>
                        </div>
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-print mr-1"></i>
                                Cetak
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item text-success" href="#">
                                    <i class="fas fa-file-excel mr-1"></i>
                                    Excel</a>
                                    <a class="dropdown-item text-danger" href="#">
                                    <i class="fas fa-file-pdf mr-1"></i>
                                    PDF</a>
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
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th>
                                    <th><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_produk }}</td>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>{{ $item->kategori->nama_kategori ?? 'N/A' }}</td> {{-- Pastikan nama kolom kategori benar --}}
                                        <td>{{ $item->supplier->nama_supplier ?? 'N/A' }}</td> {{-- Pastikan nama kolom supplier benar --}}
                                        <td>
                                            {{-- Tombol Edit --}}
                                            <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editProdukModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            {{-- Tombol Hapus --}}
                                            <button wire:click="deleteConfirmation({{ $item->id }})" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProdukModal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data produk tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $produks->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>

    {{-- Include Modals --}}
    @include('livewire.superadmin.produk.create')
    @include('livewire.superadmin.produk.edit')
    @include('livewire.superadmin.produk.delete')

    {{-- SweetAlert & Modal JavaScript Listeners --}}
    @script
    <script>
        // Listener untuk SweetAlert Success
        $wire.on('success', (message) => {
            Swal.fire({
                title: "Sukses!",
                text: message,
                icon: "success"
            });
        });

        // Listener untuk SweetAlert Error
        $wire.on('error', (message) => {
            Swal.fire({
                title: "Gagal!",
                text: message,
                icon: "error"
            });
        });

        // Listener untuk membuka modal Create
        $wire.on('showCreateModal', () => {
            $('#createProdukModal').modal('show');
        });

        // Listener untuk menutup modal Create
        $wire.on('closeCreateModal', () => {
            $('#createProdukModal').modal('hide');
        });

        // Listener untuk membuka modal Edit
        $wire.on('showEditModal', () => {
            $('#editProdukModal').modal('show');
        });

        // Listener untuk menutup modal Edit
        $wire.on('closeEditModal', () => {
            $('#editProdukModal').modal('hide');
        });

        // Listener untuk menutup modal Delete
        $wire.on('closeDeleteModal', () => {
            $('#deleteProdukModal').modal('hide');
        });
    </script>
    @endscript

</div>