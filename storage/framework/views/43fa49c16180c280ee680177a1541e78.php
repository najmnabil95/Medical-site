<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#0f766e">
    
    <title><?php echo $__env->yieldContent('title', 'مستشفى الشفاء الدولي | Al-Shifa International Hospital'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', $settings->description ?? 'مستشفى الشفاء الدولي يقدم أفضل الرعايات الطبية والعمليات الجراحية بأحدث التقنيات وبأيدي أمهر الاستشاريين والأطباء.'); ?>">

    <?php
      $fontFamily = $settings->font_family ?? 'Tajawal';
      $fontUrl = 'https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap';
      if ($fontFamily === 'Cairo') {
          $fontUrl = 'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap';
      } elseif ($fontFamily === 'Almarai') {
          $fontUrl = 'https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap';
      } elseif ($fontFamily === 'Alexandria') {
          $fontUrl = 'https://fonts.googleapis.com/css2?family=Alexandria:wght@100;200;300;400;500;600;700;800;900&display=swap';
      } elseif ($fontFamily === 'Amiri') {
          $fontUrl = 'https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap';
      } elseif ($fontFamily === 'Readex Pro') {
          $fontUrl = 'https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400;500;600;700&display=swap';
      }
    ?>

    <!-- Google Fonts Dynamic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?php echo e($fontUrl); ?>" rel="stylesheet">

    <!-- DNS Prefetch for external resources -->
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://images.pexels.com">

    <!-- CSS Override to enforce Font Family -->
    <style>
      *:not(i):not([class*="lucide"]) {
        font-family: '<?php echo e($fontFamily); ?>', sans-serif !important;
      }
      /* Lazy loading image fade-in */
      img[loading="lazy"] {
        opacity: 0;
        transition: opacity 0.4s ease-in;
      }
      img[loading="lazy"].loaded, img[loading="lazy"][complete] {
        opacity: 1;
      }
    </style>

    <!-- Favicon -->
    <?php if(!empty($settings->favicon)): ?>
        <link rel="icon" type="image/png" href="<?php echo e($settings->favicon); ?>">
    <?php else: ?>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
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
    <script src="https://unpkg.com/lucide@latest" defer></script>
  </head>
  <body class="min-h-screen bg-white font-tajawal antialiased text-gray-900 transition-colors duration-300">
    
    <!-- Progress Indicator -->
    <div id="scroll-progress-bar" class="fixed top-0 right-0 h-1 bg-linear-to-l from-emerald-500 to-cyan-500 z-9999 transition-all duration-100" style="width: 0%;"></div>

    <?php
      $showNewsTicker = false;
      try {
          if (isset($screens)) {
              $showNewsTicker = $screens->contains('component', 'NewsTicker');
          } else {
              $showNewsTicker = \App\Models\Screen::where('component', 'NewsTicker')->where('enabled', 1)->exists();
          }
      } catch (\Exception $e) {
          $showNewsTicker = false;
      }
    ?>

    <?php
      $isDoctorsPage = Request::is('doctors') || Request::is('doctors/*');
    ?>

    <?php if(!$isDoctorsPage): ?>
      <!-- Main Header / Navbar -->
      <?php echo $__env->make('components.home.Navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <?php if($showNewsTicker): ?>
        <!-- News Ticker -->
        <?php echo $__env->make('components.home.NewsTicker', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endif; ?>
    <?php endif; ?>

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

      // Global function to prefill and scroll to appointment
      window.prefillAppointment = function(deptName, docName) {
        // Close all department modals if they exist
        const modals = document.querySelectorAll('[id^="dept-modal-"]');
        modals.forEach(modal => modal.classList.add('hidden'));
        document.body.style.overflow = '';

        // Scroll to the appointment section
        const appointmentSection = document.getElementById('appointment');
        if (appointmentSection) {
          const offset = 80;
          const elementPosition = appointmentSection.getBoundingClientRect().top + window.pageYOffset;
          window.scrollTo({
            top: elementPosition - offset,
            behavior: "smooth"
          });
        } else {
          // If not on homepage, redirect to homepage with params
          window.location.href = `/?dept=${encodeURIComponent(deptName)}&doc=${encodeURIComponent(docName)}`;
          return;
        }

        // Prefill the form fields
        setTimeout(() => {
          const deptSelect = document.querySelector('select[name="department"]');
          const docSelect = document.querySelector('select[name="doctor"]');

          if (deptSelect) {
            deptSelect.value = deptName;
            deptSelect.dispatchEvent(new Event('change'));
          }

          if (docSelect && docName) {
            setTimeout(() => {
              docSelect.value = docName;
            }, 100);
          }
        }, 500);
      };

      // Dark Mode Toggler Logic
      function toggleDarkMode() {
        const body = document.body;
        const isDark = body.classList.toggle('dark-mode');
        document.documentElement.classList.toggle('dark', isDark);
        localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
      }

      // Flash Messages auto-dismiss & Url Pre-fill appointment parameters
      document.addEventListener("DOMContentLoaded", () => {
        // Initialize lucide icons (handles deferred script)
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        } else {
          // If lucide hasn't loaded yet (deferred), wait for it
          const checkLucide = setInterval(() => {
            if (typeof lucide !== 'undefined') {
              lucide.createIcons();
              clearInterval(checkLucide);
            }
          }, 50);
          setTimeout(() => clearInterval(checkLucide), 5000);
        }

        // Lazy loading image fade-in observer
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
          if (img.complete) {
            img.classList.add('loaded');
          } else {
            img.addEventListener('load', () => img.classList.add('loaded'));
          }
        });

        const alert = document.querySelector('[role="alert-flash"]');
        if (alert) {
          setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
          }, 4000);
        }

        // Smooth scroll to hash on load if present (navigating back from other pages)
        if (window.location.hash) {
          const targetId = window.location.hash.replace('#', '');
          setTimeout(() => {
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
              const offset = 85;
              const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
              window.scrollTo({
                top: elementPosition - offset,
                behavior: "smooth"
              });
            }
          }, 400);
        }

        // Prefill Appointment parameters if redirected from doctors page
        const urlParams = new URLSearchParams(window.location.search);
        const urlDept = urlParams.get('dept');
        const urlDoc = urlParams.get('doc');
        if (urlDept || urlDoc) {
          setTimeout(() => {
            const appointmentSection = document.getElementById('appointment');
            if (appointmentSection) {
              const offset = 80;
              const elementPosition = appointmentSection.getBoundingClientRect().top + window.pageYOffset;
              window.scrollTo({
                top: elementPosition - offset,
                behavior: "smooth"
              });
            }

            const deptSelect = document.querySelector('select[name="department"]');
            if (deptSelect && urlDept) {
              deptSelect.value = urlDept;
              deptSelect.dispatchEvent(new Event('change'));
            }

            setTimeout(() => {
              const docSelect = document.querySelector('select[name="doctor"]');
              if (docSelect && urlDoc) {
                docSelect.value = urlDoc;
                docSelect.dispatchEvent(new Event('change'));
              }
            }, 350);
          }, 800);
        }
      });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
  </body>
</html>
<?php /**PATH D:\laravel-hospital-website-development\resources\views/layouts/app.blade.php ENDPATH**/ ?>