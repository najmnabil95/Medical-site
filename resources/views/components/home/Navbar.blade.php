@php
  $allLinks = [
    ['name' => 'الرئيسية', 'href' => '#home', 'id' => 'home', 'component' => 'Hero'],
    ['name' => 'من نحن', 'href' => '#about', 'id' => 'about', 'component' => 'About'],
    ['name' => 'الأقسام', 'href' => '#departments', 'id' => 'departments', 'component' => 'Departments'],
    ['name' => 'أطباؤنا', 'href' => '/doctors', 'id' => 'doctors', 'component' => 'Doctors'],
    ['name' => 'خدماتنا', 'href' => '#services', 'id' => 'services', 'component' => 'Services'],
    ['name' => 'آراء المرضى', 'href' => '#testimonials', 'id' => 'testimonials', 'component' => 'Testimonials'],
    ['name' => 'تواصل معنا', 'href' => '#contact', 'id' => 'contact', 'component' => 'Contact'],
  ];
  
  $navLinks = array_filter($allLinks, function($link) use ($screens) {
      $screen = $screens->firstWhere('component', $link['component']);
      return !$screen || $screen->enabled;
  });

  $isHomepage = Request::is('/') || Request::routeIs('home');
  $isDoctorsPage = Request::is('doctors') || Request::is('doctors/*');

  $unreadNotifications = \App\Models\Notification::where('status', 'pending')->count();
  $notifications = \App\Models\Notification::latest()->take(10)->get();
@endphp

