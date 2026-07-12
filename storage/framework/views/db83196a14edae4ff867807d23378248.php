<?php
  $aboutFeatures = [
    "فريق طبي متخصص من أفضل الأطباء والاستشاريين",
    "أحدث الأجهزة والتقنيات الطبية العالمية",
    "غرف عمليات مجهزة بأعلى المعايير الدولية",
    "خدمة طوارئ متكاملة على مدار الساعة",
    "اعتماد دولي من الهيئة الدولية JCI",
    "برامج رعاية صحية شاملة ومتكاملة",
  ];
?>

<section id="about" class="py-24 bg-white relative overflow-hidden scroll-mt-32">
  <!-- Decorative Background shape -->
  <div class="absolute top-0 left-0 w-80 h-80 bg-slate-100 rounded-full blur-3xl opacity-50"></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    <div class="grid lg:grid-cols-2 gap-20 items-center">
      
      <!-- Images Grid -->
      <div class="relative animate-fade-in-up">
        <div class="grid grid-cols-12 gap-4">
          <div class="col-span-7 space-y-4">
            <div class="rounded-3xl overflow-hidden shadow-2xl">
              <img
                src="<?php echo e($settings->about_image_1); ?>"
                alt="فريق الجراحة"
                class="w-full h-64 object-cover hover:scale-105 transition-transform duration-700"
              />
            </div>
            <div class="rounded-3xl overflow-hidden shadow-2xl">
              <img
                src="<?php echo e($settings->about_image_2); ?>"
                alt="معدات طبية"
                class="w-full h-48 object-cover hover:scale-105 transition-transform duration-700"
              />
            </div>
          </div>
          <div class="col-span-5 space-y-4 pt-10">
            <div class="rounded-3xl overflow-hidden shadow-2xl">
              <img
                src="<?php echo e($settings->about_image_3); ?>"
                alt="جراحة"
                class="w-full h-48 object-cover hover:scale-105 transition-transform duration-700"
              />
            </div>
            <div class="rounded-3xl overflow-hidden shadow-2xl relative group cursor-pointer" onclick="document.getElementById('video-section')?.scrollIntoView({behavior:'smooth'});">
              <img
                src="<?php echo e($settings->about_image_4); ?>"
                alt="غرفة علاج"
                class="w-full h-64 object-cover hover:scale-105 transition-transform duration-700"
              />
              <!-- Video Play Button Overlay -->
              <div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/40 transition-all">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                  <i data-lucide="play" class="text-primary-600 w-7 h-7" style="margin-left: 2px;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Experience Badge -->
        <div class="absolute -bottom-4 right-8 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-6 shadow-2xl shadow-emerald-500/20 animate-float">
          <div class="text-center">
            <div class="text-5xl font-black leading-none">25<span class="text-emerald-400">+</span></div>
            <div class="text-sm font-medium opacity-90 mt-1">سنة من التميز</div>
            <div class="w-8 h-0.5 bg-emerald-400 mx-auto mt-2 rounded-full"></div>
          </div>
        </div>
      </div>

      <!-- Content Column -->
      <div class="space-y-7 animate-slide-in-left">
        <div>
          <span class="text-emerald-600 font-bold text-sm tracking-wider bg-emerald-50 px-5 py-2 rounded-full inline-block">
            من نحن
          </span>
          <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-slate-900 mt-5 leading-tight">
            نقدم أفضل رعاية صحية
            <br />
            <span class="text-emerald-600">لصحة أفضل لكم</span>
          </h2>
        </div>

        <p class="text-slate-600 text-lg leading-[1.9]">
          مستشفى الشفاء الدولي هو صرح طبي متكامل يقدم خدمات الرعاية الصحية وفق أعلى
          المعايير العالمية. تأسس المستشفى عام 1999 ويضم نخبة من أفضل الأطباء والاستشاريين
          في مختلف التخصصات الطبية، مع التزامنا الراسخ بتقديم أفضل تجربة علاجية لمرضانا.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <?php $__currentLoopData = $aboutFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-start gap-3 group p-2 rounded-xl hover:bg-emerald-50/50 transition-colors">
              <i data-lucide="check-circle-2" class="text-emerald-500 mt-0.5 shrink-0 group-hover:scale-110 transition-transform w-5 h-5"></i>
              <span class="text-slate-700 text-sm font-medium leading-relaxed"><?php echo e($feature); ?></span>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-4 pt-2">
          <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 text-center hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-2 cursor-pointer group">
            <i data-lucide="award" class="mx-auto text-emerald-500 mb-2 group-hover:scale-110 transition-transform w-7 h-7"></i>
            <div class="text-2xl font-black text-slate-800">15+</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">جائزة تميز</div>
          </div>
          <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 text-center hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-2 cursor-pointer group">
            <i data-lucide="users" class="mx-auto text-emerald-500 mb-2 group-hover:scale-110 transition-transform w-7 h-7"></i>
            <div class="text-2xl font-black text-slate-800">200+</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">طبيب متخصص</div>
          </div>
          <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 text-center hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-2 cursor-pointer group">
            <i data-lucide="building-2" class="mx-auto text-emerald-500 mb-2 group-hover:scale-110 transition-transform w-7 h-7"></i>
            <div class="text-2xl font-black text-slate-800">30+</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">قسم طبي</div>
          </div>
        </div>

        <a
          href="#departments"
          onclick="event.preventDefault(); document.getElementById('departments').scrollIntoView({behavior:'smooth'});"
          class="inline-flex items-center gap-3 bg-emerald-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 hover:shadow-xl hover:shadow-emerald-600/30 transition-all hover:-translate-y-1 cursor-pointer"
        >
          <span>اكتشف أقسامنا</span>
          <span class="text-xl">←</span>
        </a>
      </div>

    </div>
  </div>
</section>
<?php /**PATH D:\laravel-hospital-website-development\resources\views/components/home/About.blade.php ENDPATH**/ ?>