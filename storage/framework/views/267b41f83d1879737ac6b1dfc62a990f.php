<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> <i class="fas fa-box mr-1"></i>
                            <?php echo e($title); ?>

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
                                <?php echo e($title); ?></li>
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
                            <button wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createProdukModal">
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
                    
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        
                        <div class="col-2 pl-0">
                            <select wire:model.live="paginate" class="form-control" id="paginate">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        
                        <div class="col-3">
                            <select wire:model.live="filterKategoriId" class="form-control">
                                <option value="">Semua Kategori</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($kategori->id); ?>"><?php echo e($kategori->nama_kategori); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>

                        
                        <div class="col-3">
                            <select wire:model.live="filterSupplierId" class="form-control">
                                <option value="">Semua Supplier</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->nama_supplier); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>

                        
                        <div class="col-4 pr-0">
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
                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($item->nama_produk); ?></td>
                                        <td>Rp <?php echo e(number_format($item->harga, 0, ',', '.')); ?></td>
                                        <td><?php echo e($item->stok); ?></td>
                                        <td><?php echo e($item->kategori->nama_kategori ?? 'N/A'); ?></td>
                                        <td><?php echo e($item->supplier->nama_supplier ?? 'N/A'); ?></td>
                                        <td>
                                            <button wire:click="edit(<?php echo e($item->id); ?>)" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editProdukModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="deleteConfirmation(<?php echo e($item->id); ?>)" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProdukModal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Data produk tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <?php echo e($produks->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <?php echo $__env->make('livewire.superadmin.produk.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('livewire.superadmin.produk.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('livewire.superadmin.produk.delete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
            <?php
        $__scriptKey = '3935592984-0';
        ob_start();
    ?>
        <script>
            $wire.on('success', (message) => {
                Swal.fire({ title: "Sukses!", text: message, icon: "success" });
            });

            $wire.on('error', (message) => {
                Swal.fire({ title: "Gagal!", text: message, icon: "error" });
            });

            $wire.on('showCreateProdukModal', () => { $('#createProdukModal').modal('show'); });
            $wire.on('closeCreateProdukModal', () => {
                $('#createProdukModal').modal('hide');
                Swal.fire({ title: "Sukses!", text: "Data berhasil ditambahkan!", icon: "success" });
            });

            $wire.on('showEditProdukModal', () => { $('#editProdukModal').modal('show'); });
            $wire.on('closeEditProdukModal', () => {
                $('#editProdukModal').modal('hide');
                Swal.fire({ title: "Sukses!", text: "Data berhasil diperbarui!", icon: "success" });
            });

            $wire.on('closeDeleteProdukModal', () => {
                $('#deleteProdukModal').modal('hide');
                Swal.fire({ title: "Terhapus!", text: "Data berhasil dihapus!", icon: "success" });
            });
        </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

    </div>
</div><?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/livewire/superadmin/produk/index.blade.php ENDPATH**/ ?>