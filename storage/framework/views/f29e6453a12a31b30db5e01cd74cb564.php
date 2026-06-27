<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#0f766e">
    <title>مستشفى الشفاء الدولي | Al-Shifa International Hospital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')('src/main.tsx'); ?>
  </head>
  <body>
    <div id="root"></div>
  </body>
</html>
<?php /**PATH D:\laravel-hospital-website-development\hospital-backend\resources\views/app.blade.php ENDPATH**/ ?>