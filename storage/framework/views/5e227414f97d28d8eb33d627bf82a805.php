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

<section id="home" class="relative min-h-[82svh] overflow-hidden bg-slate-50 text-slate-900">
  <!-- Slides Container -->
  <div id="hero-slides-wrapper">
    <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div
        class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>"
        data-slide-index="<?php echo e($index); ?>"
      >
        <img src="<?php echo e($slide['image']); ?>" alt="فريق طبي داخل مستشفى الشفاء" class="h-full w-full object-cover" />
        <div class="absolute inset-0 bg-[linear-gradient(270deg,rgba(248,250,252,0.95)_0%,rgba(248,250,252,0.85)_50%,rgba(248,250,252,0.1)_100%)]"></div>
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
      <div id="hero-content-area" class="max-w-3xl min-h-[220px] relative z-20">
        <div class="mb-5 inline-flex items-center gap-3 rounded-[8px] border border-emerald-500/20 bg-emerald-50/80 px-4 py-2 text-sm font-bold text-emerald-800 backdrop-blur-md">
          <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
          <span id="hero-slide-eyebrow"><?php echo e($heroSlides[0]['eyebrow']); ?></span>
        </div>

        <h1 id="hero-slide-title" class="text-4xl font-black leading-[1.15] md:text-6xl lg:text-7xl">
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
          <div class="rounded-[8px] border border-slate-200 bg-white/60 p-4 shadow-sm backdrop-blur-md">
            <div class="mb-4 flex items-center justify-between">
              <i data-lucide="<?php echo e($item['icon']); ?>" class="text-emerald-500 w-5 h-5"></i>
              <span class="font-mono text-xs text-slate-400">0<?php echo e($index + 1); ?></span>
            </div>
            <p class="text-sm font-black"><?php echo e($item['label']); ?></p>
            <p class="mt-1 text-xs text-slate-500"><?php echo e($item['value']); ?></p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    <!-- Live stats dashboard right card -->
    <div class="relative flex items-center lg:justify-end z-20">
      <div class="w-full max-w-[520px] rounded-[8px] border border-white/40 bg-white/70 p-4 shadow-xl shadow-slate-200/50 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
          <div>
            <p class="text-sm font-bold text-emerald-600">مؤشر التشغيل الآن</p>
            <p class="text-xs text-slate-500">تحديث مباشر لمسار المريض</p>
          </div>
          <div class="inline-flex items-center gap-2 rounded-[8px] bg-emerald-100 px-3 py-2 text-xs font-black text-emerald-700">
            <i data-lucide="timer" class="w-3.5 h-3.5"></i>
            متاح
          </div>
        </div>

        <div class="grid gap-3 py-4">
          <?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="grid grid-cols-[44px_1fr] gap-4 rounded-[8px] border border-slate-100 bg-slate-50/80 p-4">
              <div class="flex h-11 w-11 items-center justify-center rounded-[8px] bg-emerald-100 text-emerald-600">
                <i data-lucide="<?php echo e($item['icon']); ?>" class="w-[22px] h-[22px]"></i>
              </div>
              <div>
                <h3 class="font-black"><?php echo e($item['title']); ?></h3>
                <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e($item['text']); ?></p>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Metric Card -->
        <div class="grid grid-cols-[1fr_auto] items-end gap-4 rounded-[8px] border border-slate-100 bg-white p-4 text-slate-800 shadow-sm">
          <div>
            <p class="text-xs font-bold text-emerald-600">قراءة الشريحة الحالية</p>
            <p id="hero-slide-metric" class="mt-2 text-4xl font-black"><?php echo e($heroSlides[0]['metric']); ?></p>
            <p id="hero-slide-metric-label" class="mt-1 text-sm text-slate-500"><?php echo e($heroSlides[0]['metricLabel']); ?></p>
          </div>
          <i data-lucide="heart-pulse" class="w-10 h-10 text-emerald-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Sliders Navigation dot controls -->
  <div class="absolute bottom-8 left-1/2 z-30 flex -translate-x-1/2 items-center gap-3">
    <button
      onclick="prevHeroSlide()"
      class="flex h-11 w-11 items-center justify-center rounded-[8px] border border-slate-200 bg-white/80 text-slate-700 shadow-sm backdrop-blur-md transition hover:bg-white"
      aria-label="الشريحة السابقة"
    >
      <i data-lucide="chevron-right" class="w-5 h-5"></i>
    </button>
    <div class="flex items-center gap-2">
      <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button
          onclick="goToHeroSlide(<?php echo e($index); ?>)"
          class="hero-dot-indicator h-2.5 rounded-full transition-all <?php echo e($index === 0 ? 'w-10 bg-emerald-500' : 'w-2.5 bg-slate-300 hover:bg-slate-400'); ?>"
          data-dot-index="<?php echo e($index); ?>"
          aria-label="انتقل إلى الشريحة <?php echo e($index + 1); ?>"
        ></button>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <button
      onclick="nextHeroSlide()"
      class="flex h-11 w-11 items-center justify-center rounded-[8px] border border-slate-200 bg-white/80 text-slate-700 shadow-sm backdrop-blur-md transition hover:bg-white"
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
        dot.classList.add('w-10', 'bg-emerald-500');
      } else {
        dot.classList.remove('w-10', 'bg-emerald-500');
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