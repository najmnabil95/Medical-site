<?php $__env->startSection('title', 'شركاء النجاح - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="handshake" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة شركاء النجاح والمؤسسات</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تعديل وإضافة المؤسسات، الكليات، والمستشفيات الشريكة محلياً وعالمياً</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة شريك جديد</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم الشريك أو الوصف..."
        onkeyup="filterPartners()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Partners Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="partners-grid">
    <?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ptnr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div
        class="partner-card bg-white rounded-2xl border border-gray-100 p-5 text-right flex flex-col justify-between hover:shadow-lg transition-all"
        data-name="<?php echo e($ptnr->name); ?>"
        data-sub="<?php echo e($ptnr->sub); ?>"
      >
        <div>
          <div class="flex items-center justify-between mb-4">
            <span class="text-3xl filter drop-shadow-sm select-none">
              <?php echo e($ptnr->emoji); ?>

            </span>
          </div>

          <h3 class="text-base font-bold text-gray-800 mb-1"><?php echo e($ptnr->name); ?></h3>
          <p class="text-gray-400 text-xs font-semibold"><?php echo e($ptnr->sub); ?></p>
        </div>

        <div class="flex items-center gap-2 pt-3 border-t border-gray-50 mt-6">
          <button
            onclick="openEditModal(<?php echo e($ptnr->id); ?>, '<?php echo e(addslashes($ptnr->name)); ?>', '<?php echo e(addslashes($ptnr->sub)); ?>', '<?php echo e($ptnr->emoji); ?>')"
            class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
          >
            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
            <span>تعديل</span>
          </button>

          <form action="<?php echo e(route('admin.partners.destroy', $ptnr->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('هل تريد إزالة هذا الشريك نهائياً؟');">
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
        <i data-lucide="handshake" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا يوجد شركاء نجاح مضافين حالياً</p>
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
        <h3 class="text-xl font-bold text-gray-800">إضافة شريك نجاح جديد</h3>
      </div>
      
      <form action="<?php echo e(route('admin.partners.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم الشريك / المؤسسة</label>
          <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="جامعة الملك سعود الطبية" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الوصف الفرعي / نوع الشراكة</label>
          <input type="text" name="sub" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="شراكة تدريب وبحوث علمية" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الرمز التعبيري (Emoji) أو الحرف الممثل</label>
          <input type="text" name="emoji" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="🎓" />
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ الشريك</button>
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
        <h3 class="text-xl font-bold text-gray-800">تعديل شريك النجاح</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم الشريك / المؤسسة</label>
          <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الوصف الفرعي / نوع الشراكة</label>
          <input type="text" name="sub" id="edit-sub" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الرمز التعبيري (Emoji) أو الحرف الممثل</label>
          <input type="text" name="emoji" id="edit-emoji" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterPartners() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.partner-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const sub = card.getAttribute('data-sub').toLowerCase();
        
        if (name.includes(query) || sub.includes(query)) {
          card.style.display = 'block';
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

    function openEditModal(id, name, sub, emoji) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/partners/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-sub').value = sub;
      document.getElementById('edit-emoji').value = emoji;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/admin/partners/index.blade.php ENDPATH**/ ?>