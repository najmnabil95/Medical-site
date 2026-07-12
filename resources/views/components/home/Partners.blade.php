<section id="partners" class="py-24 bg-white relative overflow-hidden">
  {{-- Background --}}
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-linear-to-b from-gray-50 to-transparent rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">

    {{-- Section Header --}}
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-cyan-600 bg-cyan-500/10">
        شركاؤنا
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        شركاء النجاح
        <span class="text-primary-600">والاعتمادات</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        نفخر بشراكاتنا مع أبرز المؤسسات الطبية وشركات التأمين المعتمدة
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-cyan-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    {{-- Certifications --}}
    @if(isset($certifications) && $certifications->count() > 0)
    <div class="mb-16">
      <h3 class="text-center text-lg font-black text-gray-800 mb-8 flex items-center justify-center gap-2">
        <i data-lucide="award" class="w-5 h-5 text-amber-500"></i>
        شهادات الاعتماد الدولية
      </h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($certifications->count(), 4) }} gap-6 max-w-4xl mx-auto">
        @foreach($certifications as $cert)
        @php
          $certColor = $cert->color ?? 'from-primary-500 to-primary-600';
          $certBg = $cert->bg ?? 'bg-primary-50';
          $certBorder = $cert->border ?? 'border-primary-200';
        @endphp
        <div class="group {{ $certBg }} {{ $certBorder }} border rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
          <div class="text-4xl mb-3">{{ $cert->icon }}</div>
          <h4 class="text-base font-black text-gray-900">{{ $cert->name }}</h4>
          <p class="text-sm text-gray-600 font-medium mt-1">{{ $cert->full_name }}</p>
          <p class="text-xs text-gray-400 mt-2">{{ $cert->desc }}</p>
          @if($cert->year)
          <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-bold bg-linear-to-l {{ $certColor }} text-white">
            {{ $cert->year }}
          </span>
          @endif
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Partners Logos --}}
    @if(isset($partners) && $partners->count() > 0)
    <div class="mb-16">
      <h3 class="text-center text-lg font-black text-gray-800 mb-8 flex items-center justify-center gap-2">
        <i data-lucide="handshake" class="w-5 h-5 text-primary-500"></i>
        شركاء النجاح
      </h3>
      <div class="flex flex-wrap items-center justify-center gap-6">
        @foreach($partners as $partner)
        <div class="bg-gray-50 hover:bg-white border border-gray-100 hover:border-primary-200 rounded-2xl p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1 min-w-[150px]">
          <div class="text-3xl mb-2">{{ $partner->emoji }}</div>
          <p class="font-black text-gray-800 text-sm">{{ $partner->name }}</p>
          <p class="text-xs text-gray-400 mt-0.5">{{ $partner->sub }}</p>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Insurance Companies --}}
    @if(isset($insurances) && $insurances->count() > 0)
    <div>
      <h3 class="text-center text-lg font-black text-gray-800 mb-8 flex items-center justify-center gap-2">
        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i>
        شركات التأمين المعتمدة
      </h3>
      <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
        <div class="flex flex-wrap items-center justify-center gap-4">
          @foreach($insurances as $insurance)
          <div class="bg-white rounded-2xl px-6 py-4 text-center border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300 min-w-[140px]">
            <div class="w-12 h-12 bg-linear-to-br from-emerald-50 to-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-2">
              <span class="font-black text-emerald-700 text-sm">{{ $insurance->abbr }}</span>
            </div>
            <p class="font-bold text-gray-800 text-sm">{{ $insurance->name }}</p>
          </div>
          @endforeach
        </div>
        <p class="text-center text-xs text-gray-400 mt-6 font-medium">
          <i data-lucide="info" class="w-3.5 h-3.5 inline-block ml-1"></i>
          نتعامل مع أكثر من {{ $insurances->count() }} شركة تأمين طبي معتمدة
        </p>
      </div>
    </div>
    @endif

  </div>
</section>
