@extends('layouts.app')

@section('title')
    كادرنا الطبي والاستشاريين | {{ $settings->site_name ?? 'مستشفى الشفاء الدولي' }}
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="relative pt-40 pb-20 lg:pt-52 lg:pb-28 mt-8 overflow-hidden bg-gradient-to-b from-slate-50 to-white text-right">
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-0 right-0 w-3/4 h-full bg-gradient-to-l from-primary-50/50 to-transparent"></div>
      <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-100/40 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
      
      <!-- Back to Previous Page Button -->
      <a href="javascript:history.back()" class="fixed top-6 left-4 md:left-8 bg-white/90 backdrop-blur-md text-gray-700 hover:text-primary-600 px-5 py-3 rounded-2xl text-sm font-bold shadow-lg hover:shadow-xl border border-gray-100 hover:border-primary-200 transition-all flex items-center gap-2 group z-[100]">
        <span>رجوع</span>
        <i data-lucide="arrow-left" class="w-4.5 h-4.5 group-hover:-translate-x-1 transition-transform"></i>
      </a>

      <div class="flex flex-col items-center text-center animate-fade-in-up mt-12 md:mt-0">
        <span class="text-xs font-bold text-primary-600 bg-primary-50 px-4 py-2 rounded-full inline-flex items-center gap-2 mb-6">
          <i data-lucide="stethoscope" class="w-4 h-4"></i>
          دليل الأطباء
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-950 leading-tight mb-6">
          نخبة من <span class="gradient-text">أفضل الاستشاريين</span>
          <br />والكوادر الطبية
        </h1>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">
          نفخر في المستشفى بضم كادر طبي متميز يتمتع بخبرات وكفاءات عالية، لتقديم أفضل مستويات الرعاية الصحية لك ولعائلتك.
        </p>
      </div>
    </div>
  </section>

  <!-- Filters & Search Section -->
  <section class="py-8 bg-white border-b border-gray-100 sticky top-16 z-30 shadow-sm/50">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
        
        <!-- Interactive Department Pills -->
        <div class="flex-1 w-full overflow-x-auto pb-2 lg:pb-0 scrollbar-hide" dir="rtl">
          <div class="flex items-center gap-3 w-max">
            <button onclick="filterByDepartment('all', this)" class="dept-filter-btn active px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 bg-primary-600 text-white shadow-md shadow-primary-600/20">
              الكل
            </button>
            @foreach($departments as $dept)
            <button onclick="filterByDepartment('{{ $dept->name }}', this)" class="dept-filter-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 bg-gray-50 text-gray-600 hover:bg-primary-50 hover:text-primary-600 border border-transparent hover:border-primary-100 whitespace-nowrap">
              {{ $dept->name }}
            </button>
            @endforeach
          </div>
        </div>

        <!-- Clean Search Input Box -->
        <div class="w-full lg:w-96 shrink-0 relative animate-fade-in-up" style="animation-delay: 100ms;">
          <div class="flex items-center gap-2 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200 focus-within:border-primary-500 focus-within:bg-white focus-within:shadow-md transition-all">
            <i data-lucide="search" class="text-gray-400 w-5 h-5 shrink-0"></i>
            <input
              type="text"
              id="doctor-search"
              onkeyup="searchDoctors()"
              placeholder="ابحث باسم الطبيب أو التخصص..."
              class="bg-transparent outline-none flex-1 text-sm text-right w-full placeholder:text-gray-400 text-gray-800"
            />
            <button id="clear-search" onclick="clearSearch()" class="hidden text-gray-400 hover:text-red-500 transition-colors">
              <i data-lucide="x-circle" class="w-5 h-5"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Doctors Directory Grid -->
  <section class="py-16 bg-slate-50/50 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="doctors-cards-grid">
        @foreach($doctors as $index => $doc)
          @php
            $gradient = $doc->gradient ?? 'from-primary-500 to-primary-700';
            $delay = ($index % 8) * 100; // Staggered animation delay
          @endphp
          <div
            class="doctor-card-item animate-fade-in-up group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100"
            data-name="{{ strtolower($doc->name) }}"
            data-specialty="{{ strtolower($doc->specialty) }}"
            data-department="{{ strtolower($doc->department) }}"
            style="animation-delay: {{ $delay }}ms;"
          >
            <!-- Image Container -->
            <div class="relative overflow-hidden h-72">
              <img
                src="{{ $doc->image }}"
                alt="{{ $doc->name }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                loading="lazy"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

              <!-- Gradient Overlay on hover -->
              <div class="absolute inset-0 bg-gradient-to-t {{ $gradient }} opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>

              <!-- Rating -->
              <div class="absolute bottom-5 right-5 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 flex items-center gap-1 shadow-lg">
                <i data-lucide="star" class="text-yellow-500 fill-current w-3.5 h-3.5"></i>
                <span class="text-sm font-bold text-gray-800">{{ $doc->rating }}</span>
              </div>
            </div>

            <!-- Info Panel -->
            <div class="p-6 text-right relative">
              <!-- Specialty Badge -->
              <div class="absolute -top-4 right-6 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-xs font-bold border border-emerald-100 shadow-sm z-10">
                {{ $doc->department }}
              </div>

              <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors mt-2">
                {{ $doc->name }}
              </h3>
              <p class="text-primary-600 text-sm font-bold mt-1.5">{{ $doc->specialty }}</p>
              @if($doc->description)
                <div class="relative">
                    <p class="text-gray-500 text-xs font-medium mt-2 line-clamp-2 leading-relaxed text-right">{{ $doc->description }}</p>
                    <button onclick="if(typeof openDoctorInfoModal === 'function') openDoctorInfoModal({{ $doc->id }})" class="text-primary-600 hover:text-primary-700 text-xs font-bold mt-1 inline-flex items-center gap-1 group/btn cursor-pointer">
                        <span>عرض التفاصيل</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 group-hover/btn:translate-y-0.5 transition-transform"></i>
                    </button>
                </div>
              @else
                <div class="h-12 mt-2"></div> <!-- Spacer to keep cards aligned if no description -->
              @endif

              <div class="flex items-center justify-between mt-5 pt-5 border-t border-gray-100 text-gray-700">
                <div class="text-center">
                  <div class="text-sm font-black text-gray-800">{{ $doc->experience }}</div>
                  <div class="text-xs text-gray-400 mt-0.5 font-medium">خبرة</div>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="text-center">
                  <div class="text-sm font-black text-gray-800">{{ $doc->patients }}</div>
                  <div class="text-xs text-gray-400 mt-0.5 font-medium">مريض</div>
                </div>
              </div>

              <button
                type="button"
                onclick="if(typeof openBookingModal === 'function') openBookingModal('{{ $doc->department }}', '{{ $doc->name }}')"
                class="mt-6 w-full bg-gradient-to-l {{ $gradient }} text-white py-3.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/20 transition-all duration-300 flex items-center justify-center gap-2 opacity-95 hover:opacity-100 hover:-translate-y-0.5 cursor-pointer"
              >
                <i data-lucide="calendar-plus" class="w-4.5 h-4.5"></i>
                <span>احجز موعد الآن</span>
              </button>
            </div>
          </div>
        @endforeach
      </div>

      <!-- No Results State -->
      <div id="no-results" class="hidden text-center py-24 animate-fade-in-up">
        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
          <i data-lucide="users" class="text-gray-300 w-12 h-12"></i>
        </div>
        <h4 class="text-2xl font-black text-gray-900">لا يوجد أطباء مطابقين للبحث</h4>
        <p class="text-gray-500 mt-3 text-base max-w-md mx-auto">لم نتمكن من العثور على أطباء يطابقون معايير البحث الخاصة بك. جرب البحث بكلمات أخرى أو اختر قسماً مختلفاً.</p>
        <button onclick="clearSearch(); filterByDepartment('all', document.querySelector('.dept-filter-btn'))" class="mt-8 px-6 py-2.5 bg-primary-50 text-primary-700 font-bold rounded-xl hover:bg-primary-100 transition-colors">
          عرض جميع الأطباء
        </button>
      </div>

    </div>
  </section>

