<?php $__env->startSection('title', 'إدارة باقات الكشف - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $iconsList = [
      'package' => 'صندوق الباقة',
      'activity' => 'نشاط / فحص عام',
      'heart' => 'قلب / صحة متكاملة',
      'award' => 'اعتماد / باقة مميزة',
      'star' => 'نجمية / كبار الشخصيات',
      'shield' => 'وقاية / حماية كاملة',
    ];

    $gradients = [
      'from-blue-500 to-indigo-600' => 'التدرج الأزرق',
      'from-emerald-500 to-teal-600' => 'التدرج الأخضر',
      'from-purple-500 to-pink-600' => 'التدرج البنفسجي',
      'from-amber-500 to-orange-600' => 'التدرج العسلي',
      'from-red-500 to-rose-600' => 'التدرج الأحمر',
    ];
  ?>

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="package" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة باقات الفحص الطبي والبرامج</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تخصيص الفحوصات الدورية، الأسعار، الفترات الزمنية ومميزات الباقات</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة باقة جديدة</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم الباقة (عربي / إنجليزي)..."
        onkeyup="filterPackages()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Packages Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="packages-grid">
    <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div
        class="package-card bg-white rounded-3xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all relative flex flex-col justify-between <?php echo e(!$pkg->active ? 'opacity-60' : ''); ?>"
        data-name="<?php echo e($pkg->name); ?>"
        data-name-en="<?php echo e($pkg->name_en); ?>"
      >
        <?php if($pkg->popular): ?>
          <span class="absolute top-4 left-4 bg-amber-500 text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm z-10 animate-pulse">
            الأكثر شعبية
          </span>
        <?php endif; ?>

        <div>
          <!-- Gradient Header Banner -->
          <div class="h-28 bg-gradient-to-br <?php echo e($pkg->gradient); ?> p-5 text-white flex items-center gap-3 relative">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center">
              <i data-lucide="<?php echo e($pkg->icon); ?>" class="w-6 h-6"></i>
            </div>
            <div class="text-right">
              <h3 class="font-bold text-lg leading-tight"><?php echo e($pkg->name); ?></h3>
              <p class="text-xs text-white/80 font-mono"><?php echo e($pkg->name_en); ?></p>
            </div>
          </div>

          <!-- Price & Period -->
          <div class="p-6 text-right border-b border-gray-50">
            <div class="flex items-baseline justify-start gap-1">
              <span class="text-3xl font-black text-gray-900 tabular-nums"><?php echo e(number_format((float) str_replace(',', '', $pkg->price))); ?></span>
              <span class="text-xs font-bold text-gray-400">ريال</span>
              <span class="text-sm font-medium text-gray-400 mr-2">/ <?php echo e($pkg->period); ?></span>
            </div>
          </div>

          <!-- Features List -->
          <div class="p-6 text-right">
            <p class="text-xs font-bold text-gray-400 mb-3 uppercase tracking-wider">مزايا وفحوصات الباقة:</p>
            <ul class="space-y-2 text-xs text-gray-600 font-medium">
              <?php $__currentLoopData = $pkg->features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="flex items-center gap-2 justify-start">
                  <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                  <span><?php echo e($feat); ?></span>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        </div>

        <!-- Actions panel -->
        <div class="p-6 pt-0 text-right">
          <div class="flex items-center gap-2 pt-4 border-t border-gray-50">
            <button
              onclick="openEditModal(<?php echo e($pkg->id); ?>, '<?php echo e(addslashes($pkg->name)); ?>', '<?php echo e(addslashes($pkg->name_en)); ?>', '<?php echo e(str_replace(',', '', $pkg->price)); ?>', '<?php echo e($pkg->period); ?>', '<?php echo e($pkg->icon); ?>', <?php echo e($pkg->popular ? 'true' : 'false'); ?>, '<?php echo e($pkg->gradient); ?>', <?php echo e($pkg->active ? 'true' : 'false'); ?>, <?php echo e(json_encode($pkg->features ?? [])); ?>)"
              class="flex-1 py-2.5 bg-blue-50 text-blue-600 rounded-xl text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
            >
              <i data-lucide="edit" class="w-3.5 h-3.5"></i>
              <span>تعديل الباقة</span>
            </button>

            <form action="<?php echo e(route('admin.packages.destroy', $pkg->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('هل تريد حذف الباقة نهائياً؟');">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button
                type="submit"
                class="w-full py-2.5 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
              >
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <span>حذف</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="package" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا توجد باقات كشف مسجلة حالياً</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Create Package Modal -->
  <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">إضافة باقة كشف جديدة</h3>
      </div>
      
      <form action="<?php echo e(route('admin.packages.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الباقة (عربي)</label>
            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="الباقة الفضية الشاملة" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الباقة (إنجليزي)</label>
            <input type="text" name="name_en" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="Silver Comprehensive Package" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">السعر (ريال سعودي)</label>
            <input type="number" name="price" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="500" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">دورية الفحص</label>
            <input type="text" name="period" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="سنوياً / مرة واحدة" value="سنوياً" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة</label>
            <select name="icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $iconsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التدرج اللوني للمظهر</label>
            <select name="gradient" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $gradients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">مزايا وفحوصات الباقة <span class="text-gray-400 font-normal">(ميزة واحدة في كل سطر)</span></label>
          <textarea name="features_raw" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-28" placeholder="فحص السكر العشوائي&#10;تخطيط القلب الكهربائي&#10;استشارة طبيب الباطنية"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center gap-2">
            <input type="checkbox" name="popular" value="1" id="create-popular" />
            <label for="create-popular" class="text-sm font-bold text-amber-600">تمييز كـ (الأكثر مبيعاً)</label>
          </div>
          <div class="flex items-center gap-2">
            <input type="checkbox" name="active" value="1" checked id="create-active" />
            <label for="create-active" class="text-sm font-bold">تفعيل الباقة بالموقع</label>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">إضافة الباقة</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Package Modal -->
  <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات الباقة الطبية</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الباقة (عربي)</label>
            <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الباقة (إنجليزي)</label>
            <input type="text" name="name_en" id="edit-name-en" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">السعر (ريال)</label>
            <input type="number" name="price" id="edit-price" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">دورية الفحص</label>
            <input type="text" name="period" id="edit-period" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة</label>
            <select name="icon" id="edit-icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $iconsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($name); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التدرج اللوني</label>
            <select name="gradient" id="edit-gradient" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $gradients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">مزايا وفحوصات الباقة <span class="text-gray-400 font-normal">(ميزة واحدة في كل سطر)</span></label>
          <textarea name="features_raw" id="edit-features" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-28"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center gap-2">
            <input type="checkbox" name="popular" value="1" id="edit-popular" />
            <label for="edit-popular" class="text-sm font-bold text-amber-600">تمييز كـ (الأكثر مبيعاً)</label>
          </div>
          <div class="flex items-center gap-2">
            <input type="checkbox" name="active" value="1" id="edit-active" />
            <label for="edit-active" class="text-sm font-bold">تفعيل الباقة بالموقع</label>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterPackages() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.package-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const nameEn = card.getAttribute('data-name-en').toLowerCase();
        
        if (name.includes(query) || nameEn.includes(query)) {
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

    function openEditModal(id, name, nameEn, price, period, icon, popular, gradient, active, featuresArray) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/packages/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-name-en').value = nameEn;
      document.getElementById('edit-price').value = price;
      document.getElementById('edit-period').value = period;
      document.getElementById('edit-icon').value = icon;
      document.getElementById('edit-popular').checked = popular;
      document.getElementById('edit-gradient').value = gradient;
      document.getElementById('edit-active').checked = active;
      document.getElementById('edit-features').value = featuresArray.join('\n');
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\hospital-backend\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>