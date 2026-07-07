@php
  $todayDate = date('Y-m-d');
  $appointmentFeatures = [
    ['icon' => 'clock', 'title' => 'مواعيد مرنة', 'desc' => 'اختر الوقت والتاريخ المناسب لك', 'color' => 'bg-primary-50 text-primary-600'],
    ['icon' => 'check-circle', 'title' => 'تأكيد فوري', 'desc' => 'ستتلقى تأكيد الموعد برسالة نصية فوراً', 'color' => 'bg-emerald-50 text-emerald-600'],
    ['icon' => 'stethoscope', 'title' => 'اختر طبيبك', 'desc' => 'حرية اختيار الطبيب والتخصص المناسب', 'color' => 'bg-purple-50 text-purple-600'],
    ['icon' => 'shield', 'title' => 'تأمين طبي', 'desc' => 'نتعامل مع أكثر من 25 شركة تأمين معتمدة', 'color' => 'bg-blue-50 text-blue-600'],
  ];
@endphp

<section id="appointment" class="py-24 bg-white relative overflow-hidden text-gray-700">
  <!-- Background patterns -->
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary-50/80 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-emerald-100/30 rounded-full blur-3xl"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 relative">
    <div class="grid lg:grid-cols-2 gap-16 items-stretch">
      
      <!-- Info Left Column -->
      <div class="space-y-7 animate-fade-in-up text-right">
        <div>
          <span class="text-emerald-600 font-bold text-sm tracking-wider bg-emerald-100 px-5 py-2 rounded-full inline-block">
            احجز موعدك
          </span>
          <h2 class="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-gray-900 mt-5 leading-tight">
            احجز موعدك
            <br />
            <span class="gradient-text">بكل سهولة ويسر</span>
          </h2>
          <p class="text-gray-500 mt-5 text-lg leading-relaxed max-w-lg">
            يمكنك حجز موعدك مع الطبيب المختص بكل سهولة من خلال تعبئة النموذج التالي وسيقوم فريقنا بالتواصل لتأكيد الحجز.
          </p>
        </div>

        <!-- Features list -->
        <div class="space-y-4">
          @foreach($appointmentFeatures as $feat)
            <div class="flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
              <div class="w-12 h-12 {{ $feat['color'] }} rounded-xl flex items-center justify-center shrink-0">
                <i data-lucide="{{ $feat['icon'] }}" class="w-5.5 h-5.5"></i>
              </div>
              <div class="text-right">
                <h4 class="font-bold text-gray-900 text-sm">{{ $feat['title'] }}</h4>
                <p class="text-gray-500 text-xs">{{ $feat['desc'] }}</p>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Emergency info card -->
        <div class="bg-gradient-to-l from-red-500 to-red-600 rounded-2xl p-7 text-white relative overflow-hidden shadow-xl">
          <div class="absolute top-0 left-0 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
          <div class="flex items-center gap-5 relative text-right">
            <div class="w-16 h-16 bg-white/15 rounded-2xl flex items-center justify-center animate-pulse-soft shrink-0">
              <i data-lucide="phone" class="text-white w-7 h-7"></i>
            </div>
            <div>
              <p class="text-white/70 text-sm font-medium">للحالات الطارئة اتصل بنا الآن</p>
              <a href="tel:{{ $settings->emergency ?? '920012345' }}" class="text-3xl font-black mt-1 block" dir="ltr">
                {{ $settings->emergency ?? '920012345' }}
              </a>
              <div class="flex items-center gap-1 mt-1 justify-start">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-white/60 text-xs">متاح على مدار الساعة</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Rating trust metrics -->
        <div class="flex items-center gap-4 pt-2">
          <div class="flex items-center gap-1">
            @for($i = 0; $i < 5; $i++)
              <i data-lucide="star" class="text-yellow-500 fill-current w-4.5 h-4.5"></i>
            @endfor
          </div>
          <span class="text-gray-500 text-sm">تقييم 4.9 من أصل 5 | أكثر من 5000 تقييم</span>
        </div>
      </div>

      <!-- Booking Form Right Column -->
      <div class="bg-white rounded-3xl p-8 md:p-10 shadow-2xl border border-gray-100 relative animate-slide-in-left">
        <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-br-3xl rounded-tl-3xl opacity-10"></div>

        <!-- Success Message -->
        <div id="booking-success-state" class="hidden text-center py-20 space-y-5">
          <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto animate-scale-in">
            <i data-lucide="check-circle" class="text-emerald-500 w-12 h-12"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900">تم الحجز بنجاح! 🎉</h3>
          <p class="text-gray-500 max-w-sm mx-auto">سيتم التواصل معك قريباً عبر الهاتف أو رسالة نصية لتأكيد موعدك.</p>
          <button onclick="resetBookingForm()" class="bg-primary-50 text-primary-700 px-6 py-2 rounded-xl text-sm font-bold hover:bg-primary-100 transition-all cursor-pointer">
            حجز موعد آخر
          </button>
        </div>

        <!-- Form fields wrapper -->
        <div id="booking-form-wrapper">
          <form id="appointment-booking-form" action="{{ route('appointments.store') }}" method="POST" class="space-y-5 relative text-right" onsubmit="submitBookingForm(event)">
            @csrf
            <h3 class="text-2xl font-bold text-gray-900 mb-8">نموذج حجز موعد</h3>

            <!-- Patient details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="relative">
                <i data-lucide="user" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
                <input
                  type="text"
                  name="patient_name"
                  placeholder="الاسم الكامل للمريض"
                  required
                  class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm text-right"
                />
              </div>
              <div class="relative">
                <i data-lucide="phone" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
                <input
                  type="tel"
                  name="phone"
                  placeholder="رقم الجوال"
                  required
                  class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm text-right"
                />
              </div>
            </div>

            <!-- Specialty & Doctor select -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="relative">
                <i data-lucide="stethoscope" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
                <select
                  name="department"
                  id="appointment-department-select"
                  required
                  onchange="updateDoctorsDropdown(); updateTimeSlots();"
                  class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600 text-right"
                >
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
                  id="appointment-doctor-select"
                  disabled
                  onchange="updateTimeSlots();"
                  class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600 text-right disabled:opacity-50 disabled:cursor-not-allowed"
                >
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
                  id="appointment-date-input"
                  min="{{ $todayDate }}"
                  required
                  onchange="updateTimeSlots();"
                  class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm text-right"
                />
              </div>
              <div class="relative">
                <i data-lucide="clock" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-4.5 h-4.5"></i>
                <select
                  name="time"
                  id="appointment-time-select"
                  required
                  disabled
                  class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600 text-right disabled:opacity-50 disabled:cursor-not-allowed"
                >
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
                rows="3"
                class="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm resize-none text-right"
              ></textarea>
            </div>

            <button
              type="submit"
              class="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-4.5 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-3 group cursor-pointer"
            >
              <i data-lucide="send" class="w-5 h-5 group-hover:-translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
              <span>تأكيد الحجز</span>
            </button>

            <p class="text-gray-400 text-xs text-center mt-2">
              🔒 بياناتك محمية وسرية بالكامل
            </p>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  const allDoctorsList = @json($doctors);

  function updateDoctorsDropdown() {
    const deptSelect = document.getElementById('appointment-department-select');
    const docSelect = document.getElementById('appointment-doctor-select');
    const selectedDept = deptSelect.value;

    if (!selectedDept) {
      docSelect.disabled = true;
      docSelect.innerHTML = '<option value="">يرجى اختيار القسم أولاً</option>';
      return;
    }

    docSelect.disabled = false;
    docSelect.innerHTML = '<option value="">اختر الطبيب (اختياري)</option>';

    // Filter and add doctors
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

  async function submitBookingForm(event) {
    event.preventDefault();
    const form = document.getElementById('appointment-booking-form');
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
        document.getElementById('booking-form-wrapper').classList.add('hidden');
        document.getElementById('booking-success-state').classList.remove('hidden');
        form.reset();
      } else {
        if (response.status === 422 && result.errors) {
            // It's a validation error, extract the messages
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

  async function updateTimeSlots() {
    const deptSelect = document.getElementById('appointment-department-select');
    const docSelect = document.getElementById('appointment-doctor-select');
    const dateInput = document.getElementById('appointment-date-input');
    const timeSelect = document.getElementById('appointment-time-select');

    const selectedDept = deptSelect.value;
    const selectedDoc = docSelect.value;
    const selectedDate = dateInput.value;

    // كل من القسم والتاريخ مطلوبان للحصول على المواعيد المتاحة
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

  function resetBookingForm() {
    document.getElementById('booking-form-wrapper').classList.remove('hidden');
    document.getElementById('booking-success-state').classList.add('hidden');
    updateDoctorsDropdown();
    
    const timeSelect = document.getElementById('appointment-time-select');
    timeSelect.disabled = true;
    timeSelect.innerHTML = '<option value="">يرجى اختيار القسم والتاريخ أولاً</option>';
  }
</script>
