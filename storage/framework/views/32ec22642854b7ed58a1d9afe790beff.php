<?php $__env->startSection('title'); ?>
    <?php echo e($settings->site_name ?? 'مستشفى الشفاء الدولي'); ?> | <?php echo e($settings->site_name_en ?? 'Al-Shifa International Hospital'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Alert Success Notification if any -->
    <?php if(session('success')): ?>
        <div role="alert-flash" class="fixed bottom-6 left-6 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-3 px-6 rounded-xl shadow-2xl z-[99999] transition-all duration-300 transform scale-100 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <!-- Dynamic Screens Loop -->
    <?php $__currentLoopData = $screens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $screen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($screen->component !== 'NewsTicker'): ?>
            <?php if ($__env->exists('components.home.' . $screen->component)) echo $__env->make('components.home.' . $screen->component, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\home.blade.php ENDPATH**/ ?>