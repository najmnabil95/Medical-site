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

              <button
                type="button"
                onclick="openBookingModal('<?php echo e($doc->department); ?>', '<?php echo e($doc->name); ?>')"
                class="mt-5 w-full bg-gradient-to-l <?php echo e($gradient); ?> text-white py-3 rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2 opacity-90 hover:opacity-100 cursor-pointer"
              >
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>احجز موعد</span>
              </button>
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

  <!-- Store doctors data for JavaScript usage -->
  <div id="doctors-data-container" data-doctors='<?php echo e(json_encode($doctors)); ?>' class="hidden" aria-hidden="true"></div>

  <!-- Booking Modal -->
  <div id="booking-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeBookingModal()"></div>
    
    <!-- Modal Content -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-2xl border border-gray-100 max-w-lg w-full relative z-10 animate-scale-in max-h-[90vh] overflow-y-auto">
      <!-- Close Button -->
      <button onclick="closeBookingModal()" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600 transition-colors w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center cursor-pointer">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>

      <!-- Success State -->
      <div id="modal-booking-success-state" class="hidden text-center py-12 space-y-5">
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto animate-scale-in">
          <i data-lucide="check-circle" class="text-emerald-500 w-10 h-10"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900">تم الحجز بنجاح! 🎉</h3>
        <p class="text-gray-500 text-sm max-w-xs mx-auto">سيتم التواصل معك قريباً عبر الهاتف أو رسالة نصية لتأكيد موعدك.</p>
        <button onclick="closeBookingModal()" class="bg-primary-50 text-primary-700 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-100 transition-all cursor-pointer">
          إغلاق
        </button>
      </div>

      <!-- Form State -->
      <div id="modal-booking-form-wrapper">
        <div class="text-right mb-6">
          <h3 class="text-2xl font-black text-gray-900">حجز موعد سريع</h3>
          <p class="text-gray-500 text-xs mt-1">يرجى تعبئة الحقول التالية لتأكيد موعدك.</p>
        </div>

        <form id="modal-appointment-booking-form" action="<?php echo e(route('appointments.store')); ?>" method="POST" class="space-y-4 relative text-right" onsubmit="submitModalBookingForm(event)">
          <?php echo csrf_field(); ?>
          
          <!-- Patient Details -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative">
              <i data-lucide="user" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
              <input
                type="text"
                name="patient_name"
                placeholder="الاسم الكامل للمريض"
                required
                class="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm text-right" />
            </div>
            <div class="relative">
              <i data-lucide="phone" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
              <input
                type="tel"
                name="phone"
                placeholder="رقم الجوال"
                required
                class="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm text-right" />
            </div>
          </div>

          <!-- Specialty & Doctor Select -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative">
              <i data-lucide="stethoscope" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
              <select
                name="department"
                id="modal-appointment-department-select"
                required
                onchange="updateModalDoctorsDropdown(); updateModalTimeSlots();"
                class="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600 text-right">
                <option value="">اختر القسم المطلوب</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="relative">
              <i data-lucide="user" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
              <select
                name="doctor"
                id="modal-appointment-doctor-select"
                disabled
                onchange="updateModalTimeSlots();"
                class="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600 text-right disabled:opacity-50 disabled:cursor-not-allowed">
                <option value="">يرجى اختيار القسم أولاً</option>
              </select>
            </div>
          </div>

          <!-- Date & Time -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative">
              <i data-lucide="calendar" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
              <input
                type="date"
                name="date"
                id="modal-appointment-date-input"
                min="<?php echo e(date('Y-m-d')); ?>"
                required
                onchange="updateModalTimeSlots();"
                class="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm text-right" />
            </div>
            <div class="relative">
              <i data-lucide="clock" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
              <select
                name="time"
                id="modal-appointment-time-select"
                required
                disabled
                class="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600 text-right disabled:opacity-50 disabled:cursor-not-allowed">
                <option value="">يرجى اختيار القسم والتاريخ أولاً</option>
              </select>
            </div>
          </div>

          <!-- Notes -->
          <div class="relative">
            <i data-lucide="message-square" class="absolute right-4 top-4 text-gray-400 w-4.5 h-4.5"></i>
            <textarea
              name="notes"
              placeholder="ملاحظات إضافية أو وصف للحالة (اختياري)"
              rows="2"
              class="w-full pr-12 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm resize-none text-right"></textarea>
          </div>

          <button
            type="submit"
            class="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3.5 rounded-xl font-bold text-base hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-3 group cursor-pointer">
            <i data-lucide="send" class="w-5 h-5 group-hover:-translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
            <span>تأكيد الحجز</span>
          </button>

          <p class="text-gray-400 text-[11px] text-center mt-1">
            🔒 بياناتك محمية وسرية بالكامل
          </p>
        </form>
      </div>
    </div>
  </div>

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

    // Modal Booking Logic
    const doctorsDataElement = document.getElementById('doctors-data-container');
    const allDoctorsList = doctorsDataElement ? JSON.parse(doctorsDataElement.dataset.doctors) : [];

    function openBookingModal(department, doctorName) {
      const modal = document.getElementById('booking-modal');
      const deptSelect = document.getElementById('modal-appointment-department-select');
      const docSelect = document.getElementById('modal-appointment-doctor-select');
      
      // Reset form states
      document.getElementById('modal-booking-form-wrapper').classList.remove('hidden');
      document.getElementById('modal-booking-success-state').classList.add('hidden');
      document.getElementById('modal-appointment-booking-form').reset();

      // Pre-fill department and doctor
      deptSelect.value = department;
      updateModalDoctorsDropdown();
      docSelect.value = doctorName;
      
      // Reset time slots
      const timeSelect = document.getElementById('modal-appointment-time-select');
      timeSelect.disabled = true;
      timeSelect.innerHTML = '<option value="">يرجى اختيار القسم والتاريخ أولاً</option>';

      // Show modal
      modal.classList.remove('hidden');
      lucide.createIcons();
    }

    function closeBookingModal() {
      document.getElementById('booking-modal').classList.add('hidden');
    }

    function updateModalDoctorsDropdown() {
      const deptSelect = document.getElementById('modal-appointment-department-select');
      const docSelect = document.getElementById('modal-appointment-doctor-select');
      const selectedDept = deptSelect.value;

      if (!selectedDept) {
        docSelect.disabled = true;
        docSelect.innerHTML = '<option value="">يرجى اختيار القسم أولاً</option>';
        return;
      }

      docSelect.disabled = false;
      docSelect.innerHTML = '<option value="">اختر الطبيب (اختياري)</option>';

      const filteredDocs = allDoctorsList.filter(d => d.department === selectedDept);

      if (filteredDocs.length === 0) {
        docSelect.innerHTML = '<option value="">لا يوجد أطباء حالياً في هذا القسم</option>';
        docSelect.disabled = true;
        return;
      }

      filteredDocs.forEach(doc => {
        const opt = document.createElement('option');
        opt.value = doc.name;
        opt.textContent = doc.name;
        docSelect.appendChild(opt);
      });
    }

    async function updateModalTimeSlots() {
      const deptSelect = document.getElementById('modal-appointment-department-select');
      const docSelect = document.getElementById('modal-appointment-doctor-select');
      const dateInput = document.getElementById('modal-appointment-date-input');
      const timeSelect = document.getElementById('modal-appointment-time-select');

      const selectedDept = deptSelect.value;
      const selectedDoc = docSelect.value;
      const selectedDate = dateInput.value;

      if (!selectedDept || !selectedDate) {
        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="">يرجى اختيار القسم والتاريخ أولاً</option>';
        return;
      }

      timeSelect.disabled = true;
      timeSelect.innerHTML = '<option value="">جاري تحميل الأوقات المتاحة...</option>';

      try {
        const url = `/available-slots?department=${encodeURIComponent(selectedDept)}&doctor=${encodeURIComponent(selectedDoc)}&date=${encodeURIComponent(selectedDate)}`;
        const response = await fetch(url);
        if (!response.ok) throw new Error('فشل جلب الأوقات');

        const slots = await response.json();

        if (slots.length === 0) {
          timeSelect.innerHTML = '<option value="">لا توجد مواعيد متاحة في هذا اليوم</option>';
          alert('عذراً، لا تتوفر مواعيد متاحة في هذا اليوم لخياراتك الحالية. يرجى اختيار تاريخ آخر.');
          return;
        }

        timeSelect.innerHTML = '<option value="">اختر الوقت المفضل</option>';
        slots.forEach(slot => {
          const opt = document.createElement('option');
          opt.value = slot;
          opt.textContent = slot;
          timeSelect.appendChild(opt);
        });
        timeSelect.disabled = false;
      } catch (error) {
        console.error(error);
        timeSelect.innerHTML = '<option value="">فشل تحميل الأوقات</option>';
      }
    }

    async function submitModalBookingForm(event) {
      event.preventDefault();
      const form = document.getElementById('modal-appointment-booking-form');
      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: formData
        });

        const result = await response.json();
        if (response.ok && result.success) {
          document.getElementById('modal-booking-form-wrapper').classList.add('hidden');
          document.getElementById('modal-booking-success-state').classList.remove('hidden');
          form.reset();
        } else {
          if (response.status === 422 && result.errors) {
            const errorMessages = Object.values(result.errors).flat().join('\n');
            alert('يوجد خطأ في البيانات المدخلة:\n' + errorMessages);
          } else {
            alert(result.message || 'حدث خطأ غير متوقع، يرجى المحاولة لاحقاً.');
          }
        }
      } catch (error) {
        console.error(error);
        alert('فشل الاتصال بالخادم. يرجى التحقق من اتصالك بالإنترنت.');
      }
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/doctors.blade.php ENDPATH**/ ?>