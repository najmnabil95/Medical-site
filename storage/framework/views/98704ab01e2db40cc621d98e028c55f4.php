<section id="faq" class="py-24 bg-gray-50 relative overflow-hidden">
  <!-- Decorative background shape -->
  <div class="absolute top-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-600 bg-emerald-500/10">
        الأسئلة الشائعة
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        أسئلة
        <span class="text-primary-600"> متكررة</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        إجابات على أكثر الأسئلة شيوعاً من مرضانا ومراجعينا
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    <!-- Content Grid -->
    <div class="grid lg:grid-cols-3 gap-8 animate-fade-in-up">
      
      <!-- Accordion Column -->
      <div class="lg:col-span-2 space-y-4">
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div
            id="faq-item-<?php echo e($faq->id); ?>"
            class="faq-accordion bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden"
          >
            <button
              onclick="toggleFaqAccordion(<?php echo e($faq->id); ?>)"
              class="w-full flex items-center justify-between p-6 text-right cursor-pointer"
            >
              <div class="flex items-center gap-4">
                <span class="faq-number-badge w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold bg-gray-100 text-gray-500 transition-all duration-300">
                  <?php echo e(sprintf("%02d", $index + 1)); ?>

                </span>
                <h4 class="faq-question-text font-bold text-lg text-gray-800 transition-colors">
                  <?php echo e($faq->question); ?>

                </h4>
              </div>
              <i data-lucide="chevron-down" class="faq-chevron text-gray-400 transition-transform duration-300 shrink-0 mr-4"></i>
            </button>
            <div class="faq-answer-content max-h-0 opacity-0 overflow-hidden transition-all duration-300">
              <div class="px-6 pb-6 pr-20">
                <p class="text-gray-600 leading-relaxed"><?php echo e($faq->answer); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <!-- Call to Action Card -->
      <div class="space-y-6">
        <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-8 text-white sticky top-24 shadow-2xl shadow-primary-500/20">
          <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
            <i data-lucide="help-circle" class="text-white w-8 h-8"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3">لم تجد إجابتك؟</h3>
          <p class="text-white/70 mb-6 leading-relaxed">
            فريق خدمة العملاء لدينا جاهز للإجابة على جميع استفساراتكم في أي وقت
          </p>
          <div class="space-y-3">
            <a
              href="tel:<?php echo e($settings->phone_en ?? '920012345'); ?>"
              class="flex items-center gap-3 bg-white/10 rounded-xl p-4 hover:bg-white/20 transition-all group"
            >
              <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform text-xl">
                📞
              </div>
              <div>
                <p class="text-white/60 text-xs">اتصل بنا</p>
                <p class="font-bold" dir="ltr"><?php echo e($settings->phone_en ?? '920012345'); ?></p>
              </div>
            </a>
            <a
              href="#contact"
              onclick="event.preventDefault(); document.getElementById('contact').scrollIntoView({behavior: 'smooth'});"
              class="flex items-center gap-3 bg-white/10 rounded-xl p-4 hover:bg-white/20 transition-all group cursor-pointer"
            >
              <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="message-circle" class="w-5 h-5 text-white"></i>
              </div>
              <div>
                <p class="text-white/60 text-xs">أرسل رسالة</p>
                <p class="font-bold">تواصل معنا</p>
              </div>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  function toggleFaqAccordion(id) {
    const activeAccordion = document.getElementById('faq-item-' + id);
    const content = activeAccordion.querySelector('.faq-answer-content');
    const chevron = activeAccordion.querySelector('.faq-chevron');
    const badge = activeAccordion.querySelector('.faq-number-badge');
    const questionText = activeAccordion.querySelector('.faq-question-text');

    const allAccordions = document.querySelectorAll('.faq-accordion');
    allAccordions.forEach(item => {
      if (item.id !== 'faq-item-' + id) {
        const itemContent = item.querySelector('.faq-answer-content');
        const itemChevron = item.querySelector('.faq-chevron');
        const itemBadge = item.querySelector('.faq-number-badge');
        const itemQuestionText = item.querySelector('.faq-question-text');

        item.classList.remove('border-primary-200', 'shadow-lg', 'shadow-primary-500/10');
        item.classList.add('border-gray-100');
        itemContent.classList.add('max-h-0', 'opacity-0');
        itemContent.style.maxHeight = '0px';
        itemChevron.style.transform = 'rotate(0deg)';
        itemChevron.classList.remove('text-primary-600');
        itemBadge.classList.remove('bg-primary-600', 'text-white');
        itemBadge.classList.add('bg-gray-100', 'text-gray-500');
        itemQuestionText.classList.remove('text-primary-700');
        itemQuestionText.classList.add('text-gray-800');
      }
    });

    if (content.classList.contains('max-h-0')) {
      activeAccordion.classList.add('border-primary-200', 'shadow-lg', 'shadow-primary-500/10');
      activeAccordion.classList.remove('border-gray-100');
      content.classList.remove('max-h-0', 'opacity-0');
      content.style.maxHeight = content.scrollHeight + 'px';
      chevron.style.transform = 'rotate(180deg)';
      chevron.classList.add('text-primary-600');
      badge.classList.add('bg-primary-600', 'text-white');
      badge.classList.remove('bg-gray-100', 'text-gray-500');
      questionText.classList.add('text-primary-700');
      questionText.classList.remove('text-gray-800');
    } else {
      activeAccordion.classList.remove('border-primary-200', 'shadow-lg', 'shadow-primary-500/10');
      activeAccordion.classList.add('border-gray-100');
      content.classList.add('max-h-0', 'opacity-0');
      content.style.maxHeight = '0px';
      chevron.style.transform = 'rotate(0deg)';
      chevron.classList.remove('text-primary-600');
      badge.classList.remove('bg-primary-600', 'text-white');
      badge.classList.add('bg-gray-100', 'text-gray-500');
      questionText.classList.remove('text-primary-700');
      questionText.classList.add('text-gray-800');
    }
  }

  // Open first item by default on load
  document.addEventListener("DOMContentLoaded", () => {
    const accordions = document.querySelectorAll('.faq-accordion');
    if (accordions.length > 0) {
      const firstId = accordions[0].id.replace('faq-item-', '');
      toggleFaqAccordion(firstId);
    }
  });
</script>
<?php /**PATH D:\laravel-hospital-website-development\hospital-backend\resources\views/components/home/FAQ.blade.php ENDPATH**/ ?>