<?php
  $heroSlides = [
    [
      'image' => 'https://images.pexels.com/photos/3845754/pexels-photo-3845754.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1100&w=1900',
      'eyebrow' => 'مسار رعاية يبدأ قبل الوصول',
      'title' => 'مستشفى الشفاء الدولي',
      'subtitle' => 'تشخيص أسرع، قرار أوضح، وطمأنينة ترافق المريض خطوة بخطوة.',
      'metric' => '12 دقيقة',
      'metricLabel' => 'متوسط فرز الحالات العاجلة',
    ],
    [
      'image' => 'https://images.pexels.com/photos/7089401/pexels-photo-7089401.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1100&w=1900',
      'eyebrow' => 'غرف عمليات مهيأة للحالات الدقيقة',
      'title' => 'رعاية تخصصية تقرأ التفاصيل',
      'subtitle' => 'فرق طبية متعددة التخصصات تعمل حول ملف موحد للحالة، من المختبر إلى غرفة الطبيب.',
      'metric' => '+200',
      'metricLabel' => 'طبيب واستشاري',
    ],
    [
      'image' => 'https://images.pexels.com/photos/4226256/pexels-photo-4226256.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1100&w=1900',
      'eyebrow' => 'متابعة رقمية بعد الزيارة',
      'title' => 'زيارة واحدة، خطة علاج كاملة',
      'subtitle' => 'المواعيد، النتائج، الوصفات، والمتابعة في تجربة واحدة واضحة للعائلة والفريق الطبي.',
      'metric' => '24/7',
      'metricLabel' => 'طوارئ ورعاية حرجة',
    ],
  ];

  $carePath = [
    ['icon' => 'phone', 'label' => 'استقبال', 'value' => 'فرز فوري'],
    ['icon' => 'stethoscope', 'label' => 'تشخيص', 'value' => 'طبيب مناسب'],
    ['icon' => 'microscope', 'label' => 'نتائج', 'value' => 'مختبر متصل'],
    ['icon' => 'heart-pulse', 'label' => 'خطة', 'value' => 'متابعة واضحة'],
  ];

  $highlights = [
    ['icon' => 'shield-check', 'title' => 'اعتمادات سلامة', 'text' => 'بروتوكولات قياس ومراجعة مستمرة'],
    ['icon' => 'activity', 'title' => 'مركز طوارئ', 'text' => 'مسارات عاجلة للحالات الحرجة'],
    ['icon' => 'map-pin', 'title' => 'موقع مركزي', 'text' => 'وصول سريع من أحياء الرياض'],
  ];
?>

