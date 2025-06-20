 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(asset ('#')); ?>" class="brand-link">
      <img src="<?php echo e(asset ('adminlte3/dist/img/AdminLTELogo.png')); ?>" alt="AdminLTE Logo" class="brand-image img-circle " >
      <span class="brand-text font-weight-light"> Toko Revalina</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">MENU SUPER ADMIN</li>
          <li class="nav-item">
            <a href="<?php echo e(route('superadmin.user.index')); ?>" class="nav-link <?php echo $__env->yieldContent('menuSuperadminUser'); ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('superadmin.produk.index')); ?>" class="nav-link <?php echo $__env->yieldContent('menuSuperadminProduk'); ?>">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Produk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('superadmin.kategori.index')); ?>" class="nav-link <?php echo $__env->yieldContent('menuSuperadminKategori'); ?>">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Kategori
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('superadmin.supplier.index')); ?>" class="nav-link <?php echo $__env->yieldContent('menuSuperadminSupplier'); ?>">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Supplier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('superadmin.penjualan.index')); ?>" class="nav-link <?php echo $__env->yieldContent('menuSuperadminPenjualan'); ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Penjualan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo e(route('superadmin.stok_log.index')); ?>" class="nav-link <?php echo $__env->yieldContent('menuSuperadminStock'); ?>">
              <i class="nav-icon fas fa-paste"></i>
              <p>
                Stok Barang
              </p>
            </a>
          </li>
              <li class="nav-item">
        <a href="<?php echo e(route('superadmin.laporan.harian')); ?>" class="nav-link <?php echo e(request()->routeIs('superadmin.laporan.harian') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Laporan Harian</p>
        </a>
          </li>
          <li class="nav-header">MENU ADMIN</li>
            <li class="nav-item">
                <a href="3" class="nav-link">
                    <i class="nav-icon fas fa-paste"></i>
                    <p>
                        Produk
                    </p>
                </a>
             </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside><?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>