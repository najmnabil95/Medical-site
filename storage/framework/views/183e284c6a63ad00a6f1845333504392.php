<?php $__env->startSection('title', 'شركات التأمين - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="shield-check" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة شركات التأمين المعتمدة</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تحديد الجهات والشركات والشركاء التأمينيين المقبولين لتغطية العلاج</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة شركة تأمين</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم الشركة أو الاختصار..."
        onkeyup="filterInsurances()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Insurances Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="insurances-grid">
    <?php $__empty_1 = true; $__currentLoopData = $insurances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div
        class="insurance-card bg-white rounded-2xl border border-gray-100 p-5 text-right flex flex-col justify-between hover:shadow-lg transition-all <?php echo e(!$ins->active ? 'opacity-60' : ''); ?>"
        data-name="<?php echo e($ins->name); ?>"
        data-abbr="<?php echo e($ins->abbr); ?>"
      >
        <div>
          <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-blue-50 text-blue-600 border border-blue-100 font-black text-sm uppercase font-mono">
              <?php echo e($ins->abbr); ?>

            </div>
            
            <!-- Active Toggle Button -->
            <form action="<?php echo e(route('admin.insurances.update', $ins->id)); ?>" method="POST" class="inline">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>
              <input type="hidden" name="name" value="<?php echo e($ins->name); ?>" />
              <input type="hidden" name="abbr" value="<?php echo e($ins->abbr); ?>" />
              <?php if($ins->active): ?>
                <button type="submit" class="text-emerald-500 hover:scale-115 transition-transform cursor-pointer">
                  <i data-lucide="toggle-right" class="w-8 h-8"></i>
                </button>
              <?php else: ?>
                <button type="submit" name="active" value="1" class="text-gray-300 hover:scale-115 transition-transform cursor-pointer">
                  <i data-lucide="toggle-left" class="w-8 h-8"></i>
                </button>
              <?php endif; ?>
            </form>
          </div>

          <h3 class="text-base font-bold text-gray-800 mb-1"><?php echo e($ins->name); ?></h3>
          <p class="text-gray-400 text-xs font-bold font-mono">ID / ABBR: <?php echo e($ins->abbr); ?></p>
        </div>

        <div class="flex items-center gap-2 pt-3 border-t border-gray-50 mt-5">
          <button
            onclick="openEditModal(<?php echo e($ins->id); ?>, '<?php echo e(addslashes($ins->name)); ?>', '<?php echo e($ins->abbr); ?>', <?php echo e($ins->active ? 'true' : 'false'); ?>)"
            class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
          >
            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
            <span>تعديل</span>
          </button>

          <form action="<?php echo e(route('admin.insurances.destroy', $ins->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('هل تريد إزالة شركة التأمين نهائياً؟');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button
              type="submit"
              class="w-full py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
            >
              <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
              <span>حذف</span>
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="shield-alert" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا توجد شركات تأمين مضافة حالياً</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Create Modal -->
  <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">إضافة شركة تأمين جديدة</h3>
      </div>
      
      <form action="<?php echo e(route('admin.insurances.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم شركة التأمين</label>
          <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="شركة بوبا العربية للتأمين التعاوني" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">رمز الاختصار / الكود</label>
          <input type="text" name="abbr" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="BUPA" />
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" checked id="create-active" />
          <label for="create-active" class="text-sm font-bold">نشطة ومتاحة للتغطية</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ شركة التأمين</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات شركة التأمين</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم شركة التأمين</label>
          <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">رمز الاختصار / الكود</label>
          <input type="text" name="abbr" id="edit-abbr" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" id="edit-active" />
          <label for="edit-active" class="text-sm font-bold">نشطة ومتاحة للتغطية</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterInsurances() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.insurance-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const abbr = card.getAttribute('data-abbr').toLowerCase();
        
        if (name.includes(query) || abbr.includes(query)) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    function openCreateModal() {
      document.getElementById('create-modal').classList.remove('hidden');
    }

    function closeCreateModal() {
      document.getElementById('create-modal').classList.add('hidden');
    }

    function openEditModal(id, name, abbr, active) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/insurances/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-abbr').value = abbr;
      document.getElementById('edit-active').checked = active;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\admin\insurances\index.blade.php ENDPATH**/ ?>