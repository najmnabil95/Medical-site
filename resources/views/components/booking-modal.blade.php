<!-- Store doctors data for JavaScript usage -->
<div id="modal-doctors-data-container" data-doctors='{{ json_encode($doctors) }}' class="hidden" aria-hidden="true"></div>

<!-- Booking Modal -->
<div id="booking-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
  <!-- Backdrop -->
  <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeBookingModal()"></div>
  
  <!-- Modal Content -->
  <div class="bg-white rounded-3xl p-6 md:p-8 shadow-2xl border border-gray-100 max-w-lg w-full relative z-10 animate-scale-in max-h-[90vh] overflow-y-auto" dir="rtl">
    <!-- Close Button -->
    <button type="button" onclick="closeBookingModal()" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600 transition-colors w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center cursor-pointer z-20">
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

      <form id="modal-appointment-booking-form" action="{{ route('appointments.store') }}" method="POST" class="space-y-4 relative text-right" onsubmit="submitModalBookingForm(event)">
        @csrf
        
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
              @foreach($departments as $dept)
              <option value="{{ $dept->name }}">{{ $dept->name }}</option>
              @endforeach
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
              min="{{ date('Y-m-d') }}"
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

<!-- Modal Booking Logic Scripts -->
<script>
  let modalAllDoctorsList = [];
  
  document.addEventListener("DOMContentLoaded", () => {
    const doctorsDataElement = document.getElementById('modal-doctors-data-container');
    if (doctorsDataElement) {
        modalAllDoctorsList = JSON.parse(doctorsDataElement.dataset.doctors);
    }
  });

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
    if(typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
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

    const filteredDocs = modalAllDoctorsList.filter(d => d.department === selectedDept);

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
