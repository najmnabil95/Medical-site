<?php $__env->startSection('title', 'سجل النشاطات'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-right">
  <div>
    <h1 class="text-2xl font-black text-gray-900 leading-tight">سجل نشاطات النظام</h1>
    <p class="text-gray-400 text-sm mt-1 font-medium">مراقبة العمليات الحساسة وعمليات تسجيل الدخول والخروج التي تتم في النظام</p>
  </div>

  <?php if($logs->total() > 0): ?>
    <form action="<?php echo e(route('admin.activity-logs.clearAll')); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف جميع سجلات النشاطات؟ لا يمكن التراجع عن هذا الإجراء.');">
      <?php echo csrf_field(); ?>
      <?php echo method_field('DELETE'); ?>
      <button type="submit" 
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl text-sm font-bold text-red-600 hover:text-red-700 shadow-sm transition-all cursor-pointer">
        <i data-lucide="trash-2" class="w-4 h-4"></i>
        <span>مسح السجل بالكامل</span>
      </button>
    </form>
  <?php endif; ?>
</div>


<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-right">
  <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
    <h3 class="font-black text-gray-900 text-base">سجلات العمليات</h3>
    <span class="text-xs text-gray-500 font-bold bg-gray-50 px-3 py-1 rounded-full">إجمالي العمليات: <?php echo e($logs->total()); ?></span>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full" dir="rtl">
      <thead>
        <tr class="bg-gray-50/60 text-gray-400 text-xs font-bold uppercase tracking-wider">
          <th class="px-6 py-4 text-right">النشاط / العملية</th>
          <th class="px-6 py-4 text-right">نوع العملية</th>
          <th class="px-6 py-4 text-right">المستخدم المسؤول</th>
          <th class="px-6 py-4 text-right">التاريخ والوقت</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="hover:bg-gray-50/30 transition-colors">
            
            <td class="px-6 py-4">
              <span class="text-sm font-semibold text-gray-800 leading-relaxed"><?php echo e($log->action); ?></span>
            </td>
            
            
            <td class="px-6 py-4">
              <?php
                $typeConfig = match($log->type) {
                  'create' => ['label' => 'إضافة جديد',  'class' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200'],
                  'update' => ['label' => 'تعديل',       'class' => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200'],
                  'delete' => ['label' => 'حذف',         'class' => 'bg-red-50 text-red-700 ring-1 ring-red-200'],
                  'login'  => ['label' => 'تسجيل دخول',  'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'],
                  'logout' => ['label' => 'تسجيل خروج',  'class' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200'],
                  default  => ['label' => $log->type,    'class' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200'],
                };
              ?>
              <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold <?php echo e($typeConfig['class']); ?>">
                <?php echo e($typeConfig['label']); ?>

              </span>
            </td>

            
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs shrink-0">
                  <?php echo e(mb_substr($log->user, 0, 2)); ?>

                </div>
                <span class="text-sm font-semibold text-gray-700"><?php echo e($log->user); ?></span>
              </div>
            </td>

            
            <td class="px-6 py-4">
              <?php if($log->timestamp): ?>
                <p class="text-sm font-semibold text-gray-800">
                  <?php echo e(\Carbon\Carbon::parse($log->timestamp)->locale('ar')->isoFormat('YYYY-MM-DD')); ?>

                </p>
                <p class="text-xs text-gray-400 mt-0.5" dir="ltr">
                  <?php echo e(\Carbon\Carbon::parse($log->timestamp)->format('h:i A')); ?>

                </p>
              <?php else: ?>
                <span class="text-gray-300">-</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="4" class="text-center py-16 text-gray-300">
              <div class="flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 mb-4 border border-gray-100">
                  <i data-lucide="clipboard-x" class="w-8 h-8 opacity-60"></i>
                </div>
                <p class="text-base font-bold text-gray-400">سجل النشاطات فارغ تماماً</p>
                <p class="text-xs text-gray-400 mt-1 font-semibold">سيتم تسجيل أي عمليات جديدة تتم على النظام تلقائياً هنا</p>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  
  <?php if($logs->hasPages()): ?>
    <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/40">
      <?php echo e($logs->links()); ?>

    </div>
  <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/admin/activity-logs/index.blade.php ENDPATH**/ ?>