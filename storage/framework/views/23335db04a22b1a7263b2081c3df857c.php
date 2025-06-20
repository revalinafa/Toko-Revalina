<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-cubes mr-1"></i> <?php echo e($title); ?></h1> 
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home mr-1"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-cubes mr-1"></i> 
                                <?php echo e($title); ?>

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
                            <button wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createStokLogModal">
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
                                    <th>Produk</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $stokLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($item->produk->nama_produk ?? 'N/A'); ?></td>
                                        <td>
                                            <!--[if BLOCK]><![endif]--><?php if($item->jenis == 'masuk'): ?>
                                                <span class="badge badge-success">Masuk</span>
                                            <?php elseif($item->jenis == 'keluar'): ?>
                                                <span class="badge badge-danger">Keluar</span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </td>
                                        <td><?php echo e($item->jumlah); ?></td>
                                        <td><?php echo e($item->tanggal->format('d/m/Y')); ?></td>
                                        <td>
                                            <button wire:click="edit(<?php echo e($item->id); ?>)" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStokLogModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="deleteConfirmation(<?php echo e($item->id); ?>)" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStokLogModal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data stok log tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <?php echo e($stokLogs->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <?php echo $__env->make('livewire.superadmin.stok-log.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('livewire.superadmin.stok-log.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('livewire.superadmin.stok-log.delete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
            <?php
        $__scriptKey = '2970429032-0';
        ob_start();
    ?>
        <script>
            $wire.on('success', (message) => {
                Swal.fire({ title: "Sukses!", text: message, icon: "success" });
            });

            $wire.on('error', (message) => {
                Swal.fire({ title: "Gagal!", text: message, icon: "error" });
            });

            $wire.on('showCreateStokLogModal', () => { $('#createStokLogModal').modal('show'); });
            $wire.on('closeCreateStokLogModal', () => {
                $('#createStokLogModal').modal('hide');
                Swal.fire({ title: "Sukses!", text: "Data berhasil ditambahkan!", icon: "success" });
            });

            $wire.on('showEditStokLogModal', () => { $('#editStokLogModal').modal('show'); });
            $wire.on('closeEditStokLogModal', () => {
                $('#editStokLogModal').modal('hide');
                Swal.fire({ title: "Sukses!", text: "Data berhasil diperbarui!", icon: "success" });
            });

            $wire.on('closeDeleteStokLogModal', () => {
                $('#deleteStokLogModal').modal('hide');
                Swal.fire({ title: "Terhapus!", text: "Data berhasil dihapus!", icon: "success" });
            });
        </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    </div>
</div><?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/livewire/superadmin/stok-log/index.blade.php ENDPATH**/ ?>