<section id="home" class="relative min-h-[82svh] overflow-hidden bg-[#081f24] text-white">
  <!-- Slides Container -->
  <div id="hero-slides-wrapper">
    <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div
        class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>"
        data-slide-index="<?php echo e($index); ?>"
      >
        <img src="<?php echo e($slide['image']); ?>" alt="فريق طبي داخل مستشفى الشفاء" class="h-full w-full object-cover" />
        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(8,31,36,0.97)_0%,rgba(8,31,36,0.86)_36%,rgba(15,118,110,0.54)_68%,rgba(246,113,91,0.18)_100%)]"></div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- Background Grid -->
  <div
    class="absolute inset-0 opacity-[0.16]"
    style="
      background-image: linear-gradient(rgba(255,255,255,.24) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.18) 1px, transparent 1px);
      background-size: 72px 72px;
    "
  ></div>
  <div class="absolute inset-x-0 bottom-0 h-24 bg-[linear-gradient(0deg,#ffffff_0%,rgba(255,255,255,0)_100%)]"></div>

  <!-- Content -->
  <div class="relative mx-auto grid max-w-7xl gap-10 px-4 pb-20 pt-14 lg:grid-cols-[1.08fr_.92fr] lg:pb-24 lg:pt-20">
    <div class="flex flex-col justify-center">
      <!-- Dynamic Slide Content -->
      <div id="hero-content-area" class="max-w-3xl min-h-[220px]">
        <div class="mb-5 inline-flex items-center gap-3 rounded-[8px] border border-white/15 bg-white/10 px-4 py-2 text-sm font-bold backdrop-blur-md">
          <span class="h-2 w-2 rounded-full bg-[#f6715b]"></span>
          <span id="hero-slide-eyebrow"><?php echo e($heroSlides[0]['eyebrow']); ?></span>
        </div>

        <h1 id="hero-slide-title" class="text-4xl font-black leading-[1.15] md:text-6xl lg:text-7xl">
          <?php echo e($heroSlides[0]['title']); ?>

        </h1>

        <p id="hero-slide-subtitle" class="mt-6 max-w-2xl text-lg leading-8 text-white/80 md:text-xl">
          <?php echo e($heroSlides[0]['subtitle']); ?>

        </p>
      </div>

      <div class="mt-8 flex flex-wrap gap-3 z-20">
        <a
          href="#appointment"
          onclick="event.preventDefault(); document.getElementById('appointment').scrollIntoView({behavior: 'smooth'});"
          class="group inline-flex items-center gap-3 rounded-[8px] bg-[#f6715b] px-6 py-4 text-base font-black text-white shadow-lg shadow-[#f6715b]/20 transition hover:-translate-y-0.5 hover:bg-[#ff806d]"
        >
          <i data-lucide="calendar" class="w-[21px] h-[21px]"></i>
          <span>احجز موعدك</span>
          <i data-lucide="arrow-left" class="w-[18px] h-[18px] transition group-hover:-translate-x-1"></i>
        </a>
        <a
          href="tel:<?php echo e($settings->emergency ?? '920012345'); ?>"
          class="inline-flex items-center gap-3 rounded-[8px] border border-white/20 bg-white/10 px-6 py-4 text-base font-black text-white backdrop-blur-md transition hover:-translate-y-0.5 hover:bg-white/20"
        >
          <i data-lucide="phone" class="w-[21px] h-[21px]"></i>
          <span>الطوارئ <?php echo e($settings->emergency ?? '920012345'); ?></span>
        </a>
      </div>

      <!-- Care Path -->
      <div class="mt-10 grid max-w-3xl grid-cols-2 gap-3 md:grid-cols-4 z-20">
        <?php $__currentLoopData = $carePath; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="rounded-[8px] border border-white/10 bg-white/[0.08] p-4 backdrop-blur-md">
            <div class="mb-4 flex items-center justify-between">
              <i data-lucide="<?php echo e($item['icon']); ?>" class="text-[#76e4d2] w-5 h-5"></i>
              <span class="font-mono text-xs text-white/30">0<?php echo e($index + 1); ?></span>
            </div>
            <p class="text-sm font-black"><?php echo e($item['label']); ?></p>
            <p class="mt-1 text-xs text-white/50"><?php echo e($item['value']); ?></p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    <!-- Live stats dashboard right card -->
    <div class="relative flex items-center lg:justify-end z-20">
      <div class="w-full max-w-[520px] rounded-[8px] border border-white/10 bg-[#07181d]/70 p-4 shadow-2xl shadow-black/35 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-white/10 pb-4">
          <div>
            <p class="text-sm font-bold text-[#76e4d2]">مؤشر التشغيل الآن</p>
            <p class="text-xs text-white/40">تحديث مباشر لمسار المريض</p>
          </div>
          <div class="inline-flex items-center gap-2 rounded-[8px] bg-emerald-400/10 px-3 py-2 text-xs font-black text-emerald-200">
            <i data-lucide="timer" class="w-3.5 h-3.5"></i>
            متاح
          </div>
        </div>

        <div class="grid gap-3 py-4">
          <?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="grid grid-cols-[44px_1fr] gap-4 rounded-[8px] bg-white/[0.06] p-4">
              <div class="flex h-11 w-11 items-center justify-center rounded-[8px] bg-white text-[#0f766e]">
                <i data-lucide="<?php echo e($item['icon']); ?>" class="w-[22px] h-[22px]"></i>
              </div>
              <div>
                <h3 class="font-black"><?php echo e($item['title']); ?></h3>
                <p class="mt-1 text-sm leading-6 text-white/50"><?php echo e($item['text']); ?></p>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Metric Card -->
        <div class="grid grid-cols-[1fr_auto] items-end gap-4 rounded-[8px] bg-[#f8faf7] p-4 text-[#102a2d]">
          <div>
            <p class="text-xs font-bold text-[#0f766e]">قراءة الشريحة الحالية</p>
            <p id="hero-slide-metric" class="mt-2 text-4xl font-black"><?php echo e($heroSlides[0]['metric']); ?></p>
            <p id="hero-slide-metric-label" class="mt-1 text-sm text-slate-600"><?php echo e($heroSlides[0]['metricLabel']); ?></p>
          </div>
          <i data-lucide="heart-pulse" class="w-10 h-10 text-[#f6715b]"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Sliders Navigation dot controls -->
  <div class="absolute bottom-8 left-1/2 z-30 flex -translate-x-1/2 items-center gap-3">
    <button
      onclick="prevHeroSlide()"
      class="flex h-11 w-11 items-center justify-center rounded-[8px] border border-white/20 bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20"
      aria-label="الشريحة السابقة"
    >
      <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>
    <div class="flex items-center gap-2">
      <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button
          onclick="goToHeroSlide(<?php echo e($index); ?>)"
          class="hero-dot-indicator h-2.5 rounded-full transition-all <?php echo e($index === 0 ? 'w-10 bg-[#f6715b]' : 'w-2.5 bg-white/30 hover:bg-white/60'); ?>"
          data-dot-index="<?php echo e($index); ?>"
          aria-label="انتقل إلى الشريحة <?php echo e($index + 1); ?>"
        ></button>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <button
      onclick="nextHeroSlide()"
      class="flex h-11 w-11 items-center justify-center rounded-[8px] border border-white/20 bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20"
      aria-label="الشريحة التالية"
    >
      <i data-lucide="chevron-left" class="w-5 h-5"></i>
    </button>
  </div>
