<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f766e">
    
    <title>@yield('title', 'مستشفى الشفاء الدولي | Al-Shifa International Hospital')</title>
    <meta name="description" content="@yield('description', $settings->description ?? 'مستشفى الشفاء الدولي يقدم أفضل الرعايات الطبية والعمليات الجراحية بأحدث التقنيات وبأيدي أمهر الاستشاريين والأطباء.')">

    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    @if(!empty($settings->favicon))
        <link rel="icon" type="image/png" href="{{ $settings->favicon }}">
    @else
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @endif

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline Dark Mode Toggle Guard (Prevents Flicker) -->
    <script>
      if (localStorage.getItem('dark-mode') === 'true' || 
          (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        document.addEventListener("DOMContentLoaded", function() {
          document.body.classList.add('dark-mode');
        });
      } else {
        document.documentElement.classList.remove('dark');
      }
    </script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
  </head>
  <body class="min-h-screen bg-white font-tajawal antialiased text-gray-900 transition-colors duration-300">
    
    <!-- Progress Indicator -->
    <div id="scroll-progress-bar" class="fixed top-0 right-0 h-1 bg-gradient-to-l from-emerald-500 to-cyan-500 z-[9999] transition-all duration-100" style="width: 0%;"></div>

    <!-- Main Header / Navbar -->
    @include('components.home.Navbar')

    <!-- News Ticker -->
    @include('components.home.NewsTicker')

    <!-- Main Content Area -->
    <main>
      @yield('content')
    </main>

    <!-- Footer -->
    @include('components.home.Footer')

    <!-- Floating Utilities -->
    @include('components.home.WhatsAppFloat')
    @include('components.home.CookieBanner')

    <!-- Global Client JS -->
    <script>
      // Scroll Progress Indicator
      window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById('scroll-progress-bar').style.width = scrolled + '%';
      });

      // Dark Mode Toggler Logic
      function toggleDarkMode() {
        const body = document.body;
        const isDark = body.classList.toggle('dark-mode');
        document.documentElement.classList.toggle('dark', isDark);
        localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
      }

      // Flash Messages auto-dismiss
      document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
        const alert = document.querySelector('[role="alert-flash"]');
        if (alert) {
          setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
          }, 4000);
        }
      });
    </script>
    @yield('scripts')
  </body>
</html>
