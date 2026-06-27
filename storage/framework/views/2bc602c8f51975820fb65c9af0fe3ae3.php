<?php $__env->startSection('title', 'لوحة التحكم - مستشفى الشفاء الدولي'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-right">
  <div>
    <h1 class="text-2xl font-black text-gray-900 leading-tight">
      مرحباً،
      <span class="text-primary-600"><?php echo e(Auth::user()->name); ?></span> 👋
    </h1>
    <p class="text-gray-400 text-sm mt-1 font-medium">
      <?php echo e(\Carbon\Carbon::now()->locale('ar')->isoFormat('dddd، D MMMM YYYY')); ?>

      — نظرة عامة على أداء المستشفى
    </p>
  </div>
  <a href="/" target="_blank"
    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:border-primary-400 hover:text-primary-600 hover:shadow-md transition-all">
    <i data-lucide="external-link" class="w-4 h-4"></i>
    <span>زيارة الموقع</span>
  </a>
</div>


<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-7">

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-400/5 to-amber-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
        <i data-lucide="clock" class="w-6 h-6 text-amber-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-amber-50 text-amber-600 rounded-lg">انتظار</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($stats['pending_appointments']); ?></p>
    <p class="text-xs text-gray-400 font-semibold">حجوزات قيد الانتظار</p>
  </div>

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-400/5 to-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center group-hover:bg-primary-100 transition-colors">
        <i data-lucide="calendar-check" class="w-6 h-6 text-primary-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-primary-50 text-primary-600 rounded-lg">اليوم</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($stats['today_appointments']); ?></p>
    <p class="text-xs text-gray-400 font-semibold">حجوزات اليوم</p>
  </div>

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/5 to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
        <i data-lucide="stethoscope" class="w-6 h-6 text-emerald-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg">نشط</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($stats['total_doctors']); ?></p>
    <p class="text-xs text-gray-400 font-semibold">الأطباء النشطون</p>
  </div>

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-rose-400/5 to-rose-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center group-hover:bg-rose-100 transition-colors">
        <i data-lucide="mail-open" class="w-6 h-6 text-rose-500"></i>
      </div>
      <?php if($stats['unread_messages'] > 0): ?>
        <span class="text-xs font-bold px-2 py-1 bg-rose-500 text-white rounded-lg animate-pulse">جديد</span>
      <?php endif; ?>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($stats['unread_messages']); ?></p>
    <p class="text-xs text-gray-400 font-semibold">رسائل لم تُقرأ</p>
  </div>

</div>


<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-7">

  
  <div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 rounded-2xl p-6 text-white shadow-lg shadow-primary-500/20 relative overflow-hidden">
    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/5 rounded-full"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <i data-lucide="trending-up" class="w-6 h-6 text-primary-200"></i>
        <span class="text-xs font-bold bg-white/20 px-3 py-1 rounded-full">إجمالي</span>
      </div>
      <p class="text-4xl font-black tabular-nums mb-2"><?php echo e($stats['total_appointments']); ?></p>
      <p class="text-primary-200 text-sm font-medium">مجموع الحجوزات المسجلة</p>
    </div>
  </div>

  
  <div class="bg-gradient-to-br from-violet-600 via-violet-700 to-violet-900 rounded-2xl p-6 text-white shadow-lg shadow-violet-500/20 relative overflow-hidden">
    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/5 rounded-full"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <i data-lucide="grid-3x3" class="w-6 h-6 text-violet-200"></i>
        <span class="text-xs font-bold bg-white/20 px-3 py-1 rounded-full">قسم</span>
      </div>
      <p class="text-4xl font-black tabular-nums mb-2"><?php echo e($stats['total_departments']); ?></p>
      <p class="text-violet-200 text-sm font-medium">الأقسام الطبية النشطة</p>
    </div>
  </div>

  
  <div class="bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900 rounded-2xl p-6 text-white shadow-lg shadow-slate-700/20 relative overflow-hidden">
    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/5 rounded-full"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <i data-lucide="shield-check" class="w-6 h-6 text-slate-300"></i>
        <span class="text-xs font-bold bg-white/20 px-3 py-1 rounded-full">مسؤول</span>
      </div>
      <p class="text-4xl font-black tabular-nums mb-2"><?php echo e($stats['total_users']); ?></p>
      <p class="text-slate-300 text-sm font-medium">مستخدمو النظام</p>
    </div>
  </div>

</div>


<div class="grid lg:grid-cols-3 gap-6">

  
  <div class="lg:col-span-2 space-y-6">

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 text-right">
        <div>
          <h3 class="font-black text-gray-900 text-lg">مخطط الحجوزات</h3>
          <p class="text-xs text-gray-400 mt-0.5">آخر 30 يوماً</p>
        </div>
        <div class="flex items-center gap-2">
          <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded-full bg-primary-500 inline-block"></span>
            <span class="text-xs text-gray-500 font-medium">الحجوزات اليومية</span>
          </div>
        </div>
      </div>
      <div class="relative h-64">
        <canvas id="bookingsChart"></canvas>
        <?php if(empty($stats['chart_counts'])): ?>
          <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
            <i data-lucide="bar-chart-2" class="w-14 h-14 mb-3 opacity-40"></i>
            <p class="text-sm font-medium text-gray-400">لا توجد بيانات حجوزات للفترة الحالية</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
        <h3 class="font-black text-gray-900 text-base">أحدث الحجوزات</h3>
        <span class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1 rounded-full">آخر 5 طلبات</span>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full" dir="rtl">
          <thead>
            <tr class="bg-gray-50/60 text-gray-400 text-xs font-bold uppercase tracking-wider">
              <th class="px-6 py-3 text-right">المريض</th>
              <th class="px-6 py-3 text-right">القسم</th>
              <th class="px-6 py-3 text-right">الموعد</th>
              <th class="px-6 py-3 text-right">الحالة</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $stats['recent_appointments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center text-primary-700 font-black text-sm shrink-0">
                      <?php echo e(mb_substr($app->patient_name, 0, 1)); ?>

                    </div>
                    <div>
                      <p class="font-bold text-gray-900 text-sm"><?php echo e($app->patient_name); ?></p>
                      <p class="text-xs text-gray-400" dir="ltr"><?php echo e($app->phone); ?></p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span class="text-sm text-gray-700 font-medium"><?php echo e($app->department); ?></span>
                </td>
                <td class="px-6 py-4">
                  <p class="text-sm font-semibold text-gray-800"><?php echo e($app->date); ?></p>
                  <p class="text-xs text-gray-400 mt-0.5"><?php echo e($app->time); ?></p>
                </td>
                <td class="px-6 py-4">
                  <?php
                    $statusConfig = match($app->status) {
                      'pending'   => ['label' => 'انتظار',    'class' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200'],
                      'confirmed' => ['label' => 'مؤكد',     'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'],
                      'cancelled' => ['label' => 'ملغي',     'class' => 'bg-red-50 text-red-700 ring-1 ring-red-200'],
                      default     => ['label' => 'مكتمل',   'class' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200'],
                    };
                  ?>
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold <?php echo e($statusConfig['class']); ?>">
                    <?php echo e($statusConfig['label']); ?>

                  </span>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="4" class="text-center py-12 text-gray-300">
                  <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-3 opacity-50"></i>
                  <p class="text-sm text-gray-400">لا توجد حجوزات مستلمة مؤخراً</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  
  <div class="lg:col-span-1 space-y-5">

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <h3 class="font-black text-gray-900 text-base mb-4 flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse inline-block"></span>
        حالة النظام
      </h3>
      <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
          <div class="flex items-center gap-2">
            <i data-lucide="server" class="w-4 h-4 text-emerald-600"></i>
            <span class="text-xs font-semibold text-emerald-800">الخادم</span>
          </div>
          <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-lg">يعمل</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
          <div class="flex items-center gap-2">
            <i data-lucide="database" class="w-4 h-4 text-emerald-600"></i>
            <span class="text-xs font-semibold text-emerald-800">قاعدة البيانات</span>
          </div>
          <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-lg">متصل</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-primary-50 rounded-xl">
          <div class="flex items-center gap-2">
            <i data-lucide="cpu" class="w-4 h-4 text-primary-600"></i>
            <span class="text-xs font-semibold text-primary-800">Laravel</span>
          </div>
          <span class="text-xs font-bold text-primary-700 bg-primary-100 px-2 py-0.5 rounded-lg">v11</span>
        </div>
      </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <h3 class="font-black text-gray-900 text-base mb-4">ملخص سريع</h3>
      <div class="space-y-4">

        
        <?php
          $confirmedRatio = $stats['total_appointments'] > 0
            ? round((($stats['total_appointments'] - $stats['pending_appointments']) / $stats['total_appointments']) * 100)
            : 0;
        ?>
        <div>
          <div class="flex justify-between items-center mb-1.5">
            <span class="text-xs font-bold text-gray-700">نسبة الحجوزات المؤكدة</span>
            <span class="text-xs font-black text-primary-600"><?php echo e($confirmedRatio); ?>%</span>
          </div>
          <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-l from-primary-400 to-primary-600 rounded-full transition-all duration-700"
                 style="width: <?php echo e($confirmedRatio); ?>%"></div>
          </div>
        </div>

        
        <div>
          <div class="flex justify-between items-center mb-1.5">
            <span class="text-xs font-bold text-gray-700">الأطباء النشطون</span>
            <span class="text-xs font-black text-emerald-600"><?php echo e($stats['total_doctors']); ?> طبيب</span>
          </div>
          <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-l from-emerald-400 to-emerald-600 rounded-full"
                 style="width: <?php echo e(min(($stats['total_doctors'] / max(20, $stats['total_doctors'])) * 100, 100)); ?>%"></div>
          </div>
        </div>

        
        <div>
          <div class="flex justify-between items-center mb-1.5">
            <span class="text-xs font-bold text-gray-700">الرسائل غير المقروءة</span>
            <span class="text-xs font-black text-rose-600"><?php echo e($stats['unread_messages']); ?> رسالة</span>
          </div>
          <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-l from-rose-400 to-rose-600 rounded-full"
                 style="width: <?php echo e(min(($stats['unread_messages'] / max(10, $stats['unread_messages'])) * 100, 100)); ?>%"></div>
          </div>
        </div>

      </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
      <h3 class="font-black text-gray-900 text-base mb-4">إجراءات سريعة</h3>
      <div class="grid grid-cols-2 gap-3">
        <a href="<?php echo e(route('admin.users.index')); ?>"
          class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-primary-50 rounded-xl transition-colors group text-center border border-transparent hover:border-primary-100">
          <div class="w-10 h-10 bg-white group-hover:bg-primary-100 rounded-xl flex items-center justify-center shadow-sm transition-colors">
            <i data-lucide="users" class="w-5 h-5 text-gray-600 group-hover:text-primary-600"></i>
          </div>
          <span class="text-xs font-bold text-gray-600 group-hover:text-primary-700">المستخدمون</span>
        </a>
        <a href="<?php echo e(route('admin.settings.index')); ?>"
          class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-violet-50 rounded-xl transition-colors group text-center border border-transparent hover:border-violet-100">
          <div class="w-10 h-10 bg-white group-hover:bg-violet-100 rounded-xl flex items-center justify-center shadow-sm transition-colors">
            <i data-lucide="settings" class="w-5 h-5 text-gray-600 group-hover:text-violet-600"></i>
          </div>
          <span class="text-xs font-bold text-gray-600 group-hover:text-violet-700">الإعدادات</span>
        </a>
        <a href="/"
          class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-emerald-50 rounded-xl transition-colors group text-center border border-transparent hover:border-emerald-100">
          <div class="w-10 h-10 bg-white group-hover:bg-emerald-100 rounded-xl flex items-center justify-center shadow-sm transition-colors">
            <i data-lucide="home" class="w-5 h-5 text-gray-600 group-hover:text-emerald-600"></i>
          </div>
          <span class="text-xs font-bold text-gray-600 group-hover:text-emerald-700">الموقع</span>
        </a>
        <button onclick="document.getElementById('logout-form').submit()"
          class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-red-50 rounded-xl transition-colors group text-center border border-transparent hover:border-red-100 cursor-pointer">
          <div class="w-10 h-10 bg-white group-hover:bg-red-100 rounded-xl flex items-center justify-center shadow-sm transition-colors">
            <i data-lucide="log-out" class="w-5 h-5 text-gray-600 group-hover:text-red-600"></i>
          </div>
          <span class="text-xs font-bold text-gray-600 group-hover:text-red-700">خروج</span>
        </button>
      </div>
    </div>

    
    <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-5 text-white shadow-lg shadow-primary-500/20 relative overflow-hidden">
      <div class="absolute -bottom-8 -left-8 w-36 h-36 bg-white/5 rounded-full"></div>
      <div class="absolute -top-5 -right-5 w-24 h-24 bg-white/5 rounded-full"></div>
      <div class="relative">
        <div class="flex items-center gap-2 mb-3">
          <i data-lucide="calendar-days" class="w-5 h-5 text-primary-200"></i>
          <span class="text-sm font-bold text-primary-200">اليوم</span>
        </div>
        <p class="text-2xl font-black mb-1"><?php echo e(\Carbon\Carbon::now()->locale('ar')->isoFormat('D MMMM')); ?></p>
        <p class="text-primary-200 text-xs"><?php echo e(\Carbon\Carbon::now()->locale('ar')->isoFormat('dddd — YYYY')); ?></p>
        <div class="mt-4 pt-4 border-t border-white/10 flex justify-between text-xs">
          <div class="text-center">
            <p class="font-black text-xl"><?php echo e($stats['today_appointments']); ?></p>
            <p class="text-primary-200">حجز اليوم</p>
          </div>
          <div class="w-px bg-white/10"></div>
          <div class="text-center">
            <p class="font-black text-xl"><?php echo e($stats['pending_appointments']); ?></p>
            <p class="text-primary-200">قيد الانتظار</p>
          </div>
          <div class="w-px bg-white/10"></div>
          <div class="text-center">
            <p class="font-black text-xl"><?php echo e($stats['unread_messages']); ?></p>
            <p class="text-primary-200">رسالة</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
  const labels = <?php echo json_encode($stats['chart_labels'] ?? [], 15, 512) ?>;
  const counts = <?php echo json_encode($stats['chart_counts'] ?? [], 15, 512) ?>;

  if (!labels.length) return;

  const ctx = document.getElementById('bookingsChart');
  if (!ctx) return;

  // Build gradient fill
  const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 256);
  gradient.addColorStop(0,   'rgba(14, 165, 233, 0.25)');
  gradient.addColorStop(1,   'rgba(14, 165, 233, 0.01)');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'حجوزات',
        data: counts,
        borderColor: '#0ea5e9',
        backgroundColor: gradient,
        borderWidth: 2.5,
        pointBackgroundColor: '#0ea5e9',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 7,
        fill: true,
        tension: 0.45,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { intersect: false, mode: 'index' },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#0f172a',
          titleFont: { size: 12, weight: 'bold' },
          bodyFont: { size: 13, weight: 'bold' },
          padding: 12,
          cornerRadius: 10,
          callbacks: {
            title: (items) => items[0].label,
            label: (item) => `  ${item.raw} حجز`,
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: '#94a3b8', font: { size: 11 }, maxRotation: 45 },
        },
        y: {
          beginAtZero: true,
          grid: { color: '#f1f5f9', lineWidth: 1 },
          ticks: { color: '#94a3b8', font: { size: 11 }, precision: 0 },
          border: { display: false },
        }
      }
    }
  });
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>