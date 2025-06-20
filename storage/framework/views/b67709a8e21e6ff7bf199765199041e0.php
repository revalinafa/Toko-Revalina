<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>H1D023011 | <?php echo $__env->yieldContent('title', 'Login / Register'); ?></title>

    
    <link rel="stylesheet" href="<?php echo e(asset('adminlte3/plugins/fontawesome-free/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('adminlte3/dist/css/adminlte.min.css')); ?>">
    
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="hold-transition login-page"> 

    
    <?php echo e($slot); ?>


    
    <script src="<?php echo e(asset('adminlte3/plugins/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('adminlte3/dist/js/adminlte.min.js')); ?>"></script>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH D:\laragon\www\Toko-Revalina\resources\views/layouts/auth.blade.php ENDPATH**/ ?>