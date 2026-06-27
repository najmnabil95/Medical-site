<?php $__env->startSection('title', 'إدارة الأقسام الطبية - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $iconsList = [
      'activity' => 'نبض / نشاط',
      'heart' => 'قلب / أوعية',
      'brain' => 'مخ / أعصاب',
      'bone' => 'عظام / مفاصل',
      'eye' => 'عيون / بصريات',
      'pill' => 'صيدلية / باطنية',
      'stethoscope' => 'سماعة / فحص',
      'baby' => 'أطفال / ولادة',
      'shield' => 'وقاية / مناعة',
      'droplet' => 'دم / مختبر',
    ];

    $colorsList = [
      'blue' => 'أزرق',
      'emerald' => 'أخضر زمردي',
      'purple' => 'بنفسجي',
      'amber' => 'عسلي / برتقالي',
      'rose' => 'وردي / أحمر',
      'indigo' => 'نيلي',
    ];

    $colorClasses = [
      'blue' => 'bg-blue-50 text-blue-600 border-blue-100',
      'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
      'purple' => 'bg-purple-50 text-purple-600 border-purple-100',
      'amber' => 'bg-amber-50 text-amber-600 border-amber-100',
      'rose' => 'bg-rose-50 text-rose-600 border-rose-100',
      'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
    ];
  ?>

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="hospital" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة الأقسام الطبية</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">إضافة، تعديل، وإلغاء تفعيل الأقسام والتخصصات الرئيسية بالمستشفى</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة قسم طبي جديد</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم القسم أو الوصف..."
        onkeyup="filterDepartments()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Departments List -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="departments-grid">
    <?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $colorClass = $colorClasses[$dept->color] ?? 'bg-gray-50 text-gray-600 border-gray-100';
      ?>
      <div
        class="dept-card bg-white rounded-2xl border border-gray-100 p-5 text-right flex flex-col justify-between hover:shadow-xl transition-all <?php echo e(!$dept->active ? 'opacity-60' : ''); ?>"
        data-name="<?php echo e($dept->name); ?>"
        data-desc="<?php echo e($dept->desc); ?>"
      >
        <div>
          <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center border <?php echo e($colorClass); ?>">
              <i data-lucide="<?php echo e($dept->icon); ?>" class="w-6 h-6"></i>
            </div>
            
            <!-- Active Toggle Button -->
            <form action="<?php echo e(route('admin.departments.update', $dept->id)); ?>" method="POST" class="inline">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>
              <input type="hidden" name="name" value="<?php echo e($dept->name); ?>" />
              <input type="hidden" name="icon" value="<?php echo e($dept->icon); ?>" />
              <input type="hidden" name="desc" value="<?php echo e($dept->desc); ?>" />
              <input type="hidden" name="color" value="<?php echo e($dept->color); ?>" />
              <?php if($dept->active): ?>
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

          <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo e($dept->name); ?></h3>
          <p class="text-gray-500 text-xs leading-relaxed mb-6"><?php echo e($dept->desc); ?></p>
        </div>

        <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
          <button
            onclick="openEditModal(<?php echo e($dept->id); ?>, '<?php echo e(addslashes($dept->name)); ?>', '<?php echo e($dept->icon); ?>', '<?php echo e(addslashes($dept->desc)); ?>', '<?php echo e($dept->color); ?>', <?php echo e($dept->active ? 'true' : 'false'); ?>)"
            class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
          >
            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
            <span>تعديل</span>
          </button>

          <form action="<?php echo e(route('admin.departments.destroy', $dept->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('حذف هذا القسم قد يؤثر على الأطباء والحجوزات المرتبطة به. هل تريد الحذف بالفعل؟');">
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
        <i data-lucide="hospital" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا توجد أقسام طبية مسجلة</p>
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
        <h3 class="text-xl font-bold text-gray-800">إضافة قسم طبي جديد</h3>
      </div>
      
      <form action="<?php echo e(route('admin.departments.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم القسم</label>
          <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="قسم جراحة القلب" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة المعبرة</label>
            <select name="icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $iconsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اللون المميز</label>
            <select name="color" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $colorsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف القسم الطبي</label>
          <textarea name="desc" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-28" placeholder="وصف كامل للأمراض التي يعالجها القسم، والإجراءات الطبية المتاحة..."></textarea>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" checked id="create-active" />
          <label for="create-active" class="text-sm font-bold">نشط (متاح للحجوزات ويظهر بالموقع)</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">إضافة القسم</button>
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
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات القسم الطبي</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم القسم</label>
          <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة المعبرة</label>
            <select name="icon" id="edit-icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $iconsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اللون المميز</label>
            <select name="color" id="edit-color" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $colorsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف القسم الطبي</label>
          <textarea name="desc" id="edit-desc" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-28"></textarea>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" id="edit-active" />
          <label for="edit-active" class="text-sm font-bold">نشط (متاح للحجوزات ويظهر بالموقع)</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterDepartments() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.dept-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const desc = card.getAttribute('data-desc').toLowerCase();
        
        if (name.includes(query) || desc.includes(query)) {
          card.style.display = '';
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

    function openEditModal(id, name, icon, desc, color, active) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/departments/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-icon').value = icon;
      document.getElementById('edit-desc').value = desc;
      document.getElementById('edit-color').value = color;
      document.getElementById('edit-active').checked = active;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/admin/departments/index.blade.php ENDPATH**/ ?>