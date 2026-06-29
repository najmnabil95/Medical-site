<?php
  $groupedPriceItems = $priceItems->groupBy('category');
?>

<section id="cost-calculator" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
  <div class="absolute top-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-600 bg-emerald-500/10">
        💰 حاسبة التكلفة
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        احسب تكلفة
        <span class="text-primary-600"> خدمتك</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        اختر الخدمات التي تحتاجها واحصل على تقدير فوري للتكلفة الإجمالية
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    <!-- Calculator Grid -->
    <div class="grid lg:grid-cols-3 gap-6 animate-fade-in-up">
      
      <!-- Services Selection Column -->
      <div class="lg:col-span-2 space-y-3">
        <?php $__currentLoopData = $groupedPriceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $catId = 'cat-' . Str::slug($category);
          ?>
          <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <button
              onclick="toggleCalculatorCategory('<?php echo e($catId); ?>')"
              class="w-full p-4 flex items-center justify-between hover:bg-gray-50 transition-colors cursor-pointer"
            >
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white">
                  <i data-lucide="calculator" class="w-4 h-4"></i>
                </div>
                <span class="font-bold text-gray-800"><?php echo e($category); ?></span>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                  <?php echo e($items->count()); ?> خدمة
                </span>
              </div>
              <i data-lucide="chevron-down" id="arrow-<?php echo e($catId); ?>" class="text-gray-400 transition-transform"></i>
            </button>

            <div id="content-<?php echo e($catId); ?>" class="hidden border-t border-gray-100 p-4 grid grid-cols-1 md:grid-cols-2 gap-2">
              <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                  id="calc-item-btn-<?php echo e($item->id); ?>"
                  onclick="toggleCalculatorItem(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->service)); ?>', <?php echo e($item->price); ?>)"
                  class="calc-service-btn flex items-center justify-between p-3 rounded-xl border-2 border-gray-100 hover:border-gray-200 transition-all text-right cursor-pointer"
                >
                  <div class="flex-1">
                    <p class="font-medium text-gray-800 text-sm"><?php echo e($item->service); ?></p>
                    <p class="text-primary-600 font-bold text-sm mt-1"><?php echo e($item->price); ?> <?php echo e($item->currency ?? 'ر.س'); ?></p>
                  </div>
                  <div id="calc-item-indicator-<?php echo e($item->id); ?>" class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 bg-gray-100 text-gray-400 transition-all">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                  </div>
                </button>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <!-- Summary Column -->
      <div class="lg:col-span-1">
        <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-6 text-white shadow-2xl shadow-primary-500/20 sticky top-24">
          <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="calculator" class="w-5.5 h-5.5"></i>
            <span>ملخص التكلفة</span>
          </h3>

          <!-- Empty State -->
          <div id="calc-empty-state" class="text-center py-8">
            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <i data-lucide="calculator" class="text-white/60 w-7 h-7"></i>
            </div>
            <p class="text-white/60 text-sm">اختر الخدمات لعرض التكلفة</p>
          </div>

          <!-- Active Summary -->
          <div id="calc-active-summary" class="hidden">
            <div id="calc-selected-list" class="space-y-3 mb-5 max-h-60 overflow-y-auto pr-1">
              <!-- Selected items loaded dynamically -->
            </div>

            <div class="border-t border-white/20 pt-4 space-y-2 text-gray-100">
              <div class="flex items-center justify-between text-sm">
                <span class="text-white/60">المجموع الفرعي</span>
                <span id="calc-subtotal" class="font-bold">0 ر.س</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-white/60">ضريبة القيمة المضافة (15%)</span>
                <span id="calc-vat" class="font-bold">0 ر.س</span>
              </div>
              <div class="flex items-center justify-between pt-3 border-t border-white/20">
                <span class="font-bold text-lg text-white">الإجمالي</span>
                <span id="calc-total" class="text-3xl font-black text-emerald-300">0 ر.س</span>
              </div>
            </div>

            <div class="mt-6 space-y-2">
              <a
                href="#appointment"
                onclick="event.preventDefault(); document.getElementById('appointment').scrollIntoView({behavior: 'smooth'});"
                class="w-full bg-white text-primary-700 py-3 rounded-xl font-bold text-sm hover:bg-gray-100 transition-colors flex items-center justify-center gap-2 cursor-pointer"
              >
                احجز الآن
              </a>
              <button
                onclick="resetCostCalculator()"
                class="w-full bg-white/10 text-white py-3 rounded-xl font-bold text-sm hover:bg-white/20 transition-colors cursor-pointer"
              >
                إعادة تعيين
              </button>
            </div>
          </div>

          <p class="text-white/40 text-xs text-center mt-5">
            * الأسعار تقديرية وقد تتغير حسب الحالة
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  let selectedItems = {};

  function toggleCalculatorCategory(catId) {
    const content = document.getElementById('content-' + catId);
    const arrow = document.getElementById('arrow-' + catId);
    if (content.classList.contains('hidden')) {
      content.classList.remove('hidden');
      arrow.style.transform = 'rotate(180deg)';
    } else {
      content.classList.add('hidden');
      arrow.style.transform = 'rotate(0deg)';
    }
  }

  function toggleCalculatorItem(id, name, price) {
    const btn = document.getElementById('calc-item-btn-' + id);
    const indicator = document.getElementById('calc-item-indicator-' + id);

    if (selectedItems[id]) {
      // Remove it
      delete selectedItems[id];
      btn.classList.remove('border-primary-500', 'bg-primary-50');
      btn.classList.add('border-gray-100');
      indicator.classList.remove('bg-primary-500', 'text-white');
      indicator.classList.add('bg-gray-100', 'text-gray-400');
      indicator.innerHTML = '<i data-lucide="plus" class="w-3.5 h-3.5"></i>';
    } else {
      // Add it
      selectedItems[id] = { name, price };
      btn.classList.add('border-primary-500', 'bg-primary-50');
      btn.classList.remove('border-gray-100');
      indicator.classList.add('bg-primary-500', 'text-white');
      indicator.classList.remove('bg-gray-100', 'text-gray-400');
      indicator.innerHTML = '<i data-lucide="minus" class="w-3.5 h-3.5"></i>';
    }
    lucide.createIcons();
    recalculateCosts();
  }

  function recalculateCosts() {
    const keys = Object.keys(selectedItems);
    const emptyState = document.getElementById('calc-empty-state');
    const activeSummary = document.getElementById('calc-active-summary');
    const selectedList = document.getElementById('calc-selected-list');

    if (keys.length === 0) {
      emptyState.classList.remove('hidden');
      activeSummary.classList.add('hidden');
      return;
    }

    emptyState.classList.add('hidden');
    activeSummary.classList.remove('hidden');

    let subtotal = 0;
    selectedList.innerHTML = '';

    keys.forEach(id => {
      const item = selectedItems[id];
      subtotal += item.price;

      const row = document.createElement('div');
      row.className = 'flex items-center justify-between bg-white/10 rounded-xl p-3';
      row.innerHTML = `
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium truncate text-white">${item.name}</p>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-sm font-bold text-white">${item.price} ر.س</span>
          <button onclick="toggleCalculatorItem(${id}, '', 0)" class="w-6 h-6 bg-white/20 rounded-md flex items-center justify-center hover:bg-white/30 text-white cursor-pointer">
            <i data-lucide="minus" class="w-3 h-3"></i>
          </button>
        </div>
      `;
      selectedList.appendChild(row);
    });

    const vat = subtotal * 0.15;
    const total = subtotal + vat;

    document.getElementById('calc-subtotal').textContent = subtotal.toLocaleString() + ' ر.س';
    document.getElementById('calc-vat').textContent = vat.toLocaleString() + ' ر.س';
    document.getElementById('calc-total').textContent = total.toLocaleString() + ' ر.س';
    
    lucide.createIcons();
  }

  function resetCostCalculator() {
    Object.keys(selectedItems).forEach(id => {
      const btn = document.getElementById('calc-item-btn-' + id);
      const indicator = document.getElementById('calc-item-indicator-' + id);
      if (btn) btn.classList.remove('border-primary-500', 'bg-primary-50');
      if (btn) btn.classList.add('border-gray-100');
      if (indicator) indicator.classList.remove('bg-primary-500', 'text-white');
      if (indicator) indicator.classList.add('bg-gray-100', 'text-gray-400');
      if (indicator) indicator.innerHTML = '<i data-lucide="plus" class="w-3.5 h-3.5"></i>';
    });
    selectedItems = {};
    recalculateCosts();
  }

  // Open first category by default on load
  document.addEventListener("DOMContentLoaded", () => {
    const firstCat = document.querySelector('[onclick^="toggleCalculatorCategory"]');
    if (firstCat) {
      firstCat.click();
    }
  });
</script>
<?php /**PATH D:\laravel-hospital-website-development\resources\views/components/home/CostCalculator.blade.php ENDPATH**/ ?>