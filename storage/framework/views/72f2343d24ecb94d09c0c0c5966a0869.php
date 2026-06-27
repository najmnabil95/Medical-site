<?php
  $newsItems = [
    "🎉 مستشفى الشفاء يحصل على اعتماد JCI للمرة الثالثة",
    "📢 افتتاح قسم جراحة القلب بالروبوت الجراحي",
    "🏆 جائزة أفضل مستشفى في المنطقة لعام 2024",
    "💉 حملة التطعيم المجانية متاحة الآن",
    "⭐ نسبة رضا المرضى تصل إلى 98%",
    "🔬 تدشين أحدث جهاز رنين مغناطيسي 3 تسلا",
  ];
?>

<div class="bg-gradient-to-l from-emerald-600 to-emerald-500 text-white py-2.5 overflow-hidden relative">
  <div class="flex items-center">
    <!-- Label -->
    <div class="bg-white/20 px-4 py-1 flex items-center gap-2 shrink-0 z-10 backdrop-blur-sm">
      <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
      <span class="text-xs font-bold whitespace-nowrap">آخر الأخبار</span>
    </div>

    <!-- Scrolling Text -->
    <div class="flex animate-marquee whitespace-nowrap">
      <?php $__currentLoopData = array_merge($newsItems, $newsItems); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="mx-8 text-sm font-medium">
          <?php echo e($item); ?>

        </span>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>
<?php /**PATH D:\laravel-hospital-website-development\resources\views/components/home/NewsTicker.blade.php ENDPATH**/ ?>