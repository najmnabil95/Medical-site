<?php $__env->startSection('title'); ?>
    كادرنا الطبي والاستشاريين | <?php echo e($settings->site_name ?? 'مستشفى الشفاء الدولي'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Simple Header & Search Section -->
  <section class="py-16 bg-white text-right">
    <div class="max-w-7xl mx-auto px-4">
      <!-- Back to Home Button -->
      <div class="mb-8 flex justify-start">
        <a href="<?php echo e(route('home')); ?>#doctors" class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gray-300 text-gray-700 hover:text-gray-900 font-bold text-sm transition-all duration-300 shadow-sm cursor-pointer">
          <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
          <span>العودة للصفحة الرئيسية</span>
        </a>
      </div>

      <div class="flex flex-col md:flex-row gap-6 items-center justify-between border-b border-gray-100 pb-10">
        <div>
          <span class="text-xs font-bold text-primary-600 bg-primary-50 px-3.5 py-1.5 rounded-full inline-block mb-3">
            دليل الأطباء
          </span>
          <h1 class="text-3xl md:text-4xl font-black text-gray-950 leading-tight">
            أطباؤنا واستشاريينا
          </h1>
          <p class="text-gray-500 text-sm mt-2">البحث وتصفح قائمة الأطباء والاستشاريين في مستشفى عبدالقادر المتوكل</p>
        </div>

        <!-- Clean Search Input Box -->
        <div class="w-full md:w-96 shrink-0">
          <div class="flex items-center gap-2 bg-gray-50 px-4 py-3.5 rounded-xl border border-gray-200 focus-within:border-primary-500 focus-within:bg-white focus-within:shadow-md transition-all">
            <i data-lucide="search" class="text-gray-400 w-5 h-5 shrink-0"></i>
            <input
              type="text"
              id="doctor-search"
              onkeyup="searchDoctors()"
              placeholder="ابحث باسم الطبيب، العيادة، أو التخصص..."
              class="bg-transparent outline-none flex-1 text-sm text-right w-full placeholder:text-gray-400 text-gray-800"
            />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Doctors Directory Grid -->
  <section class="pb-24 bg-white min-h-[400px]">
    <div class="max-w-7xl mx-auto px-4">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="doctors-cards-grid">
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $gradient = $doc->gradient ?? 'from-primary-500 to-primary-700';
          ?>
          <div
            class="doctor-card-item group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100"
            data-name="<?php echo e($doc->name); ?>"
            data-specialty="<?php echo e($doc->specialty); ?>"
            data-department="<?php echo e($doc->department); ?>"
          >
            <!-- Image Container -->
            <div class="relative overflow-hidden h-72">
              <img
                src="<?php echo e($doc->image); ?>"
                alt="<?php echo e($doc->name); ?>"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

              <!-- Gradient Overlay on hover -->
              <div class="absolute inset-0 bg-gradient-to-t <?php echo e($gradient); ?> opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>

              <!-- Rating -->
              <div class="absolute bottom-5 right-5 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 flex items-center gap-1 shadow-lg">
                <i data-lucide="star" class="text-yellow-500 fill-current w-3.5 h-3.5"></i>
                <span class="text-sm font-bold text-gray-800"><?php echo e($doc->rating); ?></span>
              </div>
            </div>

            <!-- Info Panel -->
            <div class="p-6 text-right">
              <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                <?php echo e($doc->name); ?>

              </h3>
              <p class="text-primary-600 text-sm font-medium mt-1.5"><?php echo e($doc->specialty); ?></p>
              <p class="text-gray-400 text-xs mt-1"><?php echo e($doc->department); ?></p>

              <div class="flex items-center justify-between mt-5 pt-5 border-t border-gray-100 text-gray-700">
                <div class="text-center">
                  <div class="text-sm font-bold text-gray-800"><?php echo e($doc->experience); ?></div>
                  <div class="text-xs text-gray-400 mt-0.5">خبرة</div>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="text-center">
                  <div class="text-sm font-bold text-gray-800"><?php echo e($doc->patients); ?></div>
                  <div class="text-xs text-gray-400 mt-0.5">مريض</div>
                </div>
              </div>

              <a
                href="<?php echo e(route('home')); ?>?dept=<?php echo e(urlencode($doc->department)); ?>&doc=<?php echo e(urlencode($doc->name)); ?>"
                class="mt-5 w-full bg-gradient-to-l <?php echo e($gradient); ?> text-white py-3 rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2 opacity-90 hover:opacity-100 cursor-pointer"
              >
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>احجز موعد</span>
              </a>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <!-- No Results State -->
      <div id="no-results" class="hidden text-center py-20">
        <i data-lucide="users" class="mx-auto text-gray-300 w-16 h-16 mb-4 opacity-50"></i>
        <h4 class="text-xl font-bold text-gray-700">لا يوجد أطباء مطابقين للبحث</h4>
        <p class="text-gray-400 mt-2 text-sm">حاول البحث باستخدام كلمات أخرى.</p>
      </div>

    </div>
  </section>

  <!-- Clean JS Filtering Script -->
  <script>
    let searchQuery = '';

    function searchDoctors() {
      const searchInput = document.getElementById('doctor-search');
      searchQuery = searchInput.value.toLowerCase().trim();
      applyFilters();
    }

    function applyFilters() {
      const cards = document.querySelectorAll('.doctor-card-item');
      let visibleCount = 0;

      cards.forEach(card => {
        const cardName = card.getAttribute('data-name').toLowerCase();
        const cardSpecialty = card.getAttribute('data-specialty').toLowerCase();
        const cardDept = card.getAttribute('data-department').toLowerCase();

        const matchesSearch = (searchQuery === '' || 
                               cardName.includes(searchQuery) || 
                               cardSpecialty.includes(searchQuery) ||
                               cardDept.includes(searchQuery));

        if (matchesSearch) {
          card.classList.remove('hidden');
          visibleCount++;
        } else {
          card.classList.add('hidden');
        }
      });

      const noResults = document.getElementById('no-results');
      if (visibleCount === 0) {
        noResults.classList.remove('hidden');
      } else {
        noResults.classList.add('hidden');
      }
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/doctors.blade.php ENDPATH**/ ?>