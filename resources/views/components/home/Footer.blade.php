@php
  $quickLinks = [
    ['name' => 'الرئيسية', 'href' => '#home', 'component' => 'Hero'],
    ['name' => 'من نحن', 'href' => '#about', 'component' => 'About'],
    ['name' => 'الأقسام الطبية', 'href' => '#departments', 'component' => 'Departments'],
    ['name' => 'فريقنا الطبي', 'href' => '#doctors', 'component' => 'Doctors'],
    ['name' => 'خدماتنا', 'href' => '#services', 'component' => 'Services'],
    ['name' => 'حجز موعد', 'href' => '#appointment', 'component' => 'Appointment'],
    ['name' => 'تواصل معنا', 'href' => '#contact', 'component' => 'Contact'],
  ];

  $enabledQuickLinks = array_filter($quickLinks, function($link) use ($screens) {
      $screen = $screens->firstWhere('component', $link['component']);
      return !$screen || $screen->enabled;
  });

  $departmentsEnabled = $screens->firstWhere('component', 'Departments')->enabled ?? true;
@endphp

<footer class="bg-gray-900 text-white relative">
  <!-- Pre Footer CTA -->
  <div class="bg-gradient-to-l from-primary-600 to-primary-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    <div class="max-w-7xl mx-auto px-4 py-14 relative">
      <div class="flex flex-col md:flex-row items-center justify-between gap-8">
        <div>
          <h3 class="text-2xl md:text-3xl font-black">هل تحتاج إلى استشارة طبية؟</h3>
          <p class="text-white/60 mt-3 text-lg">فريقنا الطبي جاهز لمساعدتك على مدار الساعة</p>
        </div>
        <div class="flex gap-4">
          <a
            href="#appointment"
            onclick="event.preventDefault(); document.getElementById('appointment').scrollIntoView({behavior: 'smooth'});"
            class="bg-white text-primary-700 px-8 py-4 rounded-2xl font-bold hover:bg-gray-100 transition-all hover:-translate-y-1 shadow-lg text-lg cursor-pointer"
          >
            احجز موعدك
          </a>
          <a
            href="tel:{{ $settings->phone ?? '920012345' }}"
            class="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-2xl font-bold hover:bg-white/20 transition-all border border-white/20 flex items-center gap-3 text-lg"
          >
            <i data-lucide="phone" class="w-5 h-5"></i>
            <span>اتصل بنا</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Footer Content -->
  <div class="max-w-7xl mx-auto px-4 py-20 text-gray-700">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-white">
      
      <!-- Column 1: Brand Info -->
      <div class="lg:col-span-1">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-[52px] h-[52px] bg-white rounded-xl flex items-center justify-center border border-gray-100 shadow-md p-1.5 overflow-hidden">
            @if(!empty($settings->logo))
              @if(str_starts_with($settings->logo, 'http') || str_starts_with($settings->logo, 'data:'))
                <img src="{{ $settings->logo }}" alt="Logo" class="w-full h-full object-contain" />
              @else
                <span class="text-xl font-bold text-primary-600">{{ $settings->logo }}</span>
              @endif
            @else
              <span class="text-xl text-white">🏥</span>
            @endif
          </div>
          <div>
            <h4 class="text-xl font-bold text-white">{{ $settings->site_name ?? 'مستشفى الشفاء' }}</h4>
            <p class="text-xs text-gray-500 tracking-wider uppercase">{{ $settings->site_name_en ?? 'AL-SHIFA INTERNATIONAL HOSPITAL' }}</p>
          </div>
        </div>
        <p class="text-gray-400 leading-relaxed text-sm mb-6">
          {{ $settings->description ?? 'نحن في مستشفى الشفاء الدولي نلتزم بتقديم أعلى مستويات الرعاية الصحية المتميزة بأيدي نخبة من الأطباء والاستشاريين.' }}
        </p>
        <div class="flex items-center gap-2">
          @if(!empty($settings->facebook) && $settings->facebook !== '#')
            <a href="{{ $settings->facebook }}" class="w-10 h-10 bg-white/[0.05] rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white transition-all duration-300 hover:-translate-y-1">
              <i data-lucide="facebook" class="w-4 h-4"></i>
            </a>
          @endif
          @if(!empty($settings->twitter) && $settings->twitter !== '#')
            <a href="{{ $settings->twitter }}" class="w-10 h-10 bg-white/[0.05] rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white transition-all duration-300 hover:-translate-y-1">
              <i data-lucide="twitter" class="w-4 h-4"></i>
            </a>
          @endif
          @if(!empty($settings->instagram) && $settings->instagram !== '#')
            <a href="{{ $settings->instagram }}" class="w-10 h-10 bg-white/[0.05] rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white transition-all duration-300 hover:-translate-y-1">
              <i data-lucide="instagram" class="w-4 h-4"></i>
            </a>
          @endif
          @if(!empty($settings->youtube) && $settings->youtube !== '#')
            <a href="{{ $settings->youtube }}" class="w-10 h-10 bg-white/[0.05] rounded-xl flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white transition-all duration-300 hover:-translate-y-1">
              <i data-lucide="youtube" class="w-4 h-4"></i>
            </a>
          @endif
        </div>
      </div>

      <!-- Column 2: Quick Links -->
      @if(count($enabledQuickLinks) > 0)
        <div>
          <h4 class="text-lg font-bold mb-6 relative pb-3 text-white">
            روابط سريعة
            <span class="absolute bottom-0 right-0 w-12 h-1 bg-gradient-to-l from-primary-500 to-emerald-500 rounded-full"></span>
          </h4>
          <ul class="space-y-3">
            @foreach($enabledQuickLinks as $link)
              <li>
                <a
                  href="{{ $link['href'] }}"
                  onclick="event.preventDefault(); document.getElementById('{{ str_replace('#', '', $link['href']) }}').scrollIntoView({behavior: 'smooth'});"
                  class="text-gray-400 hover:text-emerald-400 transition-colors text-sm flex items-center gap-2 group cursor-pointer"
                >
                  <span class="w-1.5 h-1.5 bg-primary-600 rounded-full group-hover:bg-emerald-400 transition-colors"></span>
                  {{ $link['name'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Column 3: Departments -->
      @if($departmentsEnabled)
        <div>
          <h4 class="text-lg font-bold mb-6 relative pb-3 text-white">
            أقسامنا الطبية
            <span class="absolute bottom-0 right-0 w-12 h-1 bg-gradient-to-l from-primary-500 to-emerald-500 rounded-full"></span>
          </h4>
          <ul class="space-y-3">
            @foreach(['أمراض القلب', 'جراحة المخ والأعصاب', 'جراحة العظام', 'طب الأطفال', 'طب العيون', 'الطب الباطني', 'الطوارئ والإسعاف'] as $dept)
              <li>
                <a
                  href="#departments"
                  onclick="event.preventDefault(); document.getElementById('departments').scrollIntoView({behavior: 'smooth'});"
                  class="text-gray-400 hover:text-emerald-400 transition-colors text-sm flex items-center gap-2 group cursor-pointer"
                >
                  <span class="w-1.5 h-1.5 bg-emerald-600 rounded-full group-hover:bg-emerald-400 transition-colors"></span>
                  {{ $dept }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Column 4: Contact -->
      <div>
        <h4 class="text-lg font-bold mb-6 relative pb-3 text-white">
          معلومات التواصل
          <span class="absolute bottom-0 right-0 w-12 h-1 bg-gradient-to-l from-primary-500 to-emerald-500 rounded-full"></span>
        </h4>
        <div class="space-y-4">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-white/[0.05] rounded-lg flex items-center justify-center shrink-0 mt-0.5">
              <i data-lucide="map-pin" class="text-primary-400 w-4.5 h-4.5"></i>
            </div>
            <div>
              <p class="text-gray-400 text-sm">{{ $settings->address ?? 'طريق الملك فهد' }}</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/[0.05] rounded-lg flex items-center justify-center shrink-0">
              <i data-lucide="phone" class="text-primary-400 w-4.5 h-4.5"></i>
            </div>
            <a href="tel:{{ $settings->phone ?? '920012345' }}" class="text-gray-400 text-sm hover:text-emerald-400 transition-colors" dir="ltr">
              {{ $settings->phone ?? '920012345' }}
            </a>
          </div>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/[0.05] rounded-lg flex items-center justify-center shrink-0">
              <i data-lucide="mail" class="text-primary-400 w-4.5 h-4.5"></i>
            </div>
            <a href="mailto:{{ $settings->email ?? 'info@alshifa-hospital.com' }}" class="text-gray-400 text-sm hover:text-emerald-400 transition-colors">
              {{ $settings->email ?? 'info@alshifa-hospital.com' }}
            </a>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="mt-8 bg-white/[0.03] rounded-2xl p-5 border border-white/[0.05] text-white">
          <p class="text-sm font-bold mb-3">📧 اشترك في النشرة البريدية</p>
          <div class="flex gap-2">
            <input
              type="email"
              placeholder="بريدك الإلكتروني"
              class="flex-1 px-4 py-3 bg-white/[0.05] border border-white/10 rounded-xl text-sm focus:outline-none focus:border-primary-500 transition-colors placeholder:text-gray-600 text-white"
            />
            <button class="bg-gradient-to-l from-primary-500 to-primary-600 text-white px-4 py-3 rounded-xl hover:shadow-lg hover:shadow-primary-500/30 transition-all cursor-pointer">
              <i data-lucide="mail" class="w-4.5 h-4.5"></i>
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bottom Copyright Bar -->
  <div class="border-t border-white/[0.05] text-gray-500">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-sm flex items-center gap-1 text-gray-400">
        © 2024 {{ $settings->site_name ?? 'مستشفى الشفاء الدولي' }}. جميع الحقوق محفوظة. صنع بـ
        <i data-lucide="heart" class="text-red-500 fill-current w-3.5 h-3.5 mx-1"></i>
      </p>
      <div class="flex items-center gap-6 text-sm text-gray-400">
        <button onclick="togglePrivacyModal(true)" class="hover:text-emerald-400 transition-colors cursor-pointer">سياسة الخصوصية</button>
        <span class="w-1 h-1 bg-gray-700 rounded-full"></span>
        <button onclick="toggleTermsModal(true)" class="hover:text-emerald-400 transition-colors cursor-pointer">الشروط والأحكام</button>
        <span class="w-1 h-1 bg-gray-700 rounded-full"></span>
        <a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">لوحة التحكم</a>
      </div>
    </div>
  </div>
</footer>

<!-- Terms & Conditions Modal (Hidden by Default) -->
<div id="legal-terms-modal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-4">
  <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleTermsModal(false)"></div>
  <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden animate-scale-in">
    <!-- Header -->
    <div class="sticky top-0 bg-gradient-to-l from-primary-600 to-primary-800 text-white px-6 py-5 z-10">
      <button
        onclick="toggleTermsModal(false)"
        class="absolute top-4 left-4 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
      >
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
          <i data-lucide="file-text" class="w-6 h-6"></i>
        </div>
        <div>
          <h3 class="text-2xl font-bold">الشروط والأحكام</h3>
          <p class="text-sm text-white/70">آخر تحديث: يناير 2024</p>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="p-8 overflow-y-auto max-h-[70vh] text-gray-700">
      <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
        <i data-lucide="info" class="text-blue-600 shrink-0 mt-0.5 w-[18px] h-[18px]"></i>
        <p class="text-sm text-blue-700 leading-relaxed">
          نرجو قراءة هذه الوثيقة بعناية. باستخدامك لخدماتنا، فإنك توافق على جميع الشروط والأحكام المذكورة أدناه.
        </p>
      </div>

      <div class="space-y-6">
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">1. القبول بالشروط</h4>
          <p class="leading-relaxed">باستخدامك لموقع مستشفى الشفاء الدولي، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا لم توافق على أي من هذه الشروط، يرجى عدم استخدام الموقع.</p>
        </div>
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">2. الخدمات المقدمة</h4>
          <p class="leading-relaxed">يقدم الموقع معلومات عن خدماتنا الطبية، إمكانية حجز المواعيد، والاستشارات الطبية. الخدمات الطبية الفعلية تخضع لتقييم الأطباء المعالجين.</p>
        </div>
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">3. حجز المواعيد</h4>
          <p class="leading-relaxed">حجز الموعد عبر الموقع يخضع للتأكيد من قبل المستشفى. الاحتفاظ بالموعد ليس مضموناً حتى يتم تأكيد الحجز عبر رسالة نصية أو اتصال هاتفي.</p>
        </div>
      </div>

      <div class="mt-8 pt-6 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-500">
          © 2024 مستشفى الشفاء الدولي - جميع الحقوق محفوظة
        </p>
        <button
          onclick="toggleTermsModal(false)"
          class="mt-4 bg-gradient-to-l from-primary-500 to-primary-700 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition-all"
        >
          فهمت، إغلاق
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleTermsModal(show) {
    const modal = document.getElementById('legal-terms-modal');
    if (modal) {
      if (show) {
        modal.classList.remove('hidden');
      } else {
        modal.classList.add('hidden');
      }
    }
  }
</script>