<!-- Main Navbar -->
<nav id="main-navbar" class="sticky top-0 z-50 transition-all duration-500 bg-white shadow-sm py-0">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between h-[72px]">
      
      <!-- Logo -->
      <a href="/" class="flex items-center gap-3 group cursor-pointer">
        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center overflow-hidden border border-gray-100 shadow-md p-1.5 group-hover:scale-105 transition-all">
          @if(!empty($settings->logo))
            @if(str_starts_with($settings->logo, 'http') || str_starts_with($settings->logo, 'data:'))
              <img src="{{ $settings->logo }}" alt="Logo" class="w-full h-full object-contain" />
            @else
              <span class="text-2xl font-bold text-primary-600">{{ $settings->logo }}</span>
            @endif
          @else
            <span class="text-2xl">🏥</span>
          @endif
        </div>
        <div>
          <h1 class="text-lg font-bold text-primary-700 leading-tight group-hover:text-primary-600 transition-colors">
            {{ $settings->site_name ?? 'مستشفى الشفاء' }}
          </h1>
          <p class="text-[9px] text-gray-400 tracking-[0.15em] font-medium">
            {{ $settings->site_name_en ?? 'AL-SHIFA INTERNATIONAL HOSPITAL' }}
          </p>
        </div>
      </a>

      <!-- Desktop Links -->
      <div class="hidden lg:flex items-center gap-0.5">
        @foreach($navLinks as $link)
          @php
            $href = $isHomepage ? $link['href'] : (str_starts_with($link['href'], '#') ? '/' . $link['href'] : $link['href']);
            $isActive = $isDoctorsPage && $link['href'] === '/doctors';
          @endphp
          <a
            href="{{ $href }}"
            data-section="{{ $link['id'] }}"
            class="nav-anchor relative px-3.5 py-2 text-sm font-medium rounded-lg transition-all duration-300 cursor-pointer {{ $isActive ? 'text-primary-600 bg-primary-50 font-bold' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-50' }}"
          >
            {{ $link['name'] }}
            <span class="nav-indicator absolute bottom-0 right-1/2 translate-x-1/2 w-5 h-0.5 bg-primary-500 rounded-full {{ $isActive ? '' : 'hidden' }}"></span>
          </a>
        @endforeach
      </div>

      <!-- CTA Section -->
      <div class="hidden lg:flex items-center gap-2.5">
        
        <!-- Notifications Toggle -->
        <div class="relative">
          <button
            id="notif-toggle-btn"
            class="relative flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-all"
            title="الإشعارات"
          >
            <i data-lucide="bell" class="w-[18px] h-[18px]"></i>
            @if($unreadNotifications > 0)
              <span class="absolute top-1 left-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
              </span>
            @endif
          </button>

          <!-- Notifications Dropdown -->
          <div id="notif-dropdown" class="hidden absolute left-0 top-full mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
            <div class="bg-gradient-to-l from-primary-500 to-primary-600 text-white px-4 py-3">
              <h3 class="font-bold">الإشعارات</h3>
              <p class="text-xs text-white/70">{{ $unreadNotifications }} إشعار غير مقروء</p>
            </div>
            <div class="max-h-96 overflow-y-auto">
              @if($notifications->isEmpty())
                <div class="p-8 text-center text-gray-400">
                  <i data-lucide="bell" class="mx-auto mb-2 opacity-30 w-12 h-12"></i>
                  <p>لا توجد إشعارات</p>
                </div>
              @else
                @foreach($notifications as $notif)
                  <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ !$notif->read ? 'bg-blue-50/50' : '' }}">
                    <div class="flex items-start gap-3">
                      <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $notif->type === 'success' ? 'bg-green-100 text-green-600' : ($notif->type === 'warning' ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600') }}">
                        @if($notif->type === 'success') ✓ @elseif($notif->type === 'warning') ⚠ @else ℹ @endif
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 line-clamp-2">{{ $notif->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                      </div>
                      @if(!$notif->read)
                        <div class="w-2 h-2 bg-blue-500 rounded-full shrink-0 mt-2" style="margin-top: 8px;"></div>
                      @endif
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>

        <!-- Dark Mode Toggle Button -->
        <button
          onclick="toggleDarkMode(); updateDarkModeIcon();"
          class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-all"
          title="تغيير المظهر"
        >
          <span id="dark-mode-icon-container">
            <i data-lucide="moon" class="w-[18px] h-[18px]"></i>
          </span>
        </button>

        <!-- Admin Control Route -->
        <a
          href="{{ route('admin.dashboard') }}"
          class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-colors"
          title="لوحة التحكم"
        >
          <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
          <span>لوحة التحكم</span>
        </a>

        <!-- Call CTA -->
        <a
          href="#appointment"
          class="group bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer"
        >
          <i data-lucide="calendar" class="w-4 h-4"></i>
          <span>احجز موعدك</span>
        </a>

        <!-- Emergency -->
        <a
          href="tel:{{ $settings->emergency ?? '920012345' }}"
          class="relative bg-red-500 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-red-600 transition-all flex items-center gap-2 group"
        >
          <i data-lucide="phone-call" class="w-4 h-4 animate-bounce-gentle"></i>
          <span>الطوارئ</span>
          <span class="absolute -top-1 -left-1 w-3 h-3">
            <span class="absolute inset-0 bg-red-400 rounded-full animate-ping opacity-50"></span>
            <span class="absolute inset-0.5 bg-red-500 rounded-full"></span>
          </span>
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button
        id="mobile-menu-toggle-btn"
        class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-xl transition-colors"
      >
        <span id="mobile-menu-icon">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </span>
      </button>

    </div>
  </div>

  <!-- Mobile Menu -->
  <div
    id="mobile-menu-container"
    class="hidden lg:hidden transition-all duration-400 overflow-hidden"
  >
    <div class="px-4 py-5 bg-white border-t border-gray-100 space-y-1 shadow-xl">
      @foreach($navLinks as $link)
        @php
          $href = $isHomepage ? $link['href'] : (str_starts_with($link['href'], '#') ? '/' . $link['href'] : $link['href']);
          $isActive = $isDoctorsPage && $link['href'] === '/doctors';
        @endphp
        <a
          href="{{ $href }}"
          data-section="{{ $link['id'] }}"
          class="mobile-nav-anchor block px-4 py-3 rounded-xl transition-all font-medium text-sm {{ $isActive ? 'text-primary-600 bg-primary-50 font-bold' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-50' }}"
        >
          {{ $link['name'] }}
        </a>
      @endforeach
      <div class="pt-4 grid grid-cols-2 gap-3">
        <a
          href="#appointment"
          class="bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3 rounded-xl text-center font-bold text-sm flex items-center justify-center gap-2 cursor-pointer"
        >
          <i data-lucide="calendar" class="w-4 h-4"></i>
          <span>احجز موعدك</span>
        </a>
        <a
          href="tel:{{ $settings->emergency ?? '920012345' }}"
          class="bg-red-500 text-white py-3 rounded-xl text-center font-bold text-sm flex items-center justify-center gap-2"
        >
          <i data-lucide="phone-call" class="w-4 h-4"></i>
          <span>الطوارئ</span>
        </a>
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Scroll event: dynamic sticky styling
    const navbar = document.getElementById("main-navbar");
    window.addEventListener("scroll", () => {
      if (window.scrollY > 50) {
        navbar.classList.add("bg-white/95", "backdrop-blur-xl", "shadow-lg", "shadow-black/[0.05]");
        navbar.classList.remove("bg-white");
      } else {
        navbar.classList.add("bg-white");
        navbar.classList.remove("bg-white/95", "backdrop-blur-xl", "shadow-lg", "shadow-black/[0.05]");
      }
    });

    // Mobile menu toggle logic
    const menuToggle = document.getElementById("mobile-menu-toggle-btn");
    const mobileMenu = document.getElementById("mobile-menu-container");
    const menuIcon = document.getElementById("mobile-menu-icon");

    menuToggle.addEventListener("click", () => {
      const isHidden = mobileMenu.classList.toggle("hidden");
      if (isHidden) {
        menuIcon.innerHTML = '<i data-lucide="menu" class="w-5 h-5"></i>';
      } else {
        menuIcon.innerHTML = '<i data-lucide="x" class="w-5 h-5"></i>';
      }
      lucide.createIcons();
    });

    // Close mobile menu on clicking links
    document.querySelectorAll(".mobile-nav-anchor").forEach(link => {
      link.addEventListener("click", (e) => {
        const href = link.getAttribute("href");
        if (href.startsWith('#')) {
          e.preventDefault();
          const targetId = href.replace('#', '');
          const targetElement = document.getElementById(targetId);
          
          mobileMenu.classList.add("hidden");
          menuIcon.innerHTML = '<i data-lucide="menu" class="w-5 h-5"></i>';
          lucide.createIcons();

          if (targetElement) {
            const offset = 80;
            const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
            window.scrollTo({
              top: elementPosition - offset,
              behavior: "smooth"
            });
          }
        } else {
          mobileMenu.classList.add("hidden");
        }
      });
    });

    // Desktop smooth navigation scrolling and active link highlighting
    document.querySelectorAll(".nav-anchor").forEach(link => {
      link.addEventListener("click", (e) => {
        const href = link.getAttribute("href");
        if (href.startsWith('#')) {
          e.preventDefault();
          const targetId = href.replace('#', '');
          const targetElement = document.getElementById(targetId);

          if (targetElement) {
            const offset = 80;
            const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
            window.scrollTo({
              top: elementPosition - offset,
              behavior: "smooth"
            });
          }
        }
      });
    });

    // Detect active section on scroll
    window.addEventListener("scroll", () => {
      const sections = document.querySelectorAll("section[id]");
      let currentSection = "home";
      sections.forEach((section) => {
        const sectionTop = section.offsetTop - 120;
        if (window.scrollY >= sectionTop) {
          currentSection = section.getAttribute("id") || "home";
        }
      });

      document.querySelectorAll(".nav-anchor").forEach(link => {
        const secId = link.getAttribute("data-section");
        const indicator = link.querySelector(".nav-indicator");
        if (secId === currentSection) {
          link.classList.add("text-primary-600", "bg-primary-50");
          link.classList.remove("text-gray-600");
          if (indicator) indicator.classList.remove("hidden");
        } else {
          link.classList.remove("text-primary-600", "bg-primary-50");
          link.classList.add("text-gray-600");
          if (indicator) indicator.classList.add("hidden");
        }
      });
    });

    // Notifications dropdown toggle
    const notifBtn = document.getElementById("notif-toggle-btn");
    const notifDropdown = document.getElementById("notif-dropdown");

    notifBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      notifDropdown.classList.toggle("hidden");
    });

    document.addEventListener("click", (e) => {
      if (!notifDropdown.classList.contains("hidden") && !notifDropdown.contains(e.target)) {
        notifDropdown.classList.add("hidden");
      }
    });

    // Initialize/Update Dark Mode Icon
    window.updateDarkModeIcon = function() {
      const iconContainer = document.getElementById("dark-mode-icon-container");
      const isDark = document.body.classList.contains("dark-mode");
      if (isDark) {
        iconContainer.innerHTML = '<i data-lucide="sun" class="w-[18px] h-[18px]"></i>';
      } else {
        iconContainer.innerHTML = '<i data-lucide="moon" class="w-[18px] h-[18px]"></i>';
      }
      lucide.createIcons();
    };

    // Force 'Our Doctors' to redirect to /doctors and bypass any other handler/scroll
    document.querySelectorAll('[data-section="doctors"]').forEach(link => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = '/doctors';
      });
    });

    updateDarkModeIcon();
  });
</script>