@endsection

@section('scripts')
  <script>
    let currentSearchQuery = '';
    let currentActiveDepartment = 'all';

    function searchDoctors() {
      const searchInput = document.getElementById('doctor-search');
      const clearBtn = document.getElementById('clear-search');
      currentSearchQuery = searchInput.value.toLowerCase().trim();
      
      if (currentSearchQuery.length > 0) {
        clearBtn.classList.remove('hidden');
      } else {
        clearBtn.classList.add('hidden');
      }
      
      applyFilters();
    }

    function clearSearch() {
      const searchInput = document.getElementById('doctor-search');
      searchInput.value = '';
      searchDoctors();
    }

    function filterByDepartment(dept, btnElement) {
      currentActiveDepartment = dept.toLowerCase();
      
      // Update active state of buttons
      document.querySelectorAll('.dept-filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-primary-600', 'text-white', 'shadow-md', 'shadow-primary-600/20');
        btn.classList.add('bg-gray-50', 'text-gray-600', 'hover:bg-primary-50', 'hover:text-primary-600', 'border', 'border-transparent', 'hover:border-primary-100');
      });

      btnElement.classList.add('active', 'bg-primary-600', 'text-white', 'shadow-md', 'shadow-primary-600/20');
      btnElement.classList.remove('bg-gray-50', 'text-gray-600', 'hover:bg-primary-50', 'hover:text-primary-600', 'border', 'border-transparent', 'hover:border-primary-100');

      applyFilters();
    }

    function applyFilters() {
      const cards = document.querySelectorAll('.doctor-card-item');
      let visibleCount = 0;

      cards.forEach((card, index) => {
        const cardName = card.getAttribute('data-name');
        const cardSpecialty = card.getAttribute('data-specialty');
        const cardDept = card.getAttribute('data-department');

        const matchesSearch = (currentSearchQuery === '' || 
                               cardName.includes(currentSearchQuery) || 
                               cardSpecialty.includes(currentSearchQuery) ||
                               cardDept.includes(currentSearchQuery));
                               
        const matchesDept = (currentActiveDepartment === 'all' || 
                             cardDept === currentActiveDepartment);

        if (matchesSearch && matchesDept) {
          card.classList.remove('hidden');
          // Reset animation delay so they animate in gracefully when filtered
          card.style.animationDelay = `${(visibleCount % 8) * 100}ms`;
          // Force reflow to restart animation
          card.classList.remove('animate-fade-in-up');
          void card.offsetWidth;
          card.classList.add('animate-fade-in-up');
          visibleCount++;
        } else {
          card.classList.add('hidden');
        }
      });

      const noResults = document.getElementById('no-results');
      if (visibleCount === 0) {
        noResults.classList.remove('hidden');
      } else {
        noResults.classList.add('hidden');
      }
    }
    
    // Auto-filter if department is passed in URL Hash or Query
    document.addEventListener("DOMContentLoaded", () => {
        const urlParams = new URLSearchParams(window.location.search);
        const urlDept = urlParams.get('filter_dept');
        if (urlDept) {
            const buttons = document.querySelectorAll('.dept-filter-btn');
            buttons.forEach(btn => {
                if (btn.innerText.trim().toLowerCase() === urlDept.toLowerCase()) {
                    filterByDepartment(urlDept, btn);
                    // scroll to filters
                    setTimeout(() => {
                        window.scrollTo({
                            top: document.querySelector('.dept-filter-btn').getBoundingClientRect().top + window.pageYOffset - 100,
                            behavior: 'smooth'
                        });
                    }, 500);
                }
            });
        }
    });
  </script>
@endsection
