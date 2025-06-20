<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>H1D023011 | Revalina Fidiya</title>

  <?php echo $__env->make('layouts.style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
 
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo e($slot); ?>

  
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>


<?php echo $__env->make('layouts.script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/layouts/app.blade.php ENDPATH**/ ?>