<?php $__env->startSection('title', 'شهادات الاعتماد - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $iconsList = [
      'award' => 'وسام / شهادة تميز',
      'shield-check' => 'حماية / اعتماد أمان',
      'star' => 'نجم الجودة',
      'check-square' => 'صندوق الاختيار',
      'activity' => 'نبض / رعاية طبية',
    ];

    $stylesList = [
      'amber' => [
        'lbl' => 'ذهبي (مثل JCI)',
        'bg' => 'bg-amber-50',
        'border' => 'border-amber-200',
        'color' => 'text-amber-600'
      ],
      'blue' => [
        'lbl' => 'أزرق (مثل HIMSS)',
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-200',
        'color' => 'text-blue-600'
      ],
      'emerald' => [
        'lbl' => 'أخضر (مثل سباهي CBAHI)',
        'bg' => 'bg-emerald-50',
        'border' => 'border-emerald-200',
        'color' => 'text-emerald-600'
      ],
      'purple' => [
        'lbl' => 'بنفسجي',
        'bg' => 'bg-purple-50',
        'border' => 'border-purple-200',
        'color' => 'text-purple-600'
      ],
    ];
  ?>

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="award" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة شهادات الاعتماد والجوائز</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تعديل وعرض الأوسمة والشهادات الدولية والوطنية التي حصل عليها المستشفى</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة شهادة جديدة</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم الشهادة أو الجهة المانحة..."
        onkeyup="filterCertifications()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Certifications Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="certs-grid">
    <?php $__empty_1 = true; $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div
        class="cert-card bg-white rounded-2xl border border-gray-100 p-5 text-right flex flex-col justify-between hover:shadow-lg transition-all"
        data-name="<?php echo e($cert->name); ?>"
        data-fullname="<?php echo e($cert->full_name); ?>"
        data-desc="<?php echo e($cert->desc); ?>"
      >
        <div>
          <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center border <?php echo e($cert->bg); ?> <?php echo e($cert->border); ?> <?php echo e($cert->color); ?>">
              <i data-lucide="<?php echo e($cert->icon); ?>" class="w-6 h-6"></i>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full font-mono">
              <?php echo e($cert->year); ?>

            </span>
          </div>

          <h3 class="text-base font-bold text-gray-800 mb-1"><?php echo e($cert->name); ?></h3>
          <h4 class="text-xs font-bold text-gray-400 mb-3"><?php echo e($cert->full_name); ?></h4>
          <p class="text-gray-500 text-xs leading-relaxed mb-6"><?php echo e($cert->desc); ?></p>
        </div>

        <div class="flex items-center gap-2 pt-3 border-t border-gray-50 mt-4">
          <button
            onclick="openEditModal(<?php echo e($cert->id); ?>, '<?php echo e(addslashes($cert->name)); ?>', '<?php echo e(addslashes($cert->full_name)); ?>', '<?php echo e($cert->icon); ?>', '<?php echo e(addslashes($cert->desc)); ?>', '<?php echo e($cert->year); ?>', '<?php echo e($cert->color); ?>', '<?php echo e($cert->border); ?>', '<?php echo e($cert->bg); ?>')"
            class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
          >
            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
            <span>تعديل</span>
          </button>

          <form action="<?php echo e(route('admin.certifications.destroy', $cert->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('هل تريد حذف شهادة الاعتماد هذه؟');">
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
        <i data-lucide="award" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا توجد شهادات اعتماد مضافة حالياً</p>
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
        <h3 class="text-xl font-bold text-gray-800">إضافة شهادة اعتماد جديدة</h3>
      </div>
      
      <form action="<?php echo e(route('admin.certifications.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الاختصار للشهادة</label>
            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="CBAHI" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الاسم الكامل للاعتماد</label>
            <input type="text" name="full_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="المركز السعودي لاعتماد المنشآت الصحية" />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">سنة الحصول عليها</label>
            <input type="text" name="year" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="2025" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة</label>
            <select name="icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $iconsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2 font-bold text-primary-700">التنسيق الجاهز</label>
            <select id="create-style-select" onchange="applyPredefinedStyle('create')" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 font-bold rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $stylesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>"><?php echo e($style['lbl']); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4 bg-gray-50 rounded-xl p-3 border border-gray-150">
          <div>
            <label class="block text-[10px] font-bold text-gray-400 mb-1">فئة لون النص (CSS)</label>
            <input type="text" name="color" id="create-color-input" value="text-amber-600" required class="w-full px-2.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-mono" />
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 mb-1">فئة لون الإطار (CSS)</label>
            <input type="text" name="border" id="create-border-input" value="border-amber-200" required class="w-full px-2.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-mono" />
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 mb-1">فئة لون الخلفية (CSS)</label>
            <input type="text" name="bg" id="create-bg-input" value="bg-amber-50" required class="w-full px-2.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-mono" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف الاعتماد ومعاييره</label>
          <textarea name="desc" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-24" placeholder="حصل المستشفى على الاعتماد بعد تطبيق أعلى معايير الجودة وسلامة المرضى في الرعاية الصحية..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ الشهادة</button>
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
        <h3 class="text-xl font-bold text-gray-800">تعديل شهادة الاعتماد</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الاختصار للشهادة</label>
            <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الاسم الكامل للاعتماد</label>
            <input type="text" name="full_name" id="edit-full-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">سنة الحصول عليها</label>
            <input type="text" name="year" id="edit-year" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة</label>
            <select name="icon" id="edit-icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $iconsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2 font-bold text-primary-700">التنسيق الجاهز</label>
            <select id="edit-style-select" onchange="applyPredefinedStyle('edit')" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 font-bold rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $stylesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>"><?php echo e($style['lbl']); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4 bg-gray-50 rounded-xl p-3 border border-gray-150">
          <div>
            <label class="block text-[10px] font-bold text-gray-400 mb-1">فئة لون النص (CSS)</label>
            <input type="text" name="color" id="edit-color-input" required class="w-full px-2.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-mono" />
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 mb-1">فئة لون الإطار (CSS)</label>
            <input type="text" name="border" id="edit-border-input" required class="w-full px-2.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-mono" />
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 mb-1">فئة لون الخلفية (CSS)</label>
            <input type="text" name="bg" id="edit-bg-input" required class="w-full px-2.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-mono" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف الاعتماد ومعاييره</label>
          <textarea name="desc" id="edit-desc" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-24"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const styleDefinitions = {
      'amber': { bg: 'bg-amber-50', border: 'border-amber-200', color: 'text-amber-600' },
      'blue': { bg: 'bg-blue-50', border: 'border-blue-200', color: 'text-blue-600' },
      'emerald': { bg: 'bg-emerald-50', border: 'border-emerald-200', color: 'text-emerald-600' },
      'purple': { bg: 'bg-purple-50', border: 'border-purple-200', color: 'text-purple-600' }
    };

    function applyPredefinedStyle(mode) {
      const select = document.getElementById(`${mode}-style-select`).value;
      const def = styleDefinitions[select];
      if (def) {
        document.getElementById(`${mode}-bg-input`).value = def.bg;
        document.getElementById(`${mode}-border-input`).value = def.border;
        document.getElementById(`${mode}-color-input`).value = def.color;
      }
    }

    function filterCertifications() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.cert-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const fullname = card.getAttribute('data-fullname').toLowerCase();
        const desc = card.getAttribute('data-desc').toLowerCase();
        
        if (name.includes(query) || fullname.includes(query) || desc.includes(query)) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    function openCreateModal() {
      document.getElementById('create-modal').classList.remove('hidden');
      applyPredefinedStyle('create');
    }

    function closeCreateModal() {
      document.getElementById('create-modal').classList.add('hidden');
    }

    function openEditModal(id, name, fullName, icon, desc, year, color, border, bg) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/certifications/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-full-name').value = fullName;
      document.getElementById('edit-icon').value = icon;
      document.getElementById('edit-desc').value = desc;
      document.getElementById('edit-year').value = year;
      document.getElementById('edit-color-input').value = color;
      document.getElementById('edit-border-input').value = border;
      document.getElementById('edit-bg-input').value = bg;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\hospital-backend\resources\views/admin/certifications/index.blade.php ENDPATH**/ ?>