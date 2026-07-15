<section id="news-section" class="py-24 bg-white relative overflow-hidden">
  
  <div class="absolute top-0 right-0 w-96 h-96 bg-blue-50/40 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-50/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">

    
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-blue-600 bg-blue-500/10">
        أخبار وأحداث
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        آخر
        <span class="text-primary-600">الأخبار والمقالات</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        تابع آخر الأخبار والمقالات الطبية وإنجازات المستشفى
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php $__empty_1 = true; $__currentLoopData = $news->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $categoryColors = [
          'أخبار المستشفى' => 'bg-blue-50 text-blue-700 border-blue-200',
          'نصائح طبية' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
          'تقنية طبية' => 'bg-purple-50 text-purple-700 border-purple-200',
          'التغذية والرياضة' => 'bg-amber-50 text-amber-700 border-amber-200',
          'الأبحاث والدراسات' => 'bg-rose-50 text-rose-700 border-rose-200',
        ];
        $catClass = $categoryColors[$article->category] ?? 'bg-gray-50 text-gray-700 border-gray-200';
      ?>
      <article class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 <?php echo e($index === 0 && $article->featured ? 'md:col-span-2 md:row-span-1' : ''); ?>">
        
        <div class="relative overflow-hidden <?php echo e($index === 0 && $article->featured ? 'h-56 md:h-72' : 'h-52'); ?>">
          <?php if($article->image): ?>
            <img
              src="<?php echo e($article->image); ?>"
              alt="<?php echo e($article->title); ?>"
              loading="lazy"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />
          <?php else: ?>
            <div class="w-full h-full bg-linear-to-br from-primary-100 to-primary-200 flex items-center justify-center">
              <i data-lucide="newspaper" class="w-16 h-16 text-primary-400"></i>
            </div>
          <?php endif; ?>
          <div class="absolute inset-0 bg-linear-to-t from-black/50 via-transparent to-transparent"></div>

          
          <div class="absolute top-4 right-4">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold border <?php echo e($catClass); ?> backdrop-blur-sm bg-opacity-90">
              <?php echo e($article->category); ?>

            </span>
          </div>

          <?php if($article->featured): ?>
          <div class="absolute top-4 left-4">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-amber-400 text-amber-900 flex items-center gap-1">
              <i data-lucide="star" class="w-3 h-3 fill-current"></i>
              مميز
            </span>
          </div>
          <?php endif; ?>

          
          <div class="absolute bottom-4 right-4 bg-white/95 backdrop-blur-sm rounded-xl px-3 py-2 shadow-lg">
            <p class="text-xs font-bold text-gray-800"><?php echo e(\Carbon\Carbon::parse($article->date)->locale('ar')->isoFormat('D MMMM YYYY')); ?></p>
          </div>
        </div>

        
        <div class="p-6">
          <h3 class="text-lg font-black text-gray-900 group-hover:text-primary-600 transition-colors leading-snug mb-3 line-clamp-2">
            <?php echo e($article->title); ?>

          </h3>

          <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-2">
            <?php echo e($article->excerpt); ?>

          </p>

          <div class="flex items-center justify-between pt-4 border-t border-gray-50">
            <div class="flex items-center gap-2 text-gray-400 text-xs">
              <i data-lucide="user" class="w-3.5 h-3.5"></i>
              <span><?php echo e($article->author); ?></span>
            </div>
            <?php if($article->read_time): ?>
            <div class="flex items-center gap-1.5 text-gray-400 text-xs">
              <i data-lucide="clock" class="w-3.5 h-3.5"></i>
              <span><?php echo e($article->read_time); ?></span>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-span-full text-center py-16">
        <i data-lucide="newspaper" class="w-16 h-16 text-gray-200 mx-auto mb-4"></i>
        <p class="text-gray-400 text-lg">لا توجد أخبار متاحة حالياً</p>
      </div>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php /**PATH D:\laravel-hospital-website-development\resources\views\components\home\NewsSection.blade.php ENDPATH**/ ?>