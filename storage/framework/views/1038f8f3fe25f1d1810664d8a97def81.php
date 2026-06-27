<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#0f766e">
    
    <title><?php echo $__env->yieldContent('title', 'مستشفى الشفاء الدولي | Al-Shifa International Hospital'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', $settings->description ?? 'مستشفى الشفاء الدولي يقدم أفضل الرعايات الطبية والعمليات الجراحية بأحدث التقنيات وبأيدي أمهر الاستشاريين والأطباء.'); ?>">

    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <?php if(!empty($settings->favicon)): ?>
        <link rel="icon" type="image/png" href="<?php echo e($settings->favicon); ?>">
    <?php else: ?>
        <link rel="icon" type="image/png" href="/favicon.png">
    <?php endif; ?>

    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

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
    <?php echo $__env->make('components.home.Navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- News Ticker -->
    <?php echo $__env->make('components.home.NewsTicker', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content Area -->
    <main>
      <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <?php echo $__env->make('components.home.Footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Floating Utilities -->
    <?php echo $__env->make('components.home.WhatsAppFloat', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.home.CookieBanner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
    <?php echo $__env->yieldContent('scripts'); ?>
  </body>
</html>
<?php /**PATH D:\laravel-hospital-website-development\resources\views\layouts\app.blade.php ENDPATH**/ ?>