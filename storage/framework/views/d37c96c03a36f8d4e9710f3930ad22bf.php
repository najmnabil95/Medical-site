<?php $__env->startSection('title', 'إدارة الأطباء - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $departments = \App\Models\Department::where('active', true)->get();

    $gradients = [
      'from-blue-500 to-cyan-600' => 'أزرق سماوي',
      'from-indigo-500 to-purple-600' => 'بنفسجي كحلي',
      'from-teal-500 to-emerald-600' => 'زمردي أخضر',
      'from-amber-500 to-orange-600' => 'برتقالي دافئ',
      'from-rose-500 to-pink-600' => 'وردي ناعم',
    ];
  ?>

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="user-cog" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة الكادر الطبي والأطباء</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">عرض، إضافة، وتعديل بيانات الأطباء الاستشاريين والأخصائيين</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-linear-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة طبيب جديد</span>
    </button>
  </div>

  <!-- Counters -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
      <div class="w-10 h-10 bg-linear-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white mb-2">
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        <?php echo e($doctors->count()); ?>

      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">إجمالي الأطباء</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
      <div class="w-10 h-10 bg-linear-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center text-white mb-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        <?php echo e($doctors->where('active', true)->count()); ?>

      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">نشط بالخارجية</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
      <div class="w-10 h-10 bg-linear-to-br from-purple-500 to-violet-600 rounded-lg flex items-center justify-center text-white mb-2">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        <?php echo e(number_format((float) $doctors->filter(fn($d) => !empty($d->experience))->avg(fn($d) => (float) preg_replace('/[^0-9.]/', '', (string) $d->experience)), 1)); ?>

      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">متوسط سنوات الخبرة</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
      <div class="w-10 h-10 bg-linear-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center text-white mb-2">
        <i data-lucide="star" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        ★ <?php echo e(number_format((float) $doctors->filter(fn($d) => is_numeric($d->rating))->avg('rating'), 1)); ?>

      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">متوسط التقييم</div>
    </div>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم الطبيب، التخصص، أو القسم..."
        onkeyup="filterDoctors()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Doctors Cards Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="doctors-grid">
    <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div
        class="doctor-card bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all <?php echo e(!$doc->active ? 'opacity-65' : ''); ?>"
        data-name="<?php echo e($doc->name); ?>"
        data-specialty="<?php echo e($doc->specialty); ?>"
        data-dept="<?php echo e($doc->department); ?>"
      >
        <div class="h-2.5 bg-linear-to-l <?php echo e($doc->gradient); ?>"></div>
        <div class="p-5 text-right flex flex-col justify-between h-full">
          <div>
            <!-- Header section -->
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-xl overflow-hidden border border-gray-100 shrink-0 shadow-sm bg-gray-50">
                  <img src="<?php echo e($doc->image); ?>" alt="<?php echo e($doc->name); ?>" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=150&q=80'" />
                </div>
                <div class="text-right">
                  <h3 class="font-bold text-gray-800 text-base"><?php echo e($doc->name); ?></h3>
                  <p class="text-xs text-primary-600 font-bold mt-0.5"><?php echo e($doc->specialty); ?></p>
                </div>
              </div>

              <!-- Active Badge/Status Toggle -->
              <form action="<?php echo e(route('admin.doctors.update', $doc->id)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="name" value="<?php echo e($doc->name); ?>" />
                <input type="hidden" name="specialty" value="<?php echo e($doc->specialty); ?>" />
                <input type="hidden" name="department" value="<?php echo e($doc->department); ?>" />
                <input type="hidden" name="rating" value="<?php echo e($doc->rating); ?>" />
                <input type="hidden" name="experience" value="<?php echo e($doc->experience); ?>" />
                <input type="hidden" name="patients" value="<?php echo e($doc->patients); ?>" />
                <input type="hidden" name="gradient" value="<?php echo e($doc->gradient); ?>" />
                <?php if($doc->active): ?>
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

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-2 bg-gray-50 rounded-xl p-3 text-center text-xs text-gray-500 mb-4 font-bold">
              <div>
                <p class="text-gray-400 font-normal mb-0.5">الخبرة</p>
                <p class="text-gray-800 text-sm font-black"><?php echo e($doc->experience); ?> سنة</p>
              </div>
              <div class="border-x border-gray-200">
                <p class="text-gray-400 font-normal mb-0.5">المرضى</p>
                <p class="text-gray-800 text-sm font-black">+<?php echo e($doc->patients); ?></p>
              </div>
              <div>
                <p class="text-gray-400 font-normal mb-0.5">التقييم</p>
                <p class="text-amber-500 text-sm font-black">★ <?php echo e($doc->rating); ?></p>
              </div>
            </div>

            <div class="space-y-1.5 text-xs text-gray-500 mb-5">
              <div class="flex items-center gap-2">
                <i data-lucide="hospital" class="w-4 h-4 text-gray-400"></i>
                <span>القسم: <strong><?php echo e($doc->department); ?></strong></span>
              </div>
            </div>
          </div>

          <!-- Card actions -->
          <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
            <button
              onclick="openEditModal(<?php echo e($doc->id); ?>, '<?php echo e(addslashes($doc->name)); ?>', '<?php echo e(addslashes($doc->specialty)); ?>', '<?php echo e(addslashes($doc->description ?? '')); ?>', '<?php echo e(addslashes($doc->department)); ?>', '<?php echo e($doc->rating); ?>', '<?php echo e(preg_replace('/[^0-9]/', '', $doc->experience)); ?>', '<?php echo e(preg_replace('/[^0-9]/', '', $doc->patients)); ?>', '<?php echo e($doc->gradient); ?>', <?php echo e($doc->active ? 'true' : 'false'); ?>)"
              class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
            >
              <i data-lucide="edit" class="w-3.5 h-3.5"></i>
              <span>تعديل البيانات</span>
            </button>

            <form action="<?php echo e(route('admin.doctors.destroy', $doc->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من حذف الطبيب نهائياً؟');">
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
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="users" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا يوجد أطباء مسجلين</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Create Doctor Modal -->
  <div id="create-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">إضافة طبيب جديد</h3>
      </div>
      
      <form action="<?php echo e(route('admin.doctors.store')); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الطبيب الكامل</label>
            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="د. أحمد مصطفى" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التخصص الطبي الدقيق</label>
            <input type="text" name="specialty" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="استشاري جراحة القلب" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف الطبيب</label>
          <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="نبذة عن الطبيب وخبراته..."></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">القسم الطبي المسند</label>
            <select name="department" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التنسيق / المظهر اللوني</label>
            <select name="gradient" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $gradients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">سنوات الخبرة</label>
            <input type="number" name="experience" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="10" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">عدد المرضى</label>
            <input type="number" name="patients" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="500" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التقييم (1-5)</label>
            <input type="number" name="rating" step="0.1" min="1" max="5" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="4.9" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">صورة الطبيب الشخصية</label>
          <input type="file" name="image" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" accept="image/*" />
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" checked id="create-active" />
          <label for="create-active" class="text-sm font-bold">الحساب نشط (يظهر في الموقع للجمهور)</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-linear-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">إضافة الطبيب</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Doctor Modal -->
  <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات الطبيب</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الطبيب الكامل</label>
            <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التخصص الطبي الدقيق</label>
            <input type="text" name="specialty" id="edit-specialty" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف الطبيب</label>
          <textarea name="description" id="edit-description" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="نبذة عن الطبيب وخبراته..."></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">القسم الطبي المسند</label>
            <select name="department" id="edit-department" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التنسيق / المظهر اللوني</label>
            <select name="gradient" id="edit-gradient" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <?php $__currentLoopData = $gradients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>"><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">سنوات الخبرة</label>
            <input type="number" name="experience" id="edit-experience" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">عدد المرضى</label>
            <input type="number" name="patients" id="edit-patients" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التقييم (1-5)</label>
            <input type="number" name="rating" id="edit-rating" step="0.1" min="1" max="5" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">تحديث صورة الطبيب الشخصية <span class="text-gray-400 font-normal">(اتركها فارغة لعدم التعديل)</span></label>
          <input type="file" name="image" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" accept="image/*" />
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" id="edit-active" />
          <label for="edit-active" class="text-sm font-bold">الحساب نشط (يظهر في الموقع للجمهور)</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-linear-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterDoctors() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.doctor-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const specialty = card.getAttribute('data-specialty').toLowerCase();
        const dept = card.getAttribute('data-dept').toLowerCase();
        
        if (name.includes(query) || specialty.includes(query) || dept.includes(query)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    }

    function openCreateModal() {
      document.getElementById('create-modal').style.display = 'flex';
    }

    function closeCreateModal() {
      document.getElementById('create-modal').style.display = 'none';
    }

    function openEditModal(id, name, specialty, description, department, rating, experience, patients, gradient, active) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/doctors/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-specialty').value = specialty;
      document.getElementById('edit-description').value = description;
      document.getElementById('edit-department').value = department;
      document.getElementById('edit-rating').value = rating;
      document.getElementById('edit-experience').value = experience;
      document.getElementById('edit-patients').value = patients;
      document.getElementById('edit-gradient').value = gradient;
      document.getElementById('edit-active').checked = active;
      
      document.getElementById('edit-modal').style.display = 'flex';
    }

    function closeEditModal() {
      document.getElementById('edit-modal').style.display = 'none';
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\admin\doctors\index.blade.php ENDPATH**/ ?>