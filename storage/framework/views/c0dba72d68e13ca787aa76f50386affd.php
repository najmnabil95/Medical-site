<?php $__env->startSection('title', 'ممنوع الوصول 403'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-[80vh] flex items-center justify-center py-20 relative overflow-hidden">
  
  <div class="absolute inset-0 bg-linear-to-br from-rose-50 via-white to-orange-50"></div>
  <div class="absolute top-20 right-20 w-72 h-72 bg-rose-100/40 rounded-full blur-3xl animate-pulse"></div>
  <div class="absolute bottom-20 left-20 w-96 h-96 bg-orange-100/30 rounded-full blur-3xl"></div>

  <div class="relative text-center px-6 max-w-xl mx-auto">
    
    <div class="relative inline-block mb-8">
      <div class="w-32 h-32 bg-linear-to-br from-rose-500 to-red-600 rounded-3xl rotate-12 flex items-center justify-center shadow-2xl shadow-rose-500/30 mx-auto transform hover:rotate-0 transition-transform duration-500">
        <i data-lucide="shield-off" class="w-16 h-16 text-white -rotate-12"></i>
      </div>
      <div class="absolute -top-2 -right-2 w-8 h-8 bg-amber-400 rounded-full flex items-center justify-center text-white font-black text-sm shadow-lg animate-bounce">
        !
      </div>
    </div>

    
    <h1 class="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-linear-to-l from-rose-500 to-red-600 leading-none mb-4">
      403
    </h1>

    
    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-4">
      ممنوع الوصول
    </h2>

    
    <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-md mx-auto">
      عذراً، ليس لديك صلاحية للوصول إلى هذه الصفحة.
      <br>
      يرجى التواصل مع مدير النظام إذا كنت تعتقد أن هذا خطأ.
    </p>

    
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
      <a href="/"
        class="inline-flex items-center gap-2.5 px-7 py-3.5 bg-linear-to-l from-rose-500 to-red-600 text-white rounded-2xl font-bold text-sm hover:shadow-xl hover:shadow-rose-500/30 transition-all hover:-translate-y-1 group">
        <i data-lucide="home" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
        <span>العودة للصفحة الرئيسية</span>
      </a>
      <a href="javascript:history.back()"
        class="inline-flex items-center gap-2 px-7 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold text-sm hover:bg-gray-50 hover:border-gray-300 hover:shadow-md transition-all group">
        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
        <span>الرجوع للخلف</span>
      </a>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\errors\403.blade.php ENDPATH**/ ?>