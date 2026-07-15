<?php $__env->startSection('title', 'التقارير والإحصائيات - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>

<?php
  $statusLabels = [
    'pending' => 'انتظار',
    'confirmed' => 'مؤكد',
    'completed' => 'مكتمل',
    'cancelled' => 'ملغي',
  ];
  $statusColors = [
    'pending' => '#f59e0b',
    'confirmed' => '#3b82f6',
    'completed' => '#10b981',
    'cancelled' => '#ef4444',
  ];
  $typeLabels = [
    'normal' => 'كشف عادي',
    'offer' => 'عرض',
    'consultation' => 'استشارة',
  ];
?>


<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
  <div>
    <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
      <i data-lucide="bar-chart-3" class="w-7 h-7 text-primary-600"></i>
      <span>التقارير والإحصائيات</span>
    </h1>
    <p class="text-gray-500 text-sm mt-1">تحليل شامل لأداء المستشفى والحجوزات خلال الفترة المحددة</p>
  </div>

  
  <div class="flex items-center gap-2 self-start md:self-auto">
    <span class="text-sm font-bold text-gray-500">الفترة:</span>
    <div class="flex gap-1 bg-gray-50 rounded-xl p-1 border border-gray-100">
      <?php $__currentLoopData = [7 => '7 أيام', 30 => '30 يوم', 90 => '3 أشهر', 365 => 'سنة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $days => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.reports.index', ['period' => $days])); ?>"
          class="px-4 py-2 rounded-lg text-xs font-bold transition-all <?php echo e((int)$period === $days ? 'bg-primary-500 text-white shadow-md shadow-primary-500/20' : 'text-gray-500 hover:bg-gray-100'); ?>">
          <?php echo e($label); ?>

        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>


<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-7">

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-linear-to-br from-primary-400/5 to-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center group-hover:bg-primary-100 transition-colors">
        <i data-lucide="calendar-range" class="w-6 h-6 text-primary-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-primary-50 text-primary-600 rounded-lg">الفترة</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($periodAppointments); ?></p>
    <p class="text-xs text-gray-400 font-semibold">حجوزات خلال <?php echo e($period); ?> يوم</p>
  </div>

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-linear-to-br from-emerald-400/5 to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg">مكتمل</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($completedAppointments); ?></p>
    <p class="text-xs text-gray-400 font-semibold">حجوزات مكتملة</p>
  </div>

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-linear-to-br from-amber-400/5 to-amber-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
        <i data-lucide="clock" class="w-6 h-6 text-amber-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-amber-50 text-amber-600 rounded-lg">انتظار</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($pendingAppointments); ?></p>
    <p class="text-xs text-gray-400 font-semibold">قيد الانتظار الآن</p>
  </div>

  
  <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    <div class="absolute inset-0 bg-linear-to-br from-rose-400/5 to-rose-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <div class="flex items-start justify-between mb-4">
      <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center group-hover:bg-rose-100 transition-colors">
        <i data-lucide="x-circle" class="w-6 h-6 text-rose-500"></i>
      </div>
      <span class="text-xs font-bold px-2 py-1 bg-rose-50 text-rose-600 rounded-lg">ملغي</span>
    </div>
    <p class="text-3xl font-black text-gray-900 tabular-nums leading-none mb-1"><?php echo e($cancelledAppointments); ?></p>
    <p class="text-xs text-gray-400 font-semibold">حجوزات ملغاة</p>
  </div>

</div>


<div class="grid lg:grid-cols-3 gap-6 mb-7">

  
  <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-center justify-between mb-6 text-right">
      <div>
        <h3 class="font-black text-gray-900 text-lg">تطور الحجوزات اليومية</h3>
        <p class="text-xs text-gray-400 mt-0.5">آخر <?php echo e($period); ?> يوم</p>
      </div>
      <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-full bg-primary-500 inline-block"></span>
        <span class="text-xs text-gray-500 font-medium">الحجوزات</span>
      </div>
    </div>
    <div class="relative h-72">
      <canvas id="dailyChart"></canvas>
      <?php if(empty($dailyCounts)): ?>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
          <i data-lucide="bar-chart-2" class="w-14 h-14 mb-3 opacity-40"></i>
          <p class="text-sm font-medium text-gray-400">لا توجد بيانات للفترة المحددة</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-black text-gray-900 text-base mb-6 text-right">توزيع حالات الحجوزات</h3>
    <div class="relative h-60">
      <canvas id="statusChart"></canvas>
    </div>
    <div class="mt-4 space-y-2">
      <?php $__currentLoopData = $statusDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="flex items-center justify-between text-sm">
        <div class="flex items-center gap-2">
          <span class="w-3 h-3 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['background-color: ' . ($statusColors[$status] ?? '#94a3b8')]) ?>"></span>
          <span class="text-gray-600 font-medium"><?php echo e($statusLabels[$status] ?? $status); ?></span>
        </div>
        <span class="font-bold text-gray-800"><?php echo e($count); ?></span>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>

