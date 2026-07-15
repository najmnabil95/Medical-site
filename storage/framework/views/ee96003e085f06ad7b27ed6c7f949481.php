<div class="fixed bottom-8 right-8 z-50 flex flex-col items-end gap-3">
  <!-- Tooltip -->
  <div id="wa-tooltip" class="bg-white rounded-2xl p-4 shadow-xl border border-gray-100 max-w-[240px] relative animate-fade-in-up">
    <button
      onclick="document.getElementById('wa-tooltip').remove()"
      class="absolute -top-2 -left-2 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-200 transition-colors"
    >
      <i data-lucide="x" class="w-3 h-3"></i>
    </button>
    <div class="flex items-start gap-3">
      <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shrink-0">
        <i data-lucide="message-circle" class="text-white w-[18px] h-[18px]"></i>
      </div>
      <div>
        <p class="text-gray-800 text-sm font-bold">مرحباً! 👋</p>
        <p class="text-gray-500 text-xs mt-1 leading-relaxed">
          كيف يمكننا مساعدتك؟ تواصل معنا الآن عبر واتساب
        </p>
      </div>
    </div>
  </div>

  <!-- WhatsApp Button -->
  <a
    href="https://wa.me/<?php echo e($settings->whatsapp ?? '966123456789'); ?>?text=مرحباً، أريد الاستفسار عن خدمات المستشفى"
    target="_blank"
    rel="noopener noreferrer"
    class="relative w-[60px] h-[60px] bg-green-500 text-white rounded-2xl shadow-xl shadow-green-500/30 flex items-center justify-center hover:bg-green-600 hover:scale-110 transition-all duration-300 group"
    title="تواصل معنا عبر واتساب"
    onclick="document.getElementById('wa-tooltip').remove()"
  >
    <svg class="w-[30px] h-[30px] fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
      <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.45.002 9.885-4.417 9.888-9.855.001-2.63-1.02-5.101-2.871-6.956C16.428 1.939 13.96 .92 11.96.92c-5.456 0-9.893 4.421-9.896 9.86-.001 1.516.399 3.01 1.159 4.351l-.989 3.61 3.734-.977zm11.233-6.52c-.29-.145-1.716-.848-1.982-.944-.266-.096-.46-.145-.653.145-.193.29-.748.944-.917 1.137-.17.193-.34.218-.63.073-.29-.145-1.226-.452-2.335-1.441-.863-.77-1.446-1.72-1.616-2.011-.17-.29-.018-.447.127-.591.13-.13.29-.34.435-.51.145-.17.193-.29.29-.483.097-.193.048-.362-.024-.507-.072-.145-.653-1.573-.895-2.152-.236-.569-.475-.492-.653-.501-.17-.008-.363-.01-.556-.01-.193 0-.507.073-.773.362-.266.29-1.014.992-1.014 2.42 0 1.427 1.038 2.806 1.183 3.002.145.193 2.043 3.12 4.949 4.373.691.298 1.232.476 1.653.61.694.22 1.326.19 1.825.115.556-.083 1.716-.7 1.961-1.374.246-.677.246-1.258.172-1.374-.074-.117-.268-.19-.558-.335z"/>
    </svg>
    <!-- Pulse -->
    <span class="absolute -top-1 -right-1 w-4 h-4">
      <span class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-60"></span>
      <span class="absolute inset-0.5 bg-green-500 rounded-full"></span>
    </span>
  </a>
</div>
<?php /**PATH D:\laravel-hospital-website-development\resources\views\components\home\WhatsAppFloat.blade.php ENDPATH**/ ?>