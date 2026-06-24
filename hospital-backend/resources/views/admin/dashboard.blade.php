@extends('layouts.admin')

@section('title', 'لوحة التحكم - الرئيسية')

@section('content')
  <!-- Dashboard Stats Header -->
  <div class="mb-8 text-right">
    <h1 class="text-2xl font-black text-gray-900">مرحباً بك في لوحة التحكم 👋</h1>
    <p class="text-gray-500 text-sm mt-1">نظرة عامة على حالة تشغيل المستشفى والمؤشرات الحالية</p>
  </div>

  <!-- Metric Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    <!-- Pending Reservations Card -->
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between group hover:shadow-lg transition-all duration-300">
      <div class="text-right">
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">الحجوزات قيد الانتظار</p>
        <h3 class="text-3xl font-black text-gray-800 mt-2 tabular-nums">{{ $stats['pending_appointments'] }}</h3>
      </div>
      <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
        <i data-lucide="clock" class="w-7 h-7"></i>
      </div>
    </div>

    <!-- Today's Bookings Card -->
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between group hover:shadow-lg transition-all duration-300">
      <div class="text-right">
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">حجوزات اليوم</p>
        <h3 class="text-3xl font-black text-gray-800 mt-2 tabular-nums">{{ $stats['today_appointments'] }}</h3>
      </div>
      <div class="w-14 h-14 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
        <i data-lucide="calendar" class="w-7 h-7"></i>
      </div>
    </div>

    <!-- Total Specialists Card -->
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between group hover:shadow-lg transition-all duration-300">
      <div class="text-right">
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">الأطباء النشطون</p>
        <h3 class="text-3xl font-black text-gray-800 mt-2 tabular-nums">{{ $stats['total_doctors'] }}</h3>
      </div>
      <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
        <i data-lucide="users" class="w-7 h-7"></i>
      </div>
    </div>

    <!-- Unread Messages Card -->
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between group hover:shadow-lg transition-all duration-300">
      <div class="text-right">
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">الرسائل الجديدة</p>
        <h3 class="text-3xl font-black text-gray-800 mt-2 tabular-nums">{{ $stats['unread_messages'] }}</h3>
      </div>
      <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
        <i data-lucide="mail" class="w-7 h-7"></i>
      </div>
    </div>

  </div>

  <!-- Operational metrics details -->
  <div class="grid lg:grid-cols-3 gap-8">
    
    <!-- Recent Reservations list -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-gray-800 text-lg text-right">أحدث الحجوزات المستلمة</h3>
        <span class="text-xs text-gray-400 font-medium">آخر 5 طلبات</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-right" dir="rtl">
          <thead>
            <tr class="border-b border-gray-100 text-gray-400 text-xs font-bold uppercase">
              <th class="pb-3 text-right">المريض</th>
              <th class="pb-3 text-right">القسم</th>
              <th class="pb-3 text-right">الموعد والتاريخ</th>
              <th class="pb-3 text-right">الحالة</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
            @forelse($stats['recent_appointments'] as $app)
              <tr>
                <td class="py-4">
                  <div class="font-bold text-gray-900">{{ $app->patient_name }}</div>
                  <div class="text-xs text-gray-400 mt-0.5" dir="ltr">{{ $app->phone }}</div>
                </td>
                <td class="py-4">{{ $app->department }}</td>
                <td class="py-4">
                  <div class="font-medium text-gray-800">{{ $app->date }}</div>
                  <div class="text-xs text-gray-400 mt-0.5">{{ $app->time }}</div>
                </td>
                <td class="py-4">
                  <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $app->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($app->status === 'confirmed' ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500') }}">
                    @if($app->status === 'pending')
                      قيد الانتظار
                    @elseif($app->status === 'confirmed')
                      مؤكد
                    @else
                      مكتمل
                    @endif
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-8 text-gray-400">
                  <i data-lucide="calendar" class="mx-auto mb-2 opacity-30 w-12 h-12"></i>
                  <p>لا توجد حجوزات مستلمة مؤخراً</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quick info card sidebar -->
    <div class="lg:col-span-1 space-y-6">
      <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-6 text-white shadow-xl">
        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
          <i data-lucide="info" class="w-5 h-5"></i>
          <span>حالة التشغيل الطبية</span>
        </h3>
        <p class="text-white/70 text-sm leading-relaxed mb-6">
          جميع البيانات الموضحة حية وتتحدث فورياً عند قيام المرضى بالحجز أو إرسال الرسائل عبر الواجهة العامة.
        </p>

        <div class="space-y-4">
          <div class="flex justify-between items-center bg-white/10 p-3.5 rounded-xl text-sm">
            <span>التخصصات الطبية النشطة</span>
            <span class="font-bold">{{ $stats['total_departments'] }} أقسام</span>
          </div>
          <div class="flex justify-between items-center bg-white/10 p-3.5 rounded-xl text-sm">
            <span>إجمالي مستخدمي النظام</span>
            <span class="font-bold">{{ $stats['total_users'] }} مستخدمين</span>
          </div>
          <div class="flex justify-between items-center bg-white/10 p-3.5 rounded-xl text-sm">
            <span>مجموع الحجوزات المسجلة</span>
            <span class="font-bold">{{ $stats['total_appointments'] }} حجز</span>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
