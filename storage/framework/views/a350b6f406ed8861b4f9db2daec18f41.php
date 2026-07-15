<?php
$defaultColors = [
['color' => 'from-emerald-500 to-teal-600', 'lightColor' => 'bg-emerald-50 text-emerald-600'],
['color' => 'from-teal-500 to-cyan-600', 'lightColor' => 'bg-teal-50 text-teal-600'],
['color' => 'from-cyan-500 to-sky-600', 'lightColor' => 'bg-cyan-50 text-cyan-600'],
['color' => 'from-sky-500 to-blue-600', 'lightColor' => 'bg-sky-50 text-sky-600'],
['color' => 'from-blue-500 to-indigo-600', 'lightColor' => 'bg-blue-50 text-blue-600'],
];

$colorMap = [
'blue' => ['color' => 'from-blue-500 to-indigo-600', 'lightColor' => 'bg-blue-50 text-blue-600'],
'emerald' => ['color' => 'from-emerald-500 to-teal-600', 'lightColor' => 'bg-emerald-50 text-emerald-600'],
'purple' => ['color' => 'from-purple-500 to-violet-600', 'lightColor' => 'bg-purple-50 text-purple-600'],
'amber' => ['color' => 'from-amber-500 to-orange-600', 'lightColor' => 'bg-amber-50 text-amber-600'],
'rose' => ['color' => 'from-rose-500 to-pink-600', 'lightColor' => 'bg-rose-50 text-rose-600'],
'indigo' => ['color' => 'from-indigo-500 to-purple-600', 'lightColor' => 'bg-indigo-50 text-indigo-600'],
'from-red-500 to-rose-600' => ['color' => 'from-red-500 to-rose-600', 'lightColor' => 'bg-rose-50 text-rose-600'],
'from-purple-500 to-violet-600' => ['color' => 'from-purple-500 to-violet-600', 'lightColor' => 'bg-purple-50 text-purple-600'],
'from-amber-500 to-orange-600' => ['color' => 'from-amber-500 to-orange-600', 'lightColor' => 'bg-amber-50 text-amber-600'],
'from-pink-500 to-rose-600' => ['color' => 'from-pink-500 to-rose-600', 'lightColor' => 'bg-rose-50 text-rose-600'],
'from-cyan-500 to-teal-600' => ['color' => 'from-cyan-500 to-teal-600', 'lightColor' => 'bg-cyan-50 text-cyan-600'],
'from-blue-500 to-indigo-600' => ['color' => 'from-blue-500 to-indigo-600', 'lightColor' => 'bg-blue-50 text-blue-600'],
];

$dummyServices = [
"تشخيص دقيق بأحدث التقنيات",
"علاج متقدم وفعال",
"متابعة مستمرة بعد العلاج",
"رعاية إنسانية متميزة",
"فريق طبي متخصص",
"أحدث الأجهزة الطبية",
];
?>

<section id="departments" class="py-24 bg-gray-50 relative overflow-hidden scroll-mt-32">
  <!-- Decoration shape -->
  <div class="absolute bottom-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">

    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-600 bg-emerald-500/10">
        أقسامنا الطبية
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        تخصصات طبية
        <span class="text-emerald-600"> متكاملة</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        نقدم مجموعة شاملة من التخصصات الطبية لتلبية جميع احتياجاتكم الصحية تحت سقف واحد
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-slate-300 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-slate-300 rounded-full"></span>
      </div>
    </div>

    <!-- Departments Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 animate-fade-in-up">
      <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
      $colors = $defaultColors[$index % count($defaultColors)];
      $mapped = $colorMap[$dept->color] ?? null;
      $deptColor = $mapped['color'] ?? ($dept->color ?? $colors['color']);
      $deptLightColor = $mapped['lightColor'] ?? $colors['lightColor'];
      $icon = strtolower($dept->icon ?? 'heart');
      ?>

      <div
        data-dept-id="<?php echo e($dept->id); ?>"
        data-delay="<?php echo e($index * 80); ?>"
        class="department-card group bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 cursor-pointer relative overflow-hidden">
        <!-- Hover background -->
        <div class="absolute inset-0 bg-linear-to-br <?php echo e($deptColor); ?> opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

        <div class="relative">
          <div class="w-14 h-14 <?php echo e($deptLightColor); ?> group-hover:bg-white/20 rounded-2xl flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
            <i data-lucide="<?php echo e($icon); ?>" class="group-hover:text-white transition-colors w-[26px] h-[26px]"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-white transition-colors">
            <?php echo e($dept->name); ?>

          </h3>
          <p class="text-gray-500 text-sm leading-relaxed group-hover:text-white/80 transition-colors line-clamp-3">
            <?php echo e($dept->desc); ?>

          </p>
          <div class="mt-4 flex items-center gap-2 text-primary-600 group-hover:text-white text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0">
            <span>اكتشف القسم</span>
            <span>←</span>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($departments->isEmpty()): ?>
    <div class="text-center py-16">
      <p class="text-gray-400 text-lg">لا توجد أقسام متاحة حالياً</p>
    </div>
    <?php endif; ?>
  </div>
</section>


<?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$colors = $defaultColors[$index % count($defaultColors)];
$mapped = $colorMap[$dept->color] ?? null;
$deptColor = $mapped['color'] ?? ($dept->color ?? $colors['color']);
$icon = strtolower($dept->icon ?? 'heart');
$modalId = 'dept-modal-' . $dept->id;
$closeModalData = 'data-close-modal="' . $dept->id . '"';
$deptNameEscaped = str_replace("'", "\\'", $dept->name);
?>

