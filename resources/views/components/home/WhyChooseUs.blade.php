@php
  $reasons = [
    [
      'icon' => 'shield',
      'title' => 'اعتماد دولي JCI',
      'desc' => 'حاصلون على الاعتماد الدولي من الهيئة الدولية لاعتماد المؤسسات الصحية',
      'color' => 'from-blue-500 to-indigo-600',
      'bg' => 'bg-blue-50',
    ],
    [
      'icon' => 'clock',
      'title' => 'خدمة على مدار الساعة',
      'desc' => 'طوارئ وعناية مركزة تعمل 24 ساعة طوال أيام الأسبوع',
      'color' => 'from-red-500 to-rose-600',
      'bg' => 'bg-red-50',
    ],
    [
      'icon' => 'award',
      'title' => 'خبرة +25 سنة',
      'desc' => 'أكثر من ربع قرن من الخبرة في تقديم الرعاية الصحية المتميزة',
      'color' => 'from-amber-500 to-orange-600',
      'bg' => 'bg-amber-50',
    ],
    [
      'icon' => 'heart',
      'title' => 'رعاية إنسانية',
      'desc' => 'نضع المريض في قلب اهتمامنا ونتعامل بمنتهى الإنسانية والاحترام',
      'color' => 'from-pink-500 to-rose-600',
      'bg' => 'bg-pink-50',
    ],
    [
      'icon' => 'zap',
      'title' => 'أحدث التقنيات',
      'desc' => 'نستخدم أحدث الأجهزة والتقنيات الطبية المتطورة في العالم',
      'color' => 'from-purple-500 to-violet-600',
      'bg' => 'bg-purple-50',
    ],
    [
      'icon' => 'users',
      'title' => '+200 طبيب متخصص',
      'desc' => 'فريق طبي متكامل من أمهر الاستشاريين في مختلف التخصصات',
      'color' => 'from-emerald-500 to-teal-600',
      'bg' => 'bg-emerald-50',
    ],
    [
      'icon' => 'thumbs-up',
      'title' => 'نسبة رضا 98%',
      'desc' => 'نفتخر بنسبة رضا مرضانا العالية التي تعكس جودة خدماتنا',
      'color' => 'from-cyan-500 to-sky-600',
      'bg' => 'bg-cyan-50',
    ],
    [
      'icon' => 'headphones',
      'title' => 'دعم فني متواصل',
      'desc' => 'فريق خدمة عملاء متاح لمساعدتكم والرد على استفساراتكم',
      'color' => 'from-indigo-500 to-blue-600',
      'bg' => 'bg-indigo-50',
    ],
  ];
@endphp

<section id="why-choose-us" class="py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
  <!-- Decorative Background -->
  <div class="absolute top-0 left-0 w-72 h-72 bg-primary-100/40 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 right-0 w-72 h-72 bg-emerald-100/40 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-600 bg-emerald-500/10">
        لماذا تختارنا
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        أسباب تجعلنا
        <span class="text-primary-600"> خيارك الأول</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        نلتزم بأعلى معايير الجودة والسلامة لنقدم لكم تجربة علاجية استثنائية
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    <!-- Reasons Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up">
      @foreach($reasons as $index => $reason)
        <div
          class="group bg-white rounded-3xl p-7 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 cursor-pointer relative overflow-hidden"
          style="animation-delay: {{ $index * 100 }}ms"
        >
          <!-- Hover background -->
          <div class="absolute inset-0 bg-gradient-to-br {{ $reason['color'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>

          <div class="relative">
            <div class="w-16 h-16 {{ $reason['bg'] }} group-hover:bg-white/20 rounded-2xl flex items-center justify-center mb-5 transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
              <i data-lucide="{{ $reason['icon'] }}" class="text-gray-700 group-hover:text-white transition-colors w-[30px] h-[30px]"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-white transition-colors">
              {{ $reason['title'] }}
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed group-hover:text-white/80 transition-colors">
              {{ $reason['desc'] }}
            </p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