</section>

<script>
  const heroSlidesData = <?php echo json_encode($heroSlides, 15, 512) ?>;
  let currentHeroIndex = 0;
  let heroInterval = null;

  function updateHeroUI() {
    // Update active slide class
    const slides = document.querySelectorAll('.hero-slide');
    slides.forEach((slide, idx) => {
      if (idx === currentHeroIndex) {
        slide.classList.remove('opacity-0', 'z-0');
        slide.classList.add('opacity-100', 'z-10');
      } else {
        slide.classList.remove('opacity-100', 'z-10');
        slide.classList.add('opacity-0', 'z-0');
      }
    });

    // Update active dot indicators
    const dots = document.querySelectorAll('.hero-dot-indicator');
    dots.forEach((dot, idx) => {
      if (idx === currentHeroIndex) {
        dot.classList.remove('w-2.5', 'bg-white/30');
        dot.classList.add('w-10', 'bg-[#f6715b]');
      } else {
        dot.classList.remove('w-10', 'bg-[#f6715b]');
        dot.classList.add('w-2.5', 'bg-white/30');
      }
    });

    // Animate and update text content
    const eyebrow = document.getElementById('hero-slide-eyebrow');
    const title = document.getElementById('hero-slide-title');
    const subtitle = document.getElementById('hero-slide-subtitle');
    const metric = document.getElementById('hero-slide-metric');
    const metricLabel = document.getElementById('hero-slide-metric-label');

    const contentArea = document.getElementById('hero-content-area');
    contentArea.classList.remove('animate-fade-in-up');
    void contentArea.offsetWidth; // Trigger reflow to restart animation
    contentArea.classList.add('animate-fade-in-up');

    const activeData = heroSlidesData[currentHeroIndex];
    eyebrow.textContent = activeData.eyebrow;
    title.textContent = activeData.title;
    subtitle.textContent = activeData.subtitle;
    metric.textContent = activeData.metric;
    metricLabel.textContent = activeData.metricLabel;
  }

  function nextHeroSlide() {
    currentHeroIndex = (currentHeroIndex + 1) % heroSlidesData.length;
    updateHeroUI();
  }

  function prevHeroSlide() {
    currentHeroIndex = (currentHeroIndex - 1 + heroSlidesData.length) % heroSlidesData.length;
    updateHeroUI();
  }

  function goToHeroSlide(index) {
    currentHeroIndex = index;
    updateHeroUI();
    resetHeroTimer();
  }

  function resetHeroTimer() {
    if (heroInterval) clearInterval(heroInterval);
    heroInterval = setInterval(nextHeroSlide, 6500);
  }

  document.addEventListener("DOMContentLoaded", () => {
    resetHeroTimer();
  });
</script>
<?php /**PATH D:\laravel-hospital-website-development\resources\views\components\home\Hero.blade.php ENDPATH**/ ?>