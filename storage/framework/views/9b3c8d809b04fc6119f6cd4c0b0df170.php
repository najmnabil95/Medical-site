<?php $__env->startSection('title', 'الأسئلة الشائعة - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="help-circle" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة الأسئلة الشائعة</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تعديل وإضافة الأسئلة والأجوبة المتكررة لمساعدة زوار الموقع بشكل أسرع</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة سؤال وجواب</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث في الأسئلة أو الأجوبة..."
        onkeyup="filterFaqs()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- FAQs List -->
  <div class="space-y-4" id="faqs-list">
    <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div
        class="faq-card bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md transition-all text-right flex flex-col md:flex-row md:items-start justify-between gap-4"
        data-question="<?php echo e($faq->question); ?>"
        data-answer="<?php echo e($faq->answer); ?>"
      >
        <div class="flex-1">
          <div class="flex items-center gap-2 text-primary-700 font-bold mb-2">
            <span class="w-2 h-2 rounded-full bg-primary-500"></span>
            <h4><?php echo e($faq->question); ?></h4>
          </div>
          <p class="text-gray-500 text-sm leading-relaxed pr-4">
            <?php echo e($faq->answer); ?>

          </p>
        </div>

        <div class="flex items-center gap-2 shrink-0 self-end md:self-auto">
          <button
            onclick="openEditModal(<?php echo e($faq->id); ?>, '<?php echo e(addslashes($faq->question)); ?>', '<?php echo e(addslashes($faq->answer)); ?>')"
            class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer"
            title="تعديل"
          >
            <i data-lucide="edit" class="w-4 h-4"></i>
          </button>
          
          <form action="<?php echo e(route('admin.faqs.destroy', $faq->id)); ?>" method="POST" onsubmit="return confirm('هل تريد حذف هذا السؤال نهائياً؟');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors cursor-pointer" title="حذف">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="help-circle" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا توجد أسئلة شائعة مسجلة حالياً</p>
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
        <h3 class="text-xl font-bold text-gray-800">إضافة سؤال شائع جديد</h3>
      </div>
      
      <form action="<?php echo e(route('admin.faqs.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">السؤال الموجه للمريض</label>
          <input type="text" name="question" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="ما هي مواعيد الزيارة الرسمية للمرضى المنومين؟" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الإجابة الكاملة</label>
          <textarea name="answer" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-28" placeholder="تبدأ مواعيد الزيارة من الساعة 4:00 عصراً وحتى 8:00 مساءً يومياً في جميع الأقسام ما عدا العناية المركزة..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ السؤال</button>
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
        <h3 class="text-xl font-bold text-gray-800">تعديل السؤال الشائع</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">السؤال الموجه للمريض</label>
          <input type="text" name="question" id="edit-question" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الإجابة الكاملة</label>
          <textarea name="answer" id="edit-answer" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-28"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterFaqs() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.faq-card');
      
      cards.forEach(card => {
        const question = card.getAttribute('data-question').toLowerCase();
        const answer = card.getAttribute('data-answer').toLowerCase();
        
        if (question.includes(query) || answer.includes(query)) {
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

    function openEditModal(id, question, answer) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/faqs/${id}`;
      
      document.getElementById('edit-question').value = question;
      document.getElementById('edit-answer').value = answer;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views\admin\faqs\index.blade.php ENDPATH**/ ?>