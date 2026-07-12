<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> - <?php echo e($settings->site_name ?? 'مستشفى الشفاء الدولي'); ?></title>
    
    <!-- Favicon -->
    <?php if(!empty($settings->favicon)): ?>
        <link rel="icon" type="image/png" href="<?php echo e($settings->favicon); ?>">
    <?php else: ?>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <?php endif; ?>

    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

    <!-- CSS Override to enforce Font Family -->
    <style>
      *:not(i):not([class*="lucide"]) {
        font-family: '<?php echo e($fontFamily); ?>', sans-serif !important;
      }
    </style>

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  </head>
  <body class="min-h-screen bg-gray-50 font-tajawal antialiased text-gray-900">

    <div class="min-h-screen flex" dir="rtl">
      
      <!-- Sidebar -->
      <aside
        id="admin-sidebar"
        class="fixed top-0 right-0 h-screen w-72 bg-white border-l border-gray-200 shadow-xl z-40 transition-transform duration-300 lg:translate-x-0 translate-x-full lg:block"
      >
        <!-- Logo Header -->
        <div class="h-16 px-6 flex items-center justify-between border-b border-gray-100">
          <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-gray-100 shadow-md p-1 overflow-hidden shrink-0">
              <?php if(!empty($settings->logo)): ?>
                <?php if(str_starts_with($settings->logo, 'http') || str_starts_with($settings->logo, 'data:')): ?>
                  <img src="<?php echo e($settings->logo); ?>" alt="Logo" class="w-full h-full object-contain" />
                <?php else: ?>
                  <span class="text-primary-600 text-base font-bold"><?php echo e($settings->logo); ?></span>
                <?php endif; ?>
              <?php else: ?>
                <span class="text-white text-base font-bold">🏥</span>
              <?php endif; ?>
            </div>
            <div class="text-right">
              <h1 class="text-base font-bold text-primary-700 leading-tight"><?php echo e($settings->site_name ?? 'مستشفى الشفاء'); ?></h1>
              <p class="text-[9px] text-gray-400 tracking-wider">لوحة التحكم</p>
            </div>
          </a>
          <button onclick="toggleSidebar(false)" class="lg:hidden text-gray-500 hover:text-gray-700">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="p-4 overflow-y-auto h-[calc(100vh-8rem)] space-y-4">
          
          <!-- لوحة التحكم -->
          <div>
            <a
              href="<?php echo e(route('admin.dashboard')); ?>"
              class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(Route::currentRouteName() === 'admin.dashboard' ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
            >
              <i data-lucide="layout-dashboard" class="w-4.5 h-4.5"></i>
              <span class="flex-1 text-right">لوحة القيادة</span>
            </a>
          </div>

          <?php if(auth()->user()->hasRole('Doctor')): ?>
          <!-- قسم الطبيب -->
          <div>
            <p class="text-[10px] font-bold text-gray-400 mb-2 px-3 tracking-wider text-right uppercase">منطقة الطبيب</p>
            <div class="space-y-1">
              <a
                href="<?php echo e(route('doctor.appointments.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'doctor.appointments') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="stethoscope" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">مواعيدي</span>
              </a>
            </div>
          </div>
          <?php endif; ?>

          <!-- قسم العمليات -->
          <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Manager|Reception|Nurse')): ?>
          <div>
            <p class="text-[10px] font-bold text-gray-400 mb-2 px-3 tracking-wider text-right uppercase">العمليات والطلبات</p>
            <div class="space-y-1">
              <a
                href="<?php echo e(route('admin.appointments.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.appointments') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="calendar" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">الحجوزات</span>
              </a>
              <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Manager|Reception')): ?>
              <a
                href="<?php echo e(route('admin.messages.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.messages') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="mail" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">رسائل التواصل</span>
              </a>
              <a
                href="<?php echo e(route('admin.notifications.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.notifications') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="bell" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">سجل الإشعارات</span>
              </a>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>

          <!-- قسم الإدارة الطبية -->
          <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Manager|Editor')): ?>
          <div>
            <p class="text-[10px] font-bold text-gray-400 mb-2 px-3 tracking-wider text-right uppercase">الإدارة الطبية</p>
            <div class="space-y-1">
              <a
                href="<?php echo e(route('admin.doctors.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.doctors') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="user-cog" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">الأطباء</span>
              </a>
              <a
                href="<?php echo e(route('admin.departments.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.departments') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="hospital" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">الأقسام الطبية</span>
              </a>
              <a
                href="<?php echo e(route('admin.services.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.services') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="activity" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">الخدمات</span>
              </a>
            </div>
          </div>
          <?php endif; ?>

          <!-- الخدمات والأسعار -->
          <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Manager|Accountant')): ?>
          <div>
            <p class="text-[10px] font-bold text-gray-400 mb-2 px-3 tracking-wider text-right uppercase">الخدمات والأسعار</p>
            <div class="space-y-1">
              <a
                href="<?php echo e(route('admin.packages.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.packages') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="package" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">باقات الكشف</span>
              </a>
              <a
                href="<?php echo e(route('admin.prices.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.prices') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="dollar-sign" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">قائمة الأسعار</span>
              </a>
              <a
                href="<?php echo e(route('admin.insurances.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.insurances') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="shield-check" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">شركات التأمين</span>
              </a>
            </div>
          </div>
          <?php endif; ?>

          <!-- الإعلام والمحتوى -->
          <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Manager|Editor')): ?>
          <div>
            <p class="text-[10px] font-bold text-gray-400 mb-2 px-3 tracking-wider text-right uppercase">المحتوى والشهادات</p>
            <div class="space-y-1">
              <a
                href="<?php echo e(route('admin.news.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.news') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="newspaper" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">المقالات والأخبار</span>
              </a>
              <a
                href="<?php echo e(route('admin.faqs.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.faqs') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="help-circle" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">الأسئلة الشائعة</span>
              </a>
              <a
                href="<?php echo e(route('admin.testimonials.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.testimonials') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="message-square" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">آراء المرضى</span>
              </a>
              <a
                href="<?php echo e(route('admin.partners.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.partners') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="handshake" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">شركاء النجاح</span>
              </a>
              <a
                href="<?php echo e(route('admin.certifications.index')); ?>"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.certifications') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
              >
                <i data-lucide="award" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">شهادات الاعتماد</span>
              </a>
            </div>
          </div>
          <?php endif; ?>

          <!-- إدارة النظام -->
          <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Manager')): ?>
          <div>
            <p class="text-[10px] font-bold text-gray-400 mb-2 px-3 tracking-wider text-right uppercase">إدارة النظام</p>
            <div class="space-y-1">
              <?php if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Manager')): ?>
                <a
                  href="<?php echo e(route('admin.users.index')); ?>"
                  class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.users') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
                >
                  <i data-lucide="users" class="w-4.5 h-4.5"></i>
                  <span class="flex-1 text-right">المستخدمون</span>
                </a>
              <?php endif; ?>
              <?php if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Manager')): ?>
                <a
                  href="<?php echo e(route('admin.reports.index')); ?>"
                  class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.reports') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
                >
                  <i data-lucide="bar-chart-3" class="w-4.5 h-4.5"></i>
                  <span class="flex-1 text-right">التقارير</span>
                </a>
              <?php endif; ?>
              <?php if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Manager')): ?>
                <a
                  href="<?php echo e(route('admin.screens.index')); ?>"
                  class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.screens') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
                >
                  <i data-lucide="monitor" class="w-4.5 h-4.5"></i>
                  <span class="flex-1 text-right">أقسام العرض (Screens)</span>
                </a>
              <?php endif; ?>
              <?php if(Auth::user()->hasRole('Super Admin')): ?>
                <a
                  href="<?php echo e(route('admin.activity-logs.index')); ?>"
                  class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.activity-logs') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
                >
                  <i data-lucide="history" class="w-4.5 h-4.5"></i>
                  <span class="flex-1 text-right">سجل النشاطات</span>
                </a>
                <a
                  href="<?php echo e(route('admin.settings.index')); ?>"
                  class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(str_starts_with(Route::currentRouteName(), 'admin.settings') ? 'bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-primary-600'); ?>"
                >
                  <i data-lucide="settings" class="w-4.5 h-4.5"></i>
                  <span class="flex-1 text-right">إعدادات الموقع</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
            
          <!-- Divider inside nav -->
          <div class="h-px bg-gray-100 my-4"></div>

          <div>
            <div class="px-2 space-y-1">
              <a
                href="/"
                class="flex items-center gap-3 px-4 py-2.5 bg-gradient-to-l from-emerald-500 to-emerald-600 text-white rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-emerald-500/20 transition-all hover:-translate-y-0.5"
              >
                <i data-lucide="home" class="w-4.5 h-4.5"></i>
                <span class="flex-1 text-right">زيارة الموقع</span>
              </a>
            </div>
          </div>
          
        </nav>

        <!-- Logout Panel -->
        <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-gray-100 bg-white">
          <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form">
            <?php echo csrf_field(); ?>
            <button
              type="submit"
              class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-all cursor-pointer"
            >
              <i data-lucide="log-out" class="w-4.5 h-4.5"></i>
              <span class="text-right flex-1">تسجيل الخروج</span>
            </button>
          </form>
        </div>
      </aside>

      <!-- Sidebar Mobile Overlay -->
      <div
        id="admin-sidebar-overlay"
        onclick="toggleSidebar(false)"
        class="hidden fixed inset-0 bg-black/50 z-30 lg:hidden"
      ></div>

      <!-- Main Layout Body Container -->
      <div class="flex-1 lg:mr-72">
        <!-- Top bar header -->
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30 shadow-sm">
          <div class="flex items-center gap-4">
            <button
              onclick="toggleSidebar(true)"
              class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-xl"
            >
              <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div class="hidden md:flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl w-80 border border-gray-100">
              <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
              <input
                type="text"
                placeholder="بحث سريع..."
                class="bg-transparent outline-none flex-1 text-sm text-right"
              />
            </div>
          </div>

          <div class="flex items-center gap-3">
            <!-- Return to Main Site Button -->
            <a
              href="/"
              class="flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-xl text-sm font-bold border border-gray-200/60 transition-all hover:shadow-sm"
              title="العودة للموقع الرئيسي"
            >
              <i data-lucide="external-link" class="w-4 h-4 text-gray-500"></i>
              <span class="hidden sm:inline">الموقع الرئيسي</span>
            </a>

            <!-- Notification Bell -->
            <?php
              $headerPendingCount = \App\Models\Appointment::where('status', 'pending')->count();
              $headerUnreadMessages = \App\Models\Message::where('status', 'new')->count();
              $headerTotalBadge = $headerPendingCount + $headerUnreadMessages;
            ?>
            <div class="relative">
              <button
                onclick="toggleNotificationPanel()"
                class="relative p-2.5 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all cursor-pointer"
                title="الإشعارات"
              >
                <i data-lucide="bell" class="w-5 h-5"></i>
                <?php if($headerTotalBadge > 0): ?>
                  <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-rose-500 text-white text-[10px] font-black rounded-full flex items-center justify-center animate-pulse shadow-md"><?php echo e(min($headerTotalBadge, 99)); ?></span>
                <?php endif; ?>
              </button>

              <!-- Notification Dropdown Panel -->
              <div id="notification-panel" class="hidden absolute left-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-50 flex items-center justify-between">
                  <h4 class="font-black text-gray-900 text-sm">الإشعارات</h4>
                  <?php if($headerTotalBadge > 0): ?>
                    <span class="text-xs font-bold bg-rose-50 text-rose-600 px-2 py-0.5 rounded-full"><?php echo e($headerTotalBadge); ?> جديد</span>
                  <?php endif; ?>
                </div>

                <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                  <?php if($headerPendingCount > 0): ?>
                  <a href="<?php echo e(route('admin.appointments.index')); ?>" class="flex items-start gap-3 px-5 py-3.5 hover:bg-primary-50/50 transition-colors">
                    <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                      <i data-lucide="calendar-clock" class="w-4.5 h-4.5 text-amber-600"></i>
                    </div>
                    <div>
                      <p class="text-sm font-bold text-gray-800">حجوزات قيد الانتظار</p>
                      <p class="text-xs text-gray-400 mt-0.5">يوجد <span class="font-bold text-amber-600"><?php echo e($headerPendingCount); ?></span> حجز بحاجة للتأكيد</p>
                    </div>
                  </a>
                  <?php endif; ?>

                  <?php if($headerUnreadMessages > 0): ?>
                  <a href="<?php echo e(route('admin.messages.index')); ?>" class="flex items-start gap-3 px-5 py-3.5 hover:bg-primary-50/50 transition-colors">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                      <i data-lucide="mail" class="w-4.5 h-4.5 text-blue-600"></i>
                    </div>
                    <div>
                      <p class="text-sm font-bold text-gray-800">رسائل جديدة</p>
                      <p class="text-xs text-gray-400 mt-0.5">يوجد <span class="font-bold text-blue-600"><?php echo e($headerUnreadMessages); ?></span> رسالة غير مقروءة</p>
                    </div>
                  </a>
                  <?php endif; ?>

                  <?php if($headerTotalBadge === 0): ?>
                  <div class="px-5 py-8 text-center">
                    <i data-lucide="bell-off" class="w-8 h-8 text-gray-200 mx-auto mb-2"></i>
                    <p class="text-xs text-gray-400 font-medium">لا توجد إشعارات جديدة</p>
                  </div>
                  <?php endif; ?>
                </div>

                <div class="px-5 py-2.5 border-t border-gray-50 bg-gray-50/50">
                  <a href="<?php echo e(route('admin.notifications.index')); ?>" class="text-xs font-bold text-primary-600 hover:text-primary-700 transition-colors">عرض جميع الإشعارات ←</a>
                </div>
              </div>
            </div>

            <!-- Profile dropdown and info -->
            <div class="relative">
              <button
                onclick="toggleProfileMenu()"
                class="flex items-center gap-3 p-1.5 pr-4 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer"
              >
                <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                  <?php echo e(substr(Auth::user()->name, 0, 2)); ?>

                </div>
                <div class="hidden md:block text-right">
                  <p class="text-sm font-bold text-gray-800"><?php echo e(Auth::user()->name); ?></p>
                  <p class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                </div>
                <i data-lucide="chevron-down" class="text-gray-400 w-4 h-4"></i>
              </button>

              <div id="profile-dropdown-menu" class="hidden absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-20">
                <button
                  onclick="document.getElementById('logout-form').submit()"
                  class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-right cursor-pointer"
                >
                  <i data-lucide="log-out" class="w-4 h-4"></i>
                  <span>تسجيل الخروج</span>
                </button>
              </div>
            </div>
          </div>
        </header>

        <!-- Main Page Layout Content Area -->
        <main class="p-4 lg:p-8">
          
          <!-- Alert Success/Error Messages -->
          <?php if(session('success')): ?>
            <div class="mb-6 bg-emerald-50 border-r-4 border-emerald-500 rounded-xl p-4 flex items-start gap-3">
              <i data-lucide="check-circle" class="text-emerald-600 shrink-0 mt-0.5 w-[18px] h-[18px]"></i>
              <span class="text-sm text-emerald-800"><?php echo e(session('success')); ?></span>
            </div>
          <?php endif; ?>
          <?php if(session('error')): ?>
            <div class="mb-6 bg-red-50 border-r-4 border-red-500 rounded-xl p-4 flex items-start gap-3">
              <i data-lucide="alert-circle" class="text-red-600 shrink-0 mt-0.5 w-[18px] h-[18px]"></i>
              <span class="text-sm text-red-800"><?php echo e(session('error')); ?></span>
            </div>
          <?php endif; ?>

          <?php echo $__env->yieldContent('content'); ?>
        </main>
      </div>

    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
        
        // Scroll active sidebar item into view
        const activeItem = document.querySelector("#admin-sidebar nav .bg-gradient-to-l");
        if (activeItem) {
          activeItem.scrollIntoView({ block: "nearest", behavior: "smooth" });
        }
      });

      function toggleSidebar(open) {
        const sidebar = document.getElementById("admin-sidebar");
        const overlay = document.getElementById("admin-sidebar-overlay");
        if (open) {
          sidebar.classList.remove("translate-x-full");
          sidebar.classList.add("translate-x-0");
          overlay.classList.remove("hidden");
        } else {
          sidebar.classList.remove("translate-x-0");
          sidebar.classList.add("translate-x-full");
          overlay.classList.add("hidden");
        }
      }

      function toggleProfileMenu() {
        const menu = document.getElementById("profile-dropdown-menu");
        menu.classList.toggle("hidden");
        // Close notification panel when opening profile
        document.getElementById("notification-panel")?.classList.add("hidden");
      }

      function toggleNotificationPanel() {
        const panel = document.getElementById("notification-panel");
        panel.classList.toggle("hidden");
        // Close profile menu when opening notifications
        document.getElementById("profile-dropdown-menu")?.classList.add("hidden");
      }

      // Close dropdowns if click is outside
      window.addEventListener("click", (e) => {
        const menu = document.getElementById("profile-dropdown-menu");
        if (menu && !menu.classList.contains("hidden")) {
          const trigger = menu.previousElementSibling;
          if (!trigger.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add("hidden");
          }
        }

        const notifPanel = document.getElementById("notification-panel");
        if (notifPanel && !notifPanel.classList.contains("hidden")) {
          const notifTrigger = notifPanel.previousElementSibling;
          if (!notifTrigger.contains(e.target) && !notifPanel.contains(e.target)) {
            notifPanel.classList.add("hidden");
          }
        }
      });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
  </body>
</html>
<?php /**PATH D:\laravel-hospital-website-development\resources\views/layouts/admin.blade.php ENDPATH**/ ?>