</div>


<div class="grid lg:grid-cols-2 gap-6 mb-7">

  
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-black text-gray-900 text-base mb-6 text-right flex items-center gap-2 justify-end">
      <i data-lucide="hospital" class="w-5 h-5 text-violet-500"></i>
      الأقسام الأكثر طلباً
    </h3>
    <div class="space-y-4">
      <?php $__empty_1 = true; $__currentLoopData = $topDepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $maxCount = $topDepartments->max();
        $percentage = $maxCount > 0 ? round(($count / $maxCount) * 100) : 0;
      ?>
      <div>
        <div class="flex justify-between items-center mb-1.5">
          <span class="text-sm font-bold text-gray-700"><?php echo e($dept); ?></span>
          <span class="text-xs font-black text-primary-600"><?php echo e($count); ?> حجز</span>
        </div>
        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full bg-linear-to-l from-violet-400 to-violet-600 rounded-full transition-all duration-700" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width: ' . $percentage . '%']) ?>"></div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="text-center py-8 text-gray-400">
        <i data-lucide="hospital" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
        <p class="text-sm">لا توجد بيانات</p>
      </div>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2 justify-end">
      <i data-lucide="stethoscope" class="w-5 h-5 text-emerald-500"></i>
      <h3 class="font-black text-gray-900 text-base">أداء الأطباء</h3>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full" dir="rtl">
        <thead>
          <tr class="bg-gray-50/60 text-gray-400 text-xs font-bold uppercase tracking-wider">
            <th class="px-6 py-3 text-right">الطبيب</th>
            <th class="px-4 py-3 text-center">إجمالي</th>
            <th class="px-4 py-3 text-center">مكتمل</th>
            <th class="px-4 py-3 text-center">ملغي</th>
            <th class="px-4 py-3 text-center">نسبة الإتمام</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <?php $__empty_1 = true; $__currentLoopData = $doctorPerformance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docName => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php
            $completionRate = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0;
          ?>
          <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="px-6 py-3.5">
              <span class="font-bold text-gray-800 text-sm"><?php echo e($docName); ?></span>
            </td>
            <td class="px-4 py-3.5 text-center">
              <span class="font-bold text-gray-700 text-sm"><?php echo e($stats['total']); ?></span>
            </td>
            <td class="px-4 py-3.5 text-center">
              <span class="text-emerald-600 font-bold text-sm"><?php echo e($stats['completed']); ?></span>
            </td>
            <td class="px-4 py-3.5 text-center">
              <span class="text-rose-600 font-bold text-sm"><?php echo e($stats['cancelled']); ?></span>
            </td>
            <td class="px-4 py-3.5 text-center">
              <div class="flex items-center justify-center gap-2">
                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                  <div class="h-full bg-emerald-500 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width: ' . $completionRate . '%']) ?>"></div>
                </div>
                <span class="text-xs font-bold text-gray-600"><?php echo e($completionRate); ?>%</span>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" class="text-center py-8 text-gray-400">
              <p class="text-sm">لا توجد بيانات أطباء</p>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>


