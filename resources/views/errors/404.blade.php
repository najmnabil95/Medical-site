@extends('layouts.app')

@section('title', 'الصفحة غير موجودة 404')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center py-20 relative overflow-hidden">
  {{-- Decorative Background --}}
  <div class="absolute inset-0 bg-linear-to-br from-primary-50 via-white to-violet-50"></div>
  <div class="absolute top-10 left-10 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl animate-pulse"></div>
  <div class="absolute bottom-10 right-10 w-96 h-96 bg-violet-100/30 rounded-full blur-3xl"></div>

  <div class="relative text-center px-6 max-w-2xl mx-auto">
    {{-- Animated Search Icon --}}
    <div class="relative inline-block mb-8">
      <div class="w-32 h-32 bg-linear-to-br from-primary-500 to-violet-600 rounded-full flex items-center justify-center shadow-2xl shadow-primary-500/30 mx-auto group hover:scale-105 transition-transform duration-500">
        <i data-lucide="search-x" class="w-16 h-16 text-white"></i>
      </div>
      {{-- Floating dots decoration --}}
      <div class="absolute -top-3 -left-3 w-6 h-6 bg-amber-400 rounded-full shadow-lg animate-bounce" style="animation-delay: 0.2s"></div>
      <div class="absolute -bottom-2 -right-4 w-4 h-4 bg-emerald-400 rounded-full shadow-lg animate-bounce" style="animation-delay: 0.5s"></div>
      <div class="absolute top-1/2 -right-6 w-3 h-3 bg-rose-400 rounded-full shadow-lg animate-bounce" style="animation-delay: 0.8s"></div>
    </div>

    {{-- Error Code --}}
    <h1 class="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-linear-to-l from-primary-500 to-violet-600 leading-none mb-4">
      404
    </h1>

    {{-- Title --}}
    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-4">
      الصفحة غير موجودة
    </h2>

    {{-- Description --}}
    <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-md mx-auto">
      يبدو أن الصفحة التي تبحث عنها قد تم نقلها أو حذفها أو أن الرابط غير صحيح.
    </p>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
      <a href="/"
        class="inline-flex items-center gap-2.5 px-7 py-3.5 bg-linear-to-l from-primary-500 to-violet-600 text-white rounded-2xl font-bold text-sm hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 group">
        <i data-lucide="home" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
        <span>العودة للصفحة الرئيسية</span>
      </a>
      <a href="javascript:history.back()"
        class="inline-flex items-center gap-2 px-7 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold text-sm hover:bg-gray-50 hover:border-gray-300 hover:shadow-md transition-all group">
        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
        <span>الرجوع للخلف</span>
      </a>
    </div>

    {{-- Quick Links --}}
    <div class="border-t border-gray-100 pt-8">
      <p class="text-sm font-bold text-gray-400 mb-5">روابط قد تفيدك</p>
      <div class="flex flex-wrap items-center justify-center gap-3">
        <a href="/#departments" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-primary-50 text-gray-600 hover:text-primary-700 rounded-xl text-sm font-medium transition-all border border-transparent hover:border-primary-100">
          <i data-lucide="hospital" class="w-4 h-4"></i>
          الأقسام الطبية
        </a>
        <a href="/#doctors" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-primary-50 text-gray-600 hover:text-primary-700 rounded-xl text-sm font-medium transition-all border border-transparent hover:border-primary-100">
          <i data-lucide="stethoscope" class="w-4 h-4"></i>
          أطباؤنا
        </a>
        <a href="/#appointment" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-primary-50 text-gray-600 hover:text-primary-700 rounded-xl text-sm font-medium transition-all border border-transparent hover:border-primary-100">
          <i data-lucide="calendar" class="w-4 h-4"></i>
          حجز موعد
        </a>
        <a href="/#contact" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-primary-50 text-gray-600 hover:text-primary-700 rounded-xl text-sm font-medium transition-all border border-transparent hover:border-primary-100">
          <i data-lucide="phone" class="w-4 h-4"></i>
          تواصل معنا
        </a>
      </div>
    </div>
  </div>
</section>
@endsection
