<?php
  $heroSlides = [
    [
      'image' => !empty($settings->hero_image_1) ? $settings->hero_image_1 : 'https://images.pexels.com/photos/3845754/pexels-photo-3845754.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1100&w=1900',
      'eyebrow' => 'مسار رعاية يبدأ قبل الوصول',
      'title' => $settings->site_name ?? 'مستشفى الشفاء الدولي',
      'subtitle' => 'تشخيص أسرع، قرار أوضح، وطمأنينة ترافق المريض خطوة بخطوة.',
      'metric' => '12 دقيقة',
      'metricLabel' => 'متوسط فرز الحالات العاجلة',
    ],
    [
      'image' => !empty($settings->hero_image_2) ? $settings->hero_image_2 : 'https://images.pexels.com/photos/7089401/pexels-photo-7089401.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1100&w=1900',
      'eyebrow' => 'غرف عمليات مهيأة للحالات الدقيقة',
      'title' => 'رعاية تخصصية تقرأ التفاصيل',
      'subtitle' => 'فرق طبية متعددة التخصصات تعمل حول ملف موحد للحالة، من المختبر إلى غرفة الطبيب.',
      'metric' => '+200',
      'metricLabel' => 'طبيب واستشاري',
    ],
    [
      'image' => !empty($settings->hero_image_3) ? $settings->hero_image_3 : 'https://images.pexels.com/photos/4226256/pexels-photo-4226256.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1100&w=1900',
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
?>

<section id="home" class="relative min-h-[82svh] overflow-hidden bg-slate-50 text-slate-900 flex items-center">
  <!-- Full Screen Slides Container -->
  <div id="hero-slides-wrapper" class="absolute inset-0 z-0">
    <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div
        class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>"
        data-slide-index="<?php echo e($index); ?>"
      >
        <img src="<?php echo e($slide['image']); ?>" alt="فريق طبي داخل مستشفى الشفاء" class="h-full w-full object-cover" />
        <!-- Soft light gradient overlay for readability -->
        <div class="absolute inset-0 bg-[linear-gradient(270deg,rgba(248,250,252,0.95)_0%,rgba(248,250,252,0.8)_50%,rgba(248,250,252,0.2)_100%)]" style="opacity: <?php echo e(($settings->hero_overlay_opacity ?? 80) / 100); ?>;"></div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- Background Grid -->
  <div
    class="absolute inset-0 opacity-[0.06] z-10 pointer-events-none"
    style="
      background-image: linear-gradient(rgba(15,118,110,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(15,118,110,.1) 1px, transparent 1px);
      background-size: 72px 72px;
    "
  ></div>
  <div class="absolute inset-x-0 bottom-0 h-24 bg-[linear-gradient(0deg,#ffffff_0%,rgba(255,255,255,0)_100%)] z-10 pointer-events-none"></div>

  <!-- Content -->
  <div class="relative mx-auto grid max-w-7xl gap-12 px-4 pb-20 pt-12 lg:grid-cols-[1.1fr_.9fr] lg:pb-24 lg:pt-16 items-center w-full z-20">
    <!-- Right Column (Text & Care Path) -->
    <div class="flex flex-col justify-center">
      <!-- Dynamic Slide Content -->
      <div id="hero-content-area" class="max-w-3xl min-h-[220px] relative z-20">
        <div class="mb-5 inline-flex items-center gap-3 rounded-[8px] border border-emerald-500/20 bg-emerald-50/80 px-4 py-2 text-sm font-bold text-emerald-800 backdrop-blur-md">
          <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
          <span id="hero-slide-eyebrow"><?php echo e($heroSlides[0]['eyebrow']); ?></span>
        </div>

        <h1 id="hero-slide-title" class="text-4xl font-black leading-[1.15] md:text-5xl lg:text-6xl text-slate-900">
          <?php echo e($heroSlides[0]['title']); ?>

        </h1>

        <p id="hero-slide-subtitle" class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 md:text-xl">
          <?php echo e($heroSlides[0]['subtitle']); ?>

        </p>
      </div>

      <div class="mt-8 flex flex-wrap gap-3 z-20">
        <a
          href="#appointment"
          onclick="event.preventDefault(); document.getElementById('appointment').scrollIntoView({behavior: 'smooth'});"
          class="group inline-flex items-center gap-3 rounded-[8px] bg-emerald-600 px-6 py-4 text-base font-black text-white shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5 hover:bg-emerald-700"
        >
          <i data-lucide="calendar" class="w-[21px] h-[21px]"></i>
          <span>احجز موعدك</span>
          <i data-lucide="arrow-left" class="w-[18px] h-[18px] transition group-hover:-translate-x-1"></i>
        </a>
        <a
          href="tel:<?php echo e($settings->emergency ?? '920012345'); ?>"
          class="inline-flex items-center gap-3 rounded-[8px] border border-slate-200 bg-white/80 px-6 py-4 text-base font-black text-slate-800 shadow-sm backdrop-blur-md transition hover:-translate-y-0.5 hover:bg-white"
        >
          <i data-lucide="phone" class="w-[21px] h-[21px]"></i>
          <span>الطوارئ <?php echo e($settings->emergency ?? '920012345'); ?></span>
        </a>
      </div>

      <!-- Care Path -->
      <div class="mt-10 grid max-w-3xl grid-cols-2 gap-3 md:grid-cols-4 z-20">
        <?php $__currentLoopData = $carePath; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="rounded-[12px] border border-slate-100 bg-white/60 p-4 shadow-sm backdrop-blur-md">
            <div class="mb-4 flex items-center justify-between">
              <i data-lucide="<?php echo e($item['icon']); ?>" class="text-emerald-500 w-5 h-5"></i>
              <span class="font-mono text-xs text-slate-400">0<?php echo e($index + 1); ?></span>
            </div>
            <p class="text-sm font-black text-slate-800"><?php echo e($item['label']); ?></p>
            <p class="mt-1 text-xs text-slate-500"><?php echo e($item['value']); ?></p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    <!-- Left Column (Hidden to keep DOM elements for slider JS) -->
    <div class="hidden">
      <span id="hero-slide-metric"></span>
      <span id="hero-slide-metric-label"></span>
    </div>
  </div>

  <!-- Sliders Navigation dot controls -->
  <div class="absolute bottom-8 left-1/2 z-30 flex -translate-x-1/2 items-center gap-3">
    <button
      onclick="prevHeroSlide()"
      class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white/90 text-slate-700 shadow-sm backdrop-blur-sm transition hover:bg-white"
      aria-label="الشريحة السابقة"
    >
      <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>
    <div class="flex items-center gap-2">
      <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button
          onclick="goToHeroSlide(<?php echo e($index); ?>)"
          class="hero-dot-indicator h-2.5 rounded-full transition-all <?php echo e($index === 0 ? 'w-8 bg-emerald-500' : 'w-2.5 bg-slate-300 hover:bg-slate-400'); ?>"
          data-dot-index="<?php echo e($index); ?>"
          aria-label="انتقل إلى الشريحة <?php echo e($index + 1); ?>"
        ></button>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <button
      onclick="nextHeroSlide()"
      class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white/90 text-slate-700 shadow-sm backdrop-blur-sm transition hover:bg-white"
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
        dot.classList.remove('w-2.5', 'bg-slate-300');
        dot.classList.add('w-8', 'bg-emerald-500');
      } else {
        dot.classList.remove('w-8', 'bg-emerald-500');
        dot.classList.add('w-2.5', 'bg-slate-300');
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
<?php /**PATH D:\laravel-hospital-website-development\resources\views/components/home/Hero.blade.php ENDPATH**/ ?>