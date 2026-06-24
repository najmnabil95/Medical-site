<section id="doctors" class="py-24 bg-white relative overflow-hidden">
  <!-- Decorative background -->
  <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-100/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-600 bg-emerald-500/10">
        فريقنا الطبي
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        نخبة من
        <span class="text-primary-600"> أفضل الأطباء</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        يضم المستشفى فريقاً طبياً متميزاً من أفضل الاستشاريين والأطباء المتخصصين
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    <!-- Doctors Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 animate-fade-in-up">
      @foreach($doctors as $index => $doc)
        @php
          $gradient = $doc->gradient ?? 'from-primary-500 to-primary-700';
        @endphp
        <div
          class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-4 border border-gray-100"
          style="animation-delay: {{ $index * 150 }}ms"
        >
          <!-- Image Container -->
          <div class="relative overflow-hidden h-72">
            <img
              src="{{ $doc->image }}"
              alt="{{ $doc->name }}"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

            <!-- Gradient Overlay on hover -->
            <div class="absolute inset-0 bg-gradient-to-t {{ $gradient }} opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>

            <!-- Social Links -->
            <div class="absolute top-5 left-5 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-y-4 group-hover:translate-y-0">
              <a href="#" class="w-9 h-9 bg-white/90 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors shadow-lg" title="LinkedIn">
                <i data-lucide="linkedin" class="w-4 h-4"></i>
              </a>
              <a href="#" class="w-9 h-9 bg-white/90 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors shadow-lg" title="Twitter">
                <i data-lucide="twitter" class="w-4 h-4"></i>
              </a>
            </div>

            <!-- Rating -->
            <div class="absolute bottom-5 right-5 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 flex items-center gap-1 shadow-lg">
              <i data-lucide="star" class="text-yellow-500 fill-current w-3.5 h-3.5"></i>
              <span class="text-sm font-bold text-gray-800">{{ $doc->rating }}</span>
            </div>
          </div>

          <!-- Info Panel -->
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
              {{ $doc->name }}
            </h3>
            <p class="text-primary-600 text-sm font-medium mt-1.5">{{ $doc->specialty }}</p>

            <div class="flex items-center justify-between mt-5 pt-5 border-t border-gray-100 text-gray-700">
              <div class="text-center">
                <div class="text-sm font-bold text-gray-800">{{ $doc->experience }}</div>
                <div class="text-xs text-gray-400 mt-0.5">خبرة</div>
              </div>
              <div class="h-8 w-px bg-gray-200"></div>
              <div class="text-center">
                <div class="text-sm font-bold text-gray-800">{{ $doc->patients }}</div>
                <div class="text-xs text-gray-400 mt-0.5">مريض</div>
              </div>
            </div>

            <button
              onclick="prefillAppointment('{{ $doc->department }}', '{{ $doc->name }}')"
              class="mt-5 w-full bg-gradient-to-l {{ $gradient }} text-white py-3 rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2 opacity-90 hover:opacity-100 cursor-pointer"
            >
              <i data-lucide="calendar" class="w-4 h-4"></i>
              <span>احجز موعد</span>
            </button>
          </div>
        </div>
      @endforeach
    </div>

    @if($doctors->isEmpty())
      <div class="text-center py-16">
        <p class="text-gray-400 text-lg">لا يوجد أطباء متاحين حالياً</p>
      </div>
    @endif
  </div>
</section>
