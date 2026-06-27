<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة تحكم مستشفى الشفاء الدولي</title>
    
    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  </head>
  <body class="min-h-screen bg-[#0f172a] font-tajawal antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-900 via-primary-800 to-gray-900 p-4 relative overflow-hidden">
      <!-- Decorative background blur elements -->
      <div class="absolute top-20 left-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 right-20 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl"></div>

      <div class="w-full max-w-md relative">
        <!-- Logo -->
        <div class="text-center mb-8">
          <div class="inline-flex items-center gap-3 mb-6">
            <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center shadow-2xl shadow-primary-500/30">
              <span class="text-white text-xl">🏥</span>
            </div>
            <div class="text-right">
              <h1 class="text-2xl font-bold text-white">مستشفى الشفاء</h1>
              <p class="text-xs text-white/40 tracking-wider">لوحة التحكم</p>
            </div>
          </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8">
          <h2 class="text-xl font-bold text-gray-800 mb-2">مرحباً بعودتك 👋</h2>
          <p class="text-sm text-gray-500 mb-6">سجل دخولك للوصول إلى لوحة التحكم</p>

          <!-- Error Alert Banner -->
          <?php if($errors->any()): ?>
            <div class="mb-5 bg-red-50 border-r-4 border-red-500 rounded-xl p-4 flex items-start gap-3">
              <i data-lucide="alert-circle" class="text-red-600 shrink-0 mt-0.5 w-[18px] h-[18px]"></i>
              <div>
                <p class="text-xs text-red-700 font-bold leading-normal">فشل تسجيل الدخول</p>
                <p class="text-xs text-red-600 mt-1 leading-relaxed"><?php echo e($errors->first()); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <form action="/login" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">اسم المستخدم</label>
              <div class="relative">
                <input
                  type="text"
                  name="username"
                  value="<?php echo e(old('username')); ?>"
                  required
                  class="w-full px-4 py-3 pr-10 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm text-right"
                  placeholder="admin"
                />
                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                  <i data-lucide="user" class="w-[18px] h-[18px]"></i>
                </div>
              </div>
            </div>

            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور</label>
              <div class="relative">
                <input
                  type="password"
                  name="password"
                  id="login-password-field"
                  required
                  class="w-full px-4 py-3 pr-4 pl-12 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm text-right"
                  placeholder="••••••••"
                />
                <button
                  type="button"
                  onclick="togglePasswordVisibility()"
                  class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                >
                  <span id="password-eye-icon">
                    <i data-lucide="eye" class="w-[18px] h-[18px]"></i>
                  </span>
                </button>
              </div>
            </div>

            <!-- Remember me checkbox -->
            <div class="flex items-center justify-between text-xs">
              <label class="flex items-center gap-2 cursor-pointer text-gray-500 font-medium">
                <input type="checkbox" name="remember" class="rounded text-primary-600 focus:ring-primary-500" <?php echo e(old('remember') ? 'checked' : ''); ?> />
                <span>تذكرني على هذا الجهاز</span>
              </label>
            </div>

            <button
              type="submit"
              class="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3.5 rounded-xl font-bold hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer"
            >
              <i data-lucide="log-in" class="w-[18px] h-[18px]"></i>
              <span>تسجيل الدخول</span>
            </button>
          </form>

          <a
            href="/"
            class="w-full mt-4 bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center justify-center gap-2 text-center"
          >
            <i data-lucide="home" class="w-[18px] h-[18px]"></i>
            <span>العودة إلى الموقع الرئيسي</span>
          </a>

          <div class="mt-6 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
            <p class="text-xs text-blue-600 font-bold mb-1">💡 بيانات الدخول الافتراضية:</p>
            <p class="text-xs text-blue-500">اسم المستخدم: <span class="font-bold">admin</span></p>
            <p class="text-xs text-blue-500">كلمة المرور: <span class="font-bold">admin123</span></p>
            <p class="text-xs text-blue-400 mt-2 font-medium">يمكنك إضافة مستخدمين جدد من صفحة "المستخدمون" في لوحة التحكم</p>
          </div>
        </div>

        <p class="text-center text-white/35 text-xs mt-6">© 2024 مستشفى الشفاء الدولي</p>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
      });

      function togglePasswordVisibility() {
        const passwordField = document.getElementById("login-password-field");
        const iconContainer = document.getElementById("password-eye-icon");

        if (passwordField.type === "password") {
          passwordField.type = "text";
          iconContainer.innerHTML = '<i data-lucide="eye-off" class="w-[18px] h-[18px]"></i>';
        } else {
          passwordField.type = "password";
          iconContainer.innerHTML = '<i data-lucide="eye" class="w-[18px] h-[18px]"></i>';
        }
        lucide.createIcons();
      }
    </script>
  </body>
</html>
<?php /**PATH D:\laravel-hospital-website-development\hospital-backend\resources\views/auth/login.blade.php ENDPATH**/ ?>