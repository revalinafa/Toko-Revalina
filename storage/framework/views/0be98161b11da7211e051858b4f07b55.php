<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user mr-1"></i> <?php echo e($title); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="fas fa-home mr-1"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="fas fa-user mr-1"></i> 
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
                    <button wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus mr-1"></i> Tambah Data
                    </button>
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
                        <select wire:model.live="paginate" class="form-control" id="">
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($item->name); ?></td>
                                    <td><?php echo e($item->email); ?></td>
                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($item->role == 'superadmin'): ?>
                                            <span class="badge badge-primary">Super Admin</span>
                                        <?php elseif($item->role == 'admin'): ?>
                                            <span class="badge badge-info">Admin</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <td>
                                        
                                        <button wire:click="edit(<?php echo e($item->id); ?>)" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <button wire:click="deleteConfirmation(<?php echo e($item->id); ?>)" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <?php echo e($user->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php echo $__env->make('livewire.superadmin.user.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php
        $__scriptKey = '2498294890-0';
        ob_start();
    ?>
    <script>
        $wire.on('closeCreateModal', () => {
            $('#createModal').modal('hide');
            Swal.fire({
                title: "Sukses!",
                text: "Data Berhasil Ditambah!",
                icon: "success"
            });
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

    <?php echo $__env->make('livewire.superadmin.user.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php
        $__scriptKey = '2498294890-1';
        ob_start();
    ?>
    <script>
        // Listener untuk membuka modal edit
        $wire.on('showEditModal', () => {
            $('#editModal').modal('show');
        });

        // Listener untuk menutup modal edit setelah update
        $wire.on('closeEditModal', () => {
            $('#editModal').modal('hide');
            Swal.fire({
                title: "Sukses!",
                text: "Data Berhasil Diperbarui!",
                icon: "success"
            });
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

    <?php echo $__env->make('livewire.superadmin.user.delete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php
        $__scriptKey = '2498294890-2';
        ob_start();
    ?>
    <script>
        $wire.on('closeDeleteModal', () => {
            $('#deleteModal').modal('hide');
            Swal.fire({
                title: "Terhapus!",
                text: "Data berhasil dihapus!",
                icon: "success"
            });
        });
    </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

</div><?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/livewire/superadmin/user/index.blade.php ENDPATH**/ ?>