<div id="<?php echo e($modalId); ?>" class="fixed inset-0 z-9999 items-center justify-center p-4" style="display: none;">
  
  <div class="fixed inset-0 bg-black/75" <?php echo $closeModalData; ?>></div>
  <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto z-10" style="animation: deptModalIn 0.25s ease-out;">
    <!-- Header -->
    <div class="relative h-48 bg-linear-to-br <?php echo e($deptColor); ?> overflow-hidden">
      <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 25px 25px;"></div>
      <button
        <?php echo $closeModalData; ?>

        class="absolute top-4 left-4 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
      <div class="absolute bottom-6 right-6 text-white">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
            <i data-lucide="<?php echo e($icon); ?>" class="text-white w-7 h-7"></i>
          </div>
          <div>
            <p class="text-white/70 text-xs">قسم طبي</p>
            <h2 class="text-3xl font-black"><?php echo e($dept->name); ?></h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="p-8 grid md:grid-cols-3 gap-8 text-gray-700">
      <!-- Main Info -->
      <div class="md:col-span-2 space-y-6">
        <div>
          <h3 class="text-lg font-bold text-gray-800 mb-3">نبذة عن القسم</h3>
          <p class="text-gray-600 leading-relaxed"><?php echo e($dept->desc); ?></p>
        </div>

        <!-- Services list -->
        <div>
          <h3 class="text-lg font-bold text-gray-800 mb-4">خدماتنا في هذا القسم</h3>
          <div class="grid grid-cols-2 gap-3">
            <?php $__currentLoopData = $dummyServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center gap-2 bg-gray-50 rounded-xl p-3">
              <i data-lucide="check-circle" class="text-emerald-500 w-4 h-4 shrink-0"></i>
              <span class="text-sm text-gray-700"><?php echo e($serv); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        <!-- Department Stats -->
        <div class="grid grid-cols-3 gap-3">
          <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
            <i data-lucide="users" class="text-emerald-500 mx-auto mb-2 w-5.5 h-5.5"></i>
            <div class="text-xl font-black text-slate-800">+2K</div>
            <div class="text-xs text-gray-500">مريض/سنة</div>
          </div>
          <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
            <i data-lucide="award" class="text-emerald-500 mx-auto mb-2 w-5.5 h-5.5"></i>
            <div class="text-xl font-black text-slate-800">98%</div>
            <div class="text-xs text-gray-500">نسبة النجاح</div>
          </div>
          <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
            <i data-lucide="activity" class="text-emerald-500 mx-auto mb-2 w-5.5 h-5.5"></i>
            <div class="text-xl font-black text-slate-800">24/7</div>
            <div class="text-xs text-gray-500">خدمة مستمرة</div>
          </div>
        </div>
      </div>

      <!-- Sidebar: Doctors of this Department -->
      <div class="space-y-4">
        <h3 class="text-lg font-bold text-gray-800">أطباؤنا المتخصصون</h3>

        <?php
        $deptDoctors = $doctors->where('department', $dept->name);
        ?>

        <?php if($deptDoctors->isNotEmpty()): ?>
        <p class="text-xs text-gray-500 mb-2">
          <?php echo e($deptDoctors->count()); ?> طبيب في هذا القسم
        </p>
        <div class="space-y-3">
          <?php $__currentLoopData = $deptDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="bg-white rounded-2xl border border-gray-100 p-4 hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-2">
              <img src="<?php echo e($doc->image); ?>" alt="<?php echo e($doc->name); ?>" class="w-12 h-12 rounded-xl object-cover" />
              <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-800 text-sm truncate"><?php echo e($doc->name); ?></p>
                <div class="flex items-center gap-1 mt-0.5">
                  <i data-lucide="star" class="text-yellow-500 fill-current w-3 h-3"></i>
                  <span class="text-xs text-gray-500"><?php echo e($doc->rating); ?></span>
                </div>
              </div>
            </div>
            <p class="text-xs text-gray-500 truncate mb-2"><?php echo e($doc->specialty); ?></p>
            <button
              data-book-dept="<?php echo e($dept->name); ?>"
              data-book-doc="<?php echo e($doc->name); ?>"
              class="book-appointment-btn w-full bg-emerald-50 text-emerald-600 py-2 rounded-lg text-xs font-bold hover:bg-emerald-100 transition-colors flex items-center justify-center gap-1">
              <i data-lucide="clock" class="w-3.5 h-3.5"></i>
              <span>احجز موعداً</span>
            </button>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="bg-gray-50 rounded-2xl p-6 text-center">
          <i data-lucide="stethoscope" class="text-gray-300 mx-auto mb-3 w-10 h-10"></i>
          <p class="text-gray-500 text-sm">لا يوجد أطباء حالياً</p>
          <p class="text-xs text-gray-400 mt-2 font-medium">يمكنك الحجز العام وسنتواصل معك لاختيار الطبيب</p>
        </div>
        <?php endif; ?>

        <button
          data-book-dept="<?php echo e($dept->name); ?>"
          data-book-doc=""
          class="book-appointment-btn w-full bg-emerald-600 text-white py-4 rounded-2xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
          <span>احجز موعد الآن</span>
          <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </button>

        <a
          href="tel:<?php echo e($settings->emergency ?? '920012345'); ?>"
          class="w-full bg-slate-100 text-slate-700 py-3 rounded-2xl font-bold hover:bg-slate-200 transition-colors flex items-center justify-center gap-2 text-sm">
          <span>📞 للاستفسار: <?php echo e($settings->emergency ?? '920012345'); ?></span>
        </a>
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
  @keyframes deptModalIn {
    from {
      opacity: 0;
      transform: scale(0.95) translateY(10px);
    }

    to {
      opacity: 1;
      transform: scale(1) translateY(0);
    }
  }
</style><?php /**PATH D:\laravel-hospital-website-development\resources\views\components\home\Departments.blade.php ENDPATH**/ ?>