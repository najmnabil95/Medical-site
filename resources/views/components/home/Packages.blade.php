<section id="packages" class="py-24 relative overflow-hidden">
  {{-- Background --}}
  <div class="absolute inset-0 bg-linear-to-b from-white via-primary-50/30 to-white"></div>
  <div class="absolute top-20 right-0 w-96 h-96 bg-amber-50/40 rounded-full blur-3xl"></div>
  <div class="absolute bottom-20 left-0 w-80 h-80 bg-violet-50/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">

    {{-- Section Header --}}
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-amber-600 bg-amber-500/10">
        باقات الكشف
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        باقات فحص
        <span class="text-primary-600">شاملة ومتكاملة</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        اختر الباقة المناسبة لك واحصل على رعاية طبية شاملة بأسعار تنافسية
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    {{-- Packages Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
      @forelse($packages as $index => $package)
      @php
        $gradient = $package->gradient ?? 'from-gray-600 to-gray-800';
        $isPopular = $package->popular ?? false;
      @endphp
      <div class="relative group {{ $isPopular ? 'lg:-translate-y-4' : '' }}">
        {{-- Popular Badge --}}
        @if($isPopular)
        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
          <span class="bg-linear-to-l from-amber-400 to-amber-500 text-white text-xs font-black px-5 py-2 rounded-full shadow-lg shadow-amber-500/30 flex items-center gap-1.5">
            <i data-lucide="crown" class="w-3.5 h-3.5"></i>
            الأكثر شعبية
          </span>
        </div>
        @endif

        <div class="bg-white rounded-3xl overflow-hidden border {{ $isPopular ? 'border-amber-200 shadow-xl shadow-amber-500/10' : 'border-gray-100 shadow-sm' }} hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 h-full flex flex-col">
          {{-- Package Header --}}
          <div class="bg-linear-to-br {{ $gradient }} p-8 text-white text-center relative overflow-hidden">
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>
            <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/5 rounded-full"></div>
            <div class="relative">
              <div class="text-4xl mb-3">{{ $package->icon }}</div>
              <h3 class="text-xl font-black mb-1">{{ $package->name }}</h3>
              @if($package->name_en)
                <p class="text-white/60 text-xs font-medium tracking-wider">{{ $package->name_en }}</p>
              @endif
            </div>
          </div>

          {{-- Price --}}
          <div class="p-8 text-center border-b border-gray-50 shrink-0">
            <div class="flex items-baseline justify-center gap-2">
              <span class="text-4xl font-black text-gray-900">{{ $package->price }}</span>
              <span class="text-sm text-gray-400 font-bold">ر.س</span>
            </div>
            @if($package->period)
              <p class="text-xs text-gray-400 mt-1 font-medium">{{ $package->period }}</p>
            @endif
          </div>

          {{-- Features --}}
          <div class="p-8 flex-1">
            @php
              $features = is_array($package->features) ? $package->features : json_decode($package->features, true) ?? [];
            @endphp
            <ul class="space-y-4">
              @foreach($features as $feature)
              <li class="flex items-start gap-3 text-right">
                <div class="w-5 h-5 bg-emerald-100 rounded-full flex items-center justify-center mt-0.5 shrink-0">
                  <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                </div>
                <span class="text-sm text-gray-700 font-medium leading-relaxed">{{ $feature }}</span>
              </li>
              @endforeach
            </ul>
          </div>

          {{-- CTA Button --}}
          <div class="p-8 pt-0">
            <button
              onclick="if(typeof prefillAppointment === 'function') { const appointmentSection = document.getElementById('appointment'); if(appointmentSection) { appointmentSection.scrollIntoView({behavior:'smooth', block:'center'}); } else { window.location.href='/#appointment'; }}"
              class="w-full py-3.5 rounded-2xl font-bold text-sm transition-all cursor-pointer flex items-center justify-center gap-2 {{ $isPopular ? 'bg-linear-to-l from-amber-400 to-amber-500 text-white hover:shadow-lg hover:shadow-amber-500/30 hover:-translate-y-0.5' : 'bg-gray-50 text-gray-700 hover:bg-primary-50 hover:text-primary-700 border border-gray-200 hover:border-primary-200' }}"
            >
              <i data-lucide="calendar" class="w-4 h-4"></i>
              <span>احجز الآن</span>
            </button>
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center py-16">
        <p class="text-gray-400 text-lg">لا توجد باقات متاحة حالياً</p>
      </div>
      @endforelse
    </div>

  </div>
</section>
