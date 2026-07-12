@php
  $contactInfo = [
    [
      'icon' => 'map-pin',
      'title' => 'العنوان',
      'details' => [$settings->address ?? 'طريق الملك فهد، الرياض'],
      'color' => 'from-blue-500 to-indigo-600',
    ],
    [
      'icon' => 'phone',
      'title' => 'الهاتف',
      'details' => [$settings->phone ?? '920012345'],
      'color' => 'from-emerald-500 to-teal-600',
    ],
    [
      'icon' => 'mail',
      'title' => 'البريد الإلكتروني',
      'details' => [$settings->email ?? 'info@alshifa-hospital.com'],
      'color' => 'from-purple-500 to-violet-600',
    ],
    [
      'icon' => 'clock',
      'title' => 'ساعات العمل',
      'details' => ["السبت - الخميس: 8 ص - 10 م", "الطوارئ: 24 ساعة / 7 أيام"],
      'color' => 'from-orange-500 to-amber-600',
    ],
  ];
@endphp

<section id="contact" class="py-24 bg-gray-50 relative overflow-hidden scroll-mt-32">
  <div class="absolute top-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 relative">
    
    <!-- Section Header -->
    <div class="text-center mb-16 animate-fade-in-up">
      <span class="font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block text-emerald-600 bg-emerald-500/10">
        تواصل معنا
      </span>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight text-gray-900">
        نحن هنا
        <span class="text-primary-600"> لمساعدتك</span>
      </h2>
      <p class="mt-5 max-w-2xl mx-auto text-lg leading-relaxed text-gray-500">
        لا تتردد في تواصل معنا لأي استفسار أو للحصول على المساعدة الطبية اللازمة
      </p>
      <div class="flex items-center justify-center gap-2 mt-6">
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>

    <!-- Contact Info Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16 animate-fade-in-up">
      @foreach($contactInfo as $index => $info)
        <div
          class="contact-info-card bg-white rounded-2xl p-7 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-500 hover:-translate-y-3 group text-center"
          data-delay="{{ $index * 100 }}"
        >
          <div class="w-16 h-16 bg-linear-to-br {{ $info['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
            <i data-lucide="{{ $info['icon'] }}" class="text-white w-[26px] h-[26px]"></i>
          </div>
          <h4 class="text-lg font-bold text-gray-900 mb-3">{{ $info['title'] }}</h4>
          @foreach($info['details'] as $detail)
            <p class="text-gray-500 text-sm leading-relaxed">{{ $detail }}</p>
          @endforeach
        </div>
      @endforeach
    </div>

    <!-- Map & Form Grid -->
    <div class="grid lg:grid-cols-2 gap-8">
      
      <!-- Map Container -->
      <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 h-[550px] relative">
        <iframe
          src="{{ !empty($settings->map_link) ? $settings->map_link : 'https://maps.google.com/maps?q=' . urlencode(($settings->address ?? 'طريق الملك فهد') . ', ' . ($settings->city ?? 'الرياض')) . '&t=&z=15&ie=UTF8&iwloc=&output=embed' }}"
          width="100%"
          height="100%"
          style="border: 0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="موقع المستشفى"
        ></iframe>
        <div class="absolute bottom-6 right-6 bg-white rounded-2xl p-4 shadow-xl flex items-center gap-3">
          <div class="w-10 h-10 bg-linear-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
            <i data-lucide="map-pin" class="text-white w-5 h-5"></i>
          </div>
          <div>
            <p class="font-bold text-gray-900 text-sm">{{ $settings->site_name ?? 'مستشفى الشفاء' }}</p>
            <p class="text-gray-500 text-xs">{{ $settings->address ?? 'طريق الملك فهد' }}</p>
          </div>
        </div>
      </div>

      <!-- Quick Message Form -->
      <div class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100 relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-linear-to-br from-primary-50 to-emerald-50 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2 opacity-70"></div>
        
        <!-- Success State -->
        <div id="contact-success-state" class="h-full flex flex-col items-center justify-center text-center space-y-4 py-16" style="display: none;">
          <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center animate-scale-in">
            <i data-lucide="check-circle" class="text-emerald-500 w-10 h-10"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900">تم الإرسال بنجاح! 🎉</h3>
          <p class="text-gray-500">شكراً لتواصلك معنا. سنرد عليك في أقرب وقت ممكن.</p>
          <button onclick="resetContactForm()" class="bg-primary-50 text-primary-700 px-6 py-2 rounded-xl text-sm font-bold hover:bg-primary-100 transition-all cursor-pointer">
            إرسال رسالة أخرى
          </button>
        </div>

        <!-- Form Fields -->
        <div id="contact-form-container">
          <h3 class="text-2xl font-bold text-gray-900 mb-2">أرسل لنا رسالة</h3>
          <p class="text-gray-500 mb-8">وسنقوم بالرد على استفسارك في أقرب وقت.</p>

          <form id="contact-message-form" action="{{ route('messages.store') }}" method="POST" class="space-y-5" onsubmit="submitContactForm(event)">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input
                type="text"
                name="name"
                placeholder="الاسم الكامل"
                required
                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
              />
              <input
                type="email"
                name="email"
                placeholder="البريد الإلكتروني"
                required
                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
              />
            </div>
            <input
              type="text"
              name="subject"
              placeholder="الموضوع"
              required
              class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
            />
            <textarea
              name="message"
              placeholder="رسالتك"
              rows="5"
              required
              class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm resize-none"
            ></textarea>
            
            <button
              type="submit"
              class="w-full bg-linear-to-l from-primary-500 to-primary-700 text-white py-4.5 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-3 cursor-pointer"
            >
              <i data-lucide="send" class="w-5 h-5"></i>
              <span>إرسال الرسالة</span>
            </button>
          </form>

          <!-- WhatsApp Option -->
          <div class="mt-8 text-center">
            <div class="flex items-center gap-3 mb-4">
              <span class="flex-1 h-px bg-gray-200"></span>
              <span class="text-gray-400 text-sm">أو تواصل معنا عبر</span>
              <span class="flex-1 h-px bg-gray-200"></span>
            </div>
            <a
              href="https://wa.me/{{ $settings->whatsapp ?? '966123456789' }}?text=مرحباً، أريد الاستفسار عن خدمات المستشفى"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-3 bg-green-500 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-green-600 transition-all hover:shadow-lg hover:shadow-green-500/30 hover:-translate-y-0.5"
            >
              <svg class="w-5.5 h-5.5 fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.45.002 9.885-4.417 9.888-9.855.001-2.63-1.02-5.101-2.871-6.956C16.428 1.939 13.96 .92 11.96.92c-5.456 0-9.893 4.421-9.896 9.86-.001 1.516.399 3.01 1.159 4.351l-.989 3.61 3.734-.977zm11.233-6.52c-.29-.145-1.716-.848-1.982-.944-.266-.096-.46-.145-.653.145-.193.29-.748.944-.917 1.137-.17.193-.34.218-.63.073-.29-.145-1.226-.452-2.335-1.441-.863-.77-1.446-1.72-1.616-2.011-.17-.29-.018-.447.127-.591.13-.13.29-.34.435-.51.145-.17.193-.29.29-.483.097-.193.048-.362-.024-.507-.072-.145-.653-1.573-.895-2.152-.236-.569-.475-.492-.653-.501-.17-.008-.363-.01-.556-.01-.193 0-.507.073-.773.362-.266.29-1.014.992-1.014 2.42 0 1.427 1.038 2.806 1.183 3.002.145.193 2.043 3.12 4.949 4.373.691.298 1.232.476 1.653.61.694.22 1.326.19 1.825.115.556-.083 1.716-.7 1.961-1.374.246-.677.246-1.258.172-1.374-.074-.117-.268-.19-.558-.335z"/>
              </svg>
              <span>تواصل عبر واتساب</span>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  async function submitContactForm(event) {
    event.preventDefault();
    const form = document.getElementById('contact-message-form');
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
        document.getElementById('contact-form-container').style.display = 'none';
        document.getElementById('contact-success-state').style.display = 'flex';
        form.reset();
      } else {
        alert(result.message || 'حدث خطأ غير متوقع، يرجى المحاولة لاحقاً.');
      }
    } catch (error) {
      console.error(error);
      alert('فشل الاتصال بالخادم. يرجى التحقق من اتصالك بالإنترنت.');
    }
  }

  function resetContactForm() {
    document.getElementById('contact-form-container').style.display = 'block';
    document.getElementById('contact-success-state').style.display = 'none';
  }

  // Set animation delays for contact info cards
  document.querySelectorAll('.contact-info-card').forEach(function(card) {
    const delay = card.getAttribute('data-delay');
    if (delay) {
      card.style.animationDelay = delay + 'ms';
    }
  });
</script>
