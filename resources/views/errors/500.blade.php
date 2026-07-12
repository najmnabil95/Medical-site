@extends('layouts.app')

@section('title', 'خطأ في الخادم 500')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center py-20 relative overflow-hidden">
  {{-- Decorative Background --}}
  <div class="absolute inset-0 bg-linear-to-br from-slate-50 via-white to-gray-50"></div>
  <div class="absolute top-20 left-1/4 w-80 h-80 bg-slate-100/50 rounded-full blur-3xl animate-pulse"></div>
  <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-gray-100/40 rounded-full blur-3xl"></div>

  <div class="relative text-center px-6 max-w-xl mx-auto">
    {{-- Animated Gear Icon --}}
    <div class="relative inline-block mb-8">
      <div class="w-32 h-32 bg-linear-to-br from-slate-600 to-slate-800 rounded-3xl flex items-center justify-center shadow-2xl shadow-slate-600/30 mx-auto">
        <i data-lucide="server-crash" class="w-16 h-16 text-white"></i>
      </div>
      {{-- Pulse ring --}}
      <div class="absolute inset-0 rounded-3xl border-2 border-slate-300 animate-ping opacity-20"></div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-linear-to-l from-slate-600 to-slate-800 leading-none mb-4">
      500
    </h1>

    {{-- Title --}}
    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-4">
      خطأ في الخادم
    </h2>

    {{-- Description --}}
    <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-md mx-auto">
      نعتذر عن هذا الخطأ غير المتوقع. فريقنا التقني يعمل على حل المشكلة.
      <br>
      يرجى المحاولة مرة أخرى لاحقاً.
    </p>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
      <a href="/"
        class="inline-flex items-center gap-2.5 px-7 py-3.5 bg-linear-to-l from-slate-700 to-slate-900 text-white rounded-2xl font-bold text-sm hover:shadow-xl hover:shadow-slate-700/30 transition-all hover:-translate-y-1 group">
        <i data-lucide="home" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
        <span>العودة للصفحة الرئيسية</span>
      </a>
      <button onclick="location.reload()"
        class="inline-flex items-center gap-2 px-7 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold text-sm hover:bg-gray-50 hover:border-gray-300 hover:shadow-md transition-all group cursor-pointer">
        <i data-lucide="refresh-cw" class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500"></i>
        <span>إعادة المحاولة</span>
      </button>
    </div>

    {{-- Support Contact --}}
    <div class="mt-10 p-5 bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-100 shadow-sm">
      <p class="text-sm font-bold text-gray-600 mb-2">هل تحتاج مساعدة؟</p>
      <p class="text-xs text-gray-400">
        تواصل مع الدعم الفني على
        <a href="mailto:support@alshifa-hospital.com" class="text-primary-600 font-bold hover:underline">support@alshifa-hospital.com</a>
      </p>
    </div>
  </div>
</section>
@endsection
