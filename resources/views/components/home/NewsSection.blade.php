<section id="news-section" class="py-24 bg-white relative overflow-hidden">
  {{-- Background --}}
  <div class="absolute top-0 right-0 w-96 h-96 bg-blue-50/40 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-50/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">

    {{-- Section Header --}}
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-blue-600 bg-blue-500/10">
        أخبار وأحداث
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        آخر
        <span class="text-primary-600">الأخبار والمقالات</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        تابع آخر الأخبار والمقالات الطبية وإنجازات المستشفى
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    {{-- News Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($news->take(6) as $index => $article)
      @php
        $categoryColors = [
          'أخبار المستشفى' => 'bg-blue-50 text-blue-700 border-blue-200',
          'نصائح طبية' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
          'تقنية طبية' => 'bg-purple-50 text-purple-700 border-purple-200',
          'التغذية والرياضة' => 'bg-amber-50 text-amber-700 border-amber-200',
          'الأبحاث والدراسات' => 'bg-rose-50 text-rose-700 border-rose-200',
        ];
        $catClass = $categoryColors[$article->category] ?? 'bg-gray-50 text-gray-700 border-gray-200';
      @endphp
      <article class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 {{ $index === 0 && $article->featured ? 'md:col-span-2 md:row-span-1' : '' }}">
        {{-- Image --}}
        <div class="relative overflow-hidden {{ $index === 0 && $article->featured ? 'h-56 md:h-72' : 'h-52' }}">
          @if($article->image)
            <img
              src="{{ $article->image }}"
              alt="{{ $article->title }}"
              loading="lazy"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />
          @else
            <div class="w-full h-full bg-linear-to-br from-primary-100 to-primary-200 flex items-center justify-center">
              <i data-lucide="newspaper" class="w-16 h-16 text-primary-400"></i>
            </div>
          @endif
          <div class="absolute inset-0 bg-linear-to-t from-black/50 via-transparent to-transparent"></div>

          {{-- Category Badge --}}
          <div class="absolute top-4 right-4">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold border {{ $catClass }} backdrop-blur-sm bg-opacity-90">
              {{ $article->category }}
            </span>
          </div>

          @if($article->featured)
          <div class="absolute top-4 left-4">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-amber-400 text-amber-900 flex items-center gap-1">
              <i data-lucide="star" class="w-3 h-3 fill-current"></i>
              مميز
            </span>
          </div>
          @endif

          {{-- Date Overlay --}}
          <div class="absolute bottom-4 right-4 bg-white/95 backdrop-blur-sm rounded-xl px-3 py-2 shadow-lg">
            <p class="text-xs font-bold text-gray-800">{{ \Carbon\Carbon::parse($article->date)->locale('ar')->isoFormat('D MMMM YYYY') }}</p>
          </div>
        </div>

        {{-- Content --}}
        <div class="p-6">
          <h3 class="text-lg font-black text-gray-900 group-hover:text-primary-600 transition-colors leading-snug mb-3 line-clamp-2">
            {{ $article->title }}
          </h3>

          <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-2">
            {{ $article->excerpt }}
          </p>

          <div class="flex items-center justify-between pt-4 border-t border-gray-50">
            <div class="flex items-center gap-2 text-gray-400 text-xs">
              <i data-lucide="user" class="w-3.5 h-3.5"></i>
              <span>{{ $article->author }}</span>
            </div>
            @if($article->read_time)
            <div class="flex items-center gap-1.5 text-gray-400 text-xs">
              <i data-lucide="clock" class="w-3.5 h-3.5"></i>
              <span>{{ $article->read_time }}</span>
            </div>
            @endif
          </div>
        </div>
      </article>
      @empty
      <div class="col-span-full text-center py-16">
        <i data-lucide="newspaper" class="w-16 h-16 text-gray-200 mx-auto mb-4"></i>
        <p class="text-gray-400 text-lg">لا توجد أخبار متاحة حالياً</p>
      </div>
      @endforelse
    </div>

  </div>
</section>
