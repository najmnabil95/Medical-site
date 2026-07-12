<section id="testimonials" class="py-24 relative overflow-hidden scroll-mt-32">
  {{-- Background --}}
  <div class="absolute inset-0 bg-linear-to-b from-gray-50 to-white"></div>
  <div class="absolute top-0 left-0 w-80 h-80 bg-primary-100/20 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 right-0 w-96 h-96 bg-violet-100/20 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">

    {{-- Section Header --}}
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-violet-600 bg-violet-500/10">
        آراء مرضانا
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        ماذا يقول
        <span class="text-primary-600">مرضانا عنا</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        نفخر بثقة مرضانا ورضاهم عن مستوى الخدمة والرعاية الطبية المقدمة
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-violet-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    {{-- Testimonials Carousel --}}
    <div class="relative" id="testimonials-carousel">
      <div class="overflow-hidden rounded-3xl">
        <div class="flex transition-transform duration-700 ease-in-out" id="testimonials-track">
          @forelse($testimonials as $index => $testimonial)
          @php
            $colors = ['from-primary-500 to-primary-600', 'from-violet-500 to-violet-600', 'from-emerald-500 to-emerald-600', 'from-amber-500 to-amber-600', 'from-rose-500 to-rose-600'];
            $color = $testimonial->color ?? $colors[$index % count($colors)];
          @endphp
          <div class="w-full shrink-0 px-2 md:px-0" data-slide="{{ $index }}">
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 max-w-3xl mx-auto">
              {{-- Quote Icon --}}
              <div class="mb-6">
                <div class="w-14 h-14 bg-linear-to-br {{ $color }} rounded-2xl flex items-center justify-center shadow-lg">
                  <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                  </svg>
                </div>
              </div>

              {{-- Testimonial Text --}}
              <p class="text-lg md:text-xl text-gray-700 leading-relaxed font-medium mb-8">
                "{{ $testimonial->text }}"
              </p>

              {{-- Rating Stars --}}
              <div class="flex items-center gap-1 mb-6">
                @for($i = 0; $i < 5; $i++)
                  @if($i < ($testimonial->rating ?? 5))
                    <i data-lucide="star" class="w-5 h-5 text-amber-400 fill-current"></i>
                  @else
                    <i data-lucide="star" class="w-5 h-5 text-gray-200"></i>
                  @endif
                @endfor
              </div>

              {{-- Author Info --}}
              <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-linear-to-br {{ $color }} rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-md">
                  {{ $testimonial->avatar ?? mb_substr($testimonial->name, 0, 1) }}
                </div>
                <div>
                  <h4 class="font-bold text-gray-900 text-base">{{ $testimonial->name }}</h4>
                  <p class="text-sm text-gray-500">{{ $testimonial->role }}</p>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="text-center py-16 w-full">
            <p class="text-gray-400 text-lg">لا توجد آراء متاحة حالياً</p>
          </div>
          @endforelse
        </div>
      </div>

      @if($testimonials->count() > 1)
      {{-- Navigation Arrows --}}
      <button onclick="moveTestimonialSlide(-1)" class="absolute left-0 md:-left-5 top-1/2 -translate-y-1/2 w-12 h-12 bg-white shadow-lg border border-gray-100 rounded-2xl flex items-center justify-center text-gray-600 hover:text-primary-600 hover:border-primary-200 hover:shadow-xl transition-all cursor-pointer z-10">
        <i data-lucide="chevron-left" class="w-5 h-5"></i>
      </button>
      <button onclick="moveTestimonialSlide(1)" class="absolute right-0 md:-right-5 top-1/2 -translate-y-1/2 w-12 h-12 bg-white shadow-lg border border-gray-100 rounded-2xl flex items-center justify-center text-gray-600 hover:text-primary-600 hover:border-primary-200 hover:shadow-xl transition-all cursor-pointer z-10">
        <i data-lucide="chevron-right" class="w-5 h-5"></i>
      </button>

      {{-- Dots Navigation --}}
      <div class="flex items-center justify-center gap-2 mt-8">
        @foreach($testimonials as $index => $t)
          <button
            onclick="goToTestimonialSlide(parseInt(this.dataset.index))"
            class="testimonial-dot w-2.5 h-2.5 rounded-full transition-all duration-300 cursor-pointer {{ $index === 0 ? 'bg-primary-500 w-8' : 'bg-gray-300 hover:bg-gray-400' }}"
            data-index="{{ $index }}"
          ></button>
        @endforeach
      </div>
      @endif
    </div>

  </div>

  {{-- Carousel Script --}}
  <script>
    (function() {
      let currentTestimonialSlide = 0;
      const track = document.getElementById('testimonials-track');
      if (!track) return;

      const slides = track.querySelectorAll('[data-slide]');
      const totalSlides = slides.length;
      if (totalSlides <= 1) return;

      function updateTestimonialSlide() {
        track.style.transform = `translateX(${currentTestimonialSlide * 100}%)`;
        document.querySelectorAll('.testimonial-dot').forEach((dot, i) => {
          if (i === currentTestimonialSlide) {
            dot.classList.add('bg-primary-500', 'w-8');
            dot.classList.remove('bg-gray-300');
          } else {
            dot.classList.remove('bg-primary-500', 'w-8');
            dot.classList.add('bg-gray-300');
          }
        });
      }

      window.moveTestimonialSlide = function(dir) {
        currentTestimonialSlide = (currentTestimonialSlide + dir + totalSlides) % totalSlides;
        updateTestimonialSlide();
      };

      window.goToTestimonialSlide = function(index) {
        currentTestimonialSlide = index;
        updateTestimonialSlide();
      };

      // Auto-play
      setInterval(() => {
        currentTestimonialSlide = (currentTestimonialSlide + 1) % totalSlides;
        updateTestimonialSlide();
      }, 6000);
    })();
  </script>
</section>