<div class="grid lg:grid-cols-3 gap-6">

  
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-black text-gray-900 text-base mb-4 text-right flex items-center gap-2 justify-end">
      <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
      ساعات الذروة
    </h3>
    <div class="space-y-3">
      <?php $__empty_1 = true; $__currentLoopData = $peakHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $maxPeak = $peakHours->max();
        $peakPct = $maxPeak > 0 ? round(($count / $maxPeak) * 100) : 0;
      ?>
      <div class="flex items-center gap-3">
        <span class="text-sm font-mono font-bold text-gray-600 w-14 text-center bg-gray-50 py-1 rounded-lg"><?php echo e($time); ?></span>
        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full bg-linear-to-l from-amber-400 to-orange-500 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width: ' . $peakPct . '%']) ?>"></div>
        </div>
        <span class="text-xs font-bold text-gray-500 w-8 text-left"><?php echo e($count); ?></span>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p class="text-center text-gray-400 text-sm py-4">لا توجد بيانات</p>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-black text-gray-900 text-base mb-4 text-right flex items-center gap-2 justify-end">
      <i data-lucide="layers" class="w-5 h-5 text-blue-500"></i>
      أنواع الحجوزات
    </h3>
    <div class="relative h-52 mb-4">
      <canvas id="typeChart"></canvas>
    </div>
    <div class="space-y-2">
      <?php $__currentLoopData = $typeDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="flex items-center justify-between text-sm">
        <span class="text-gray-600 font-medium"><?php echo e($typeLabels[$type] ?? $type); ?></span>
        <span class="font-bold text-gray-800 bg-gray-50 px-2.5 py-0.5 rounded-lg"><?php echo e($count); ?></span>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>

  
  <div class="bg-linear-to-br from-slate-700 via-slate-800 to-slate-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
    <div class="absolute -bottom-8 -left-8 w-36 h-36 bg-white/5 rounded-full"></div>
    <div class="absolute -top-5 -right-5 w-24 h-24 bg-white/5 rounded-full"></div>
    <div class="relative">
      <div class="flex items-center gap-2 mb-6">
        <i data-lucide="mail" class="w-5 h-5 text-slate-300"></i>
        <h3 class="font-black text-base">ملخص الرسائل</h3>
      </div>

      <div class="space-y-5">
        <div>
          <p class="text-4xl font-black tabular-nums"><?php echo e($totalMessages); ?></p>
          <p class="text-slate-300 text-sm font-medium mt-1">إجمالي الرسائل في الفترة</p>
        </div>

        <div class="h-px bg-white/10"></div>

        <div class="flex items-center justify-between">
          <div>
            <p class="text-2xl font-black text-amber-400 tabular-nums"><?php echo e($newMessages); ?></p>
            <p class="text-slate-400 text-xs mt-0.5">رسائل جديدة</p>
          </div>
          <div>
            <p class="text-2xl font-black tabular-nums"><?php echo e($totalMessages - $newMessages); ?></p>
            <p class="text-slate-400 text-xs mt-0.5">تمت المعالجة</p>
          </div>
        </div>

        <a href="<?php echo e(route('admin.messages.index')); ?>"
          class="block w-full text-center py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold transition-all">
          عرض الرسائل
        </a>
      </div>
    </div>
  </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
  // ===== Daily Appointments Line Chart =====
  const dailyLabels = JSON.parse('<?php echo json_encode($dailyLabels ?? []); ?>');
  const dailyCounts = JSON.parse('<?php echo json_encode($dailyCounts ?? []); ?>');

  if (dailyLabels.length) {
    const dailyCtx = document.getElementById('dailyChart');
    if (dailyCtx) {
      const gradient = dailyCtx.getContext('2d').createLinearGradient(0, 0, 0, 288);
      gradient.addColorStop(0, 'rgba(14, 165, 233, 0.25)');
      gradient.addColorStop(1, 'rgba(14, 165, 233, 0.01)');

      new Chart(dailyCtx, {
        type: 'line',
        data: {
          labels: dailyLabels,
          datasets: [{
            label: 'حجوزات',
            data: dailyCounts,
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
              callbacks: { label: (item) => `  ${item.raw} حجز` }
            }
          },
          scales: {
            x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 }, maxRotation: 45 }},
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 11 }, precision: 0 }, border: { display: false }}
          }
        }
      });
    }
  }

  // ===== Status Distribution Doughnut =====
  const statusData = JSON.parse('<?php echo json_encode($statusDistribution ?? []); ?>');
  const statusLabels = JSON.parse('<?php echo json_encode($statusLabels); ?>');
  const statusColorMap = JSON.parse('<?php echo json_encode($statusColors); ?>');

  if (Object.keys(statusData).length) {
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
      new Chart(statusCtx, {
        type: 'doughnut',
        data: {
          labels: Object.keys(statusData).map(k => statusLabels[k] || k),
          datasets: [{
            data: Object.values(statusData),
            backgroundColor: Object.keys(statusData).map(k => statusColorMap[k] || '#94a3b8'),
            borderWidth: 3,
            borderColor: '#fff',
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '65%',
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#0f172a',
              padding: 10,
              cornerRadius: 8,
              callbacks: { label: (item) => ` ${item.label}: ${item.raw}` }
            }
          }
        }
      });
    }
  }

  // ===== Type Distribution Bar Chart =====
  const typeData = JSON.parse('<?php echo json_encode($typeDistribution ?? []); ?>');
  const typeLabelsMap = JSON.parse('<?php echo json_encode($typeLabels); ?>');

  if (Object.keys(typeData).length) {
    const typeCtx = document.getElementById('typeChart');
    if (typeCtx) {
      new Chart(typeCtx, {
        type: 'bar',
        data: {
          labels: Object.keys(typeData).map(k => typeLabelsMap[k] || k),
          datasets: [{
            data: Object.values(typeData),
            backgroundColor: ['#0ea5e9', '#8b5cf6', '#f59e0b', '#ef4444'],
            borderRadius: 8,
            barPercentage: 0.6,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false }},
          scales: {
            x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } }},
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 11 }, precision: 0 }, border: { display: false }}
          }
        }
      });
    }
  }
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\admin\reports\index.blade.php ENDPATH**/ ?>