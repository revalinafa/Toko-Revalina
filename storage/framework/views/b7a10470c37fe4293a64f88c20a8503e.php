<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-chart-line mr-1"></i> <?php echo e($title); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home mr-1"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-chart-line mr-1"></i> <?php echo e($title); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Laporan Harian: <?php echo e($currentDate); ?></h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="selectedDate" class="col-sm-2 col-form-label">Pilih Tanggal:</label>
                        <div class="col-sm-4">
                            <input wire:model.live="selectedDate" type="date" class="form-control" id="selectedDate">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Nilai Penjualan Harian</span>
                                    <span class="info-box-number">Rp <?php echo e(number_format($totalNilaiPenjualan, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            
                             <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jumlah Produk</span>
                                    <span class="info-box-number"><?php echo e($stokProduk->count()); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Stok Tersisa per Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Stok Tersisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $stokProduk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($produk->nama_produk); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo e($produk->stok <= 5 ? 'danger' : ($produk->stok <= 20 ? 'warning' : 'success')); ?>">
                                                <?php echo e($produk->stok); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data produk.</td>
                                    </tr>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div><?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/livewire/superadmin/laporan/harian.blade.php ENDPATH**/ ?>