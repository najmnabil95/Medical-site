<?php
  $stats = [
    ['icon' => 'users', 'value' => 200, 'suffix' => '+', 'label' => 'طبيب واستشاري', 'color' => 'from-blue-500 to-indigo-600', 'is_k' => false],
    ['icon' => 'heart-handshake', 'value' => 50, 'suffix' => 'K+', 'label' => 'مريض تم علاجه', 'color' => 'from-emerald-500 to-teal-600', 'is_k' => true],
    ['icon' => 'building-2', 'value' => 30, 'suffix' => '+', 'label' => 'قسم طبي متخصص', 'color' => 'from-purple-500 to-violet-600', 'is_k' => false],
    ['icon' => 'award', 'value' => 15, 'suffix' => '+', 'label' => 'جائزة تميز دولية', 'color' => 'from-amber-500 to-orange-600', 'is_k' => false],
    ['icon' => 'stethoscope', 'value' => 25, 'suffix' => '+', 'label' => 'سنة من الخبرة', 'color' => 'from-rose-500 to-pink-600', 'is_k' => false],
    ['icon' => 'thumbs-up', 'value' => 98, 'suffix' => '%', 'label' => 'نسبة رضا المرضى', 'color' => 'from-cyan-500 to-sky-600', 'is_k' => false],
  ];
?>

<section id="stats" class="py-24 bg-gradient-to-l from-primary-800 via-primary-900 to-gray-900 relative overflow-hidden">
  <!-- Decorative background elements -->
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-primary-400/10 rounded-full blur-3xl"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="
      background-image: radial-gradient(circle, white 1px, transparent 1px);
      background-size: 30px 30px;
    "></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="text-emerald-400 font-bold text-sm bg-emerald-500/10 px-5 py-2 rounded-full inline-block">إنجازاتنا</span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mt-5">
        أرقام تتحدث عن
        <span class="text-emerald-400"> نجاحاتنا</span>
      </h2>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-white/20 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-white/20 rounded-full"></span>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10">
      <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="text-center group stat-card" data-target="<?php echo e($stat['value']); ?>" data-isk="<?php echo e($stat['is_k'] ? 'true' : 'false'); ?>">
          <div class="w-18 h-18 bg-gradient-to-br <?php echo e($stat['color']); ?> rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 w-[72px] h-[72px]">
            <i data-lucide="<?php echo e($stat['icon']); ?>" class="text-white w-8 h-8"></i>
          </div>
          <div class="text-4xl md:text-5xl font-black text-white mb-2 tabular-nums">
            <span class="count-value">0</span>
            <span class="text-emerald-400 font-bold"><?php echo e($stat['suffix']); ?></span>
          </div>
          <div class="text-white/50 font-medium text-sm"><?php echo e($stat['label']); ?></div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const statCards = document.querySelectorAll(".stat-card");

    const animateCount = (card) => {
      const valueSpan = card.querySelector(".count-value");
      const target = parseInt(card.getAttribute("data-target"));
      const isK = card.getAttribute("data-isk") === "true";
      let currentVal = 0;
      const duration = 2000;
      const steps = 60;
      const stepTime = duration / steps;
      const increment = target / steps;

      const timer = setInterval(() => {
        currentVal += increment;
        if (currentVal >= target) {
          valueSpan.textContent = target;
          clearInterval(timer);
        } else {
          valueSpan.textContent = Math.floor(currentVal);
        }
      }, stepTime);
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    statCards.forEach((card) => {
      observer.observe(card);
    });
  });
</script>
<?php /**PATH D:\laravel-hospital-website-development\hospital-backend\resources\views/components/home/Stats.blade.php ENDPATH**/ ?>