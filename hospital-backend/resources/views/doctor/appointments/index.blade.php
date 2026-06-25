@extends('layouts.admin')

@section('title', 'مواعيدي - لوحة الطبيب')

@section('content')
  @php
    $statusLabels = [
      'pending' => 'قيد الانتظار',
      'confirmed' => 'مؤكد',
      'completed' => 'مكتمل',
      'cancelled' => 'ملغي',
    ];

    $statusColors = [
      'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
      'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
      'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
      'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="stethoscope" class="w-7 h-7 text-primary-600"></i>
        <span>مواعيد المرضى ({{ auth()->user()->name }})</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">عرض وإدارة الحجوزات الخاصة بك</p>
    </div>
  </div>

  <!-- Tabs Navigation -->
  <div class="flex gap-2 mb-6 border-b border-gray-100 pb-2 overflow-x-auto">
    <a href="{{ route('doctor.appointments.index', ['tab' => 'today']) }}" 
       class="px-4 py-2 text-sm font-bold rounded-xl transition-all whitespace-nowrap {{ $tab === 'today' ? 'bg-primary-50 text-primary-700' : 'text-gray-500 hover:bg-gray-50' }}">
      مواعيد اليوم 
      @if($todayRemaining > 0)
        <span class="mr-2 px-2 py-0.5 text-xs bg-primary-100 text-primary-700 rounded-full">{{ $todayRemaining }}</span>
      @endif
    </a>
    <a href="{{ route('doctor.appointments.index', ['tab' => 'upcoming']) }}" 
       class="px-4 py-2 text-sm font-bold rounded-xl transition-all whitespace-nowrap {{ $tab === 'upcoming' ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50' }}">
      المواعيد القادمة
    </a>
    <a href="{{ route('doctor.appointments.index', ['tab' => 'past']) }}" 
       class="px-4 py-2 text-sm font-bold rounded-xl transition-all whitespace-nowrap {{ $tab === 'past' ? 'bg-gray-100 text-gray-800' : 'text-gray-500 hover:bg-gray-50' }}">
      المواعيد السابقة
    </a>
  </div>

  <!-- Appointments Table -->
  <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse">
        <thead>
          <tr class="bg-gray-50 text-gray-400 text-xs font-bold border-b border-gray-100">
            <th class="p-4">المريض</th>
            <th class="p-4">رقم الهاتف</th>
            <th class="p-4">التاريخ والوقت</th>
            <th class="p-4 text-center">النوع</th>
            <th class="p-4 text-center">الحالة</th>
            <th class="p-4 text-center">ملاحظات</th>
            <th class="p-4 text-center">الإجراء</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
          @forelse($appointments as $appt)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="p-4 font-bold text-gray-800">{{ $appt->patient_name }}</td>
              <td class="p-4 text-gray-600 font-mono" dir="ltr">{{ $appt->phone }}</td>
              <td class="p-4 text-gray-700">
                <span class="font-bold">{{ $appt->date->format('Y-m-d') }}</span>
                <span class="text-xs text-gray-400 font-mono block mt-0.5">{{ $appt->time }}</span>
              </td>
              <td class="p-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                  {{ $appt->type }}
                </span>
              </td>
              <td class="p-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusColors[$appt->status] ?? '' }}">
                  {{ $statusLabels[$appt->status] ?? $appt->status }}
                </span>
              </td>
              <td class="p-4 text-center text-gray-500 text-xs">
                {{ Str::limit($appt->notes, 30, '...') }}
              </td>
              <td class="p-4">
                <div class="flex items-center justify-center gap-2">
                  @if($appt->status === 'confirmed')
                    <form action="{{ route('doctor.appointments.updateStatus', $appt->id) }}" method="POST" class="inline-block">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="completed">
                      <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors cursor-pointer" title="إتمام الموعد (تمت الزيارة)">
                        <i data-lucide="check-square" class="w-4 h-4"></i>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="p-16 text-center text-gray-400">
                <i data-lucide="calendar" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
                <p>لا توجد مواعيد في هذا القسم</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
