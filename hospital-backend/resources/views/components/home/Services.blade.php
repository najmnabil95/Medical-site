<section id="services" class="py-24 bg-gradient-to-b from-primary-800 via-primary-900 to-gray-900 relative overflow-hidden">
  <!-- Decorative background shapes -->
  <div class="absolute top-0 left-0 w-96 h-96 bg-primary-600/15 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
  <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-500/8 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
  <div class="absolute inset-0 opacity-[0.03]" style="
    background-image: radial-gradient(circle, white 1px, transparent 1px);
    background-size: 30px 30px;
  "></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-400 bg-emerald-500/10">
        خدماتنا
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-white">
        خدمات طبية
        <span class="text-emerald-400"> متميزة</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-white/60">
        نقدم مجموعة متكاملة من الخدمات الطبية والمساندة لضمان حصولكم على أفضل رعاية ممكنة
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-white/20 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-white/20 rounded-full"></span>
      </div>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 animate-fade-in-up">
      @foreach($services as $index => $serv)
        @php
          $icon = strtolower($serv->icon ?? 'activity');
          $color = $serv->color ?? 'from-primary-500 to-primary-700';
          $number = $serv->number ?? sprintf("%02d", $index + 1);
        @endphp
        <div
          class="group bg-white/[0.04] backdrop-blur-sm rounded-2xl p-7 border border-white/[0.08] hover:bg-white/[0.1] hover:border-white/20 transition-all duration-500 hover:-translate-y-3 cursor-pointer relative overflow-hidden"
          style="animation-delay: {{ $index * 100 }}ms"
        >
          <!-- Absolute Card Number -->
          <span class="absolute top-4 left-4 text-[3rem] font-black text-white/[0.03] group-hover:text-white/[0.08] transition-colors">
            {{ $number }}
          </span>

          <!-- Shimmer effect -->
          <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity animate-shimmer rounded-2xl"></div>

          <div class="relative">
            <div class="w-14 h-14 bg-gradient-to-br {{ $color }} rounded-2xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
              <i data-lucide="{{ $icon }}" class="text-white w-6.5 h-6.5"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors">
              {{ $serv->title }}
            </h3>
            <p class="text-white/40 text-sm leading-relaxed group-hover:text-white/60 transition-colors line-clamp-3">
              {{ $serv->desc }}
            </p>
          </div>
        </div>
      @endforeach
    </div>

    <!-- CTA bottom button -->
    <div class="text-center mt-16 z-20 relative">
      <a
        href="#contact"
        onclick="event.preventDefault(); document.getElementById('contact').scrollIntoView({behavior:'smooth'});"
        class="inline-flex items-center gap-3 bg-gradient-to-l from-emerald-500 to-emerald-600 text-white px-10 py-4.5 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-1 cursor-pointer"
      >
        <span>تعرف على المزيد من خدماتنا</span>
        <span class="text-xl">←</span>
      </a>
    </div>

  </div>
</section>
