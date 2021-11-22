<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?php echo e(asset('font/iconsmind-s/css/iconsminds.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('font/simple-line-icons/css/simple-line-icons.css')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('css/vendor/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/vendor/bootstrap.rtl.only.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/vendor/bootstrap-float-label.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>" />
</head>

<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>
    <script src="<?php echo e(asset('js/vendor/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/vendor/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dore.script.js')); ?>"></script>
    <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\project 1\wasety\resources\views/auth/app.blade.php ENDPATH**/ ?>