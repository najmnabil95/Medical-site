<!-- Cookie Banner Container -->
<div id="cookie-banner" class="hidden fixed bottom-0 right-0 left-0 z-[80] p-4 animate-slide-up">
  <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl border border-gray-100 p-5 flex flex-col md:flex-row items-start md:items-center gap-4">
    <div class="flex items-start gap-3 flex-1">
      <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
        <i data-lucide="cookie" class="text-amber-600 w-5 h-5"></i>
      </div>
      <div>
        <h4 class="font-bold text-gray-800 text-sm mb-1">نحن نحترم خصوصيتك</h4>
        <p class="text-gray-500 text-xs leading-relaxed">
          نستخدم ملفات تعريف الارتباط لتحسين تجربتك على موقعنا. من خلال الاستمرار في التصفح، فإنك توافق على استخدامنا لها.
          <button onclick="togglePrivacyModal(true)" class="text-primary-600 font-bold mx-1 hover:underline cursor-pointer">سياسة الخصوصية</button>
        </p>
      </div>
    </div>
    <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
      <button onclick="declineCookies()" class="flex-1 md:flex-none px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
        رفض
      </button>
      <button onclick="acceptCookies()" class="flex-1 md:flex-none px-5 py-2 bg-gradient-to-l from-primary-500 to-primary-700 text-white text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center justify-center gap-2">
        <i data-lucide="check" class="w-4 h-4"></i>
        <span>موافق</span>
      </button>
    </div>
  </div>
</div>

<!-- Privacy/Legal Modal (Hidden by Default) -->
<div id="legal-privacy-modal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-4">
  <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="togglePrivacyModal(false)"></div>
  <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden animate-scale-in">
    <!-- Header -->
    <div class="sticky top-0 bg-gradient-to-l from-primary-600 to-primary-800 text-white px-6 py-5 z-10">
      <button
        onclick="togglePrivacyModal(false)"
        class="absolute top-4 left-4 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
      >
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
          <i data-lucide="shield" class="w-6 h-6"></i>
        </div>
        <div>
          <h3 class="text-2xl font-bold">سياسة الخصوصية</h3>
          <p class="text-sm text-white/70">آخر تحديث: يناير 2024</p>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="p-8 overflow-y-auto max-h-[70vh]">
      <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
        <i data-lucide="info" class="text-blue-600 shrink-0 mt-0.5 w-[18px] h-[18px]"></i>
        <p class="text-sm text-blue-700 leading-relaxed">
          نرجو قراءة هذه الوثيقة بعناية. باستخدامك لخدماتنا، فإنك توافق على جميع الشروط والأحكام المذكورة أدناه.
        </p>
      </div>

      <div class="space-y-6 text-gray-700">
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">1. مقدمة</h4>
          <p class="leading-relaxed">نحترم خصوصيتك ونلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية المعلومات التي تقدمها لنا عند استخدام موقعنا الإلكتروني.</p>
        </div>
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">2. المعلومات التي نجمعها</h4>
          <p class="leading-relaxed">نقوم بجمع المعلومات التالية: الاسم الكامل، رقم الهاتف، البريد الإلكتروني، التاريخ الطبي (عند الضرورة)، ومعلومات الحجز والمواعيد.</p>
        </div>
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">3. كيفية استخدام المعلومات</h4>
          <p class="leading-relaxed">نستخدم معلوماتك لتقديم خدمات الرعاية الصحية، حجز المواعيد، التواصل معك، وتحسين خدماتنا. لا نشارك معلوماتك مع أطراف ثالثة دون موافقتك.</p>
        </div>
        <div class="border-r-4 border-primary-500 pr-4">
          <h4 class="font-bold text-gray-800 mb-2">4. حماية البيانات</h4>
          <p class="leading-relaxed">نتخذ إجراءات أمنية صارمة لحماية بياناتك من الوصول غير المصرح به أو التعديل أو الإفصاح أو الإتلاف. جميع البيانات مشفرة ومخزنة بشكل آمن.</p>
        </div>
      </div>

      <div class="mt-8 pt-6 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-500">
          © 2024 مستشفى الشفاء الدولي - جميع الحقوق محفوظة
        </p>
        <button
          onclick="togglePrivacyModal(false)"
          class="mt-4 bg-gradient-to-l from-primary-500 to-primary-700 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition-all"
        >
          فهمت، إغلاق
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const consent = localStorage.getItem("cookieConsent");
    if (!consent) {
      setTimeout(() => {
        const banner = document.getElementById("cookie-banner");
        if (banner) banner.classList.remove("hidden");
      }, 1500);
    }
  });

  function acceptCookies() {
    localStorage.setItem("cookieConsent", "accepted");
    const banner = document.getElementById("cookie-banner");
    if (banner) banner.classList.add("hidden");
  }

  function declineCookies() {
    localStorage.setItem("cookieConsent", "declined");
    const banner = document.getElementById("cookie-banner");
    if (banner) banner.classList.add("hidden");
  }

  function togglePrivacyModal(show) {
    const modal = document.getElementById("legal-privacy-modal");
    if (modal) {
      if (show) {
        modal.classList.remove("hidden");
      } else {
        modal.classList.add("hidden");
      }
    }
  }
</script>
<?php /**PATH D:\laravel-hospital-website-development\resources\views/components/home/CookieBanner.blade.php ENDPATH**/ ?>