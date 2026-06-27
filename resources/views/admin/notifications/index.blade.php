@extends('layouts.admin')

@section('title', 'سجل الإشعارات - لوحة التحكم')

@section('content')
  @php
    $statusLabels = [
      'pending' => 'قيد الانتظار',
      'sent' => 'تم الإرسال',
      'delivered' => 'تم التسليم',
      'failed' => 'فشل الإرسال',
    ];

    $statusColors = [
      'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
      'sent' => 'bg-blue-50 text-blue-700 border-blue-200',
      'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
      'failed' => 'bg-rose-50 text-rose-700 border-rose-200',
    ];

    $typeLabels = [
      'sms' => 'رسالة نصية SMS',
      'whatsapp' => 'واتساب WhatsApp',
      'email' => 'بريد إلكتروني Email',
      'internal' => 'تنبيه داخلي',
    ];

    $typeColors = [
      'sms' => 'bg-purple-50 text-purple-700 border-purple-200',
      'whatsapp' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
      'email' => 'bg-blue-50 text-blue-700 border-blue-200',
      'internal' => 'bg-gray-50 text-gray-700 border-gray-200',
    ];

    $typeIcons = [
      'sms' => 'smartphone',
      'whatsapp' => 'message-square',
      'email' => 'mail',
      'internal' => 'bell',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="bell" class="w-7 h-7 text-primary-600"></i>
        <span>سجل الإشعارات التلقائية</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">مراقبة الرسائل النصية والواتساب الصادرة تلقائياً للمرضى عند الحجوزات</p>
    </div>

    @if($notifications->count() > 0)
      <form action="{{ route('admin.notifications.clearAll') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف جميع السجلات؟ لا يمكن التراجع عن هذا الإجراء.');" class="self-start md:self-auto">
        @csrf
        <button
          type="submit"
          class="bg-red-50 text-red-600 border border-red-200 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-red-100 transition-all flex items-center gap-2 cursor-pointer"
        >
          <i data-lucide="trash-2" class="w-4.5 h-4.5"></i>
          <span>تفريغ السجل بالكامل</span>
        </button>
      </form>
    @endif
  </div>

  <!-- Counter Widgets -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right relative overflow-hidden">
      <div class="w-10 h-10 bg-primary-50 text-primary-600 rounded-lg flex items-center justify-center mb-2">
        <i data-lucide="message-square" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        {{ \App\Models\Notification::count() }}
      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">إجمالي الرسائل</div>
    </div>
    
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right relative overflow-hidden">
      <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center mb-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        {{ \App\Models\Notification::whereIn('status', ['sent', 'delivered'])->count() }}
      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">تم تسليمها / إرسالها</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right relative overflow-hidden">
      <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-2">
        <i data-lucide="smartphone" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        {{ \App\Models\Notification::where('type', 'sms')->count() }}
      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">إشعارات SMS</div>
    </div>

    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right relative overflow-hidden">
      <div class="w-10 h-10 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center mb-2">
        <i data-lucide="message-circle" class="w-5 h-5"></i>
      </div>
      <div class="text-2xl font-black text-gray-800 tabular-nums">
        {{ \App\Models\Notification::where('type', 'whatsapp')->count() }}
      </div>
      <div class="text-xs text-gray-400 mt-1 font-medium">إشعارات واتساب</div>
    </div>
  </div>

  <!-- Search & Filter Bar -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <form action="{{ route('admin.notifications.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
      <!-- Search Input -->
      <div class="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
        <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="بحث برقم الهاتف، اسم المريض، أو محتوى الرسالة..."
          class="bg-transparent outline-none flex-1 text-sm text-right"
        />
      </div>

      <!-- Filter Type -->
      <div class="w-full md:w-48">
        <select name="type" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none text-right">
          <option value="">كل القنوات</option>
          <option value="sms" {{ request('type') == 'sms' ? 'selected' : '' }}>رسائل SMS</option>
          <option value="whatsapp" {{ request('type') == 'whatsapp' ? 'selected' : '' }}>واتساب</option>
        </select>
      </div>

      <!-- Filter Status -->
      <div class="w-full md:w-48">
        <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none text-right">
          <option value="">كل الحالات</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
          <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>تم الإرسال</option>
          <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
          <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>فشلت</option>
        </select>
      </div>

      @if(request()->anyFilled(['search', 'type', 'status']))
        <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-bold transition-all text-center flex items-center justify-center">
          إعادة تعيين
        </a>
      @endif
    </form>
  </div>

  <!-- Notification Logs Table -->
  <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse">
        <thead>
          <tr class="bg-gray-50 text-gray-400 text-xs font-bold border-b border-gray-100">
            <th class="p-4">المريض</th>
            <th class="p-4">المستلم / رقم الجوال</th>
            <th class="p-4">قناة الإرسال</th>
            <th class="p-4">نص الإشعار المرسل</th>
            <th class="p-4">التاريخ والوقت</th>
            <th class="p-4 text-center">الحالة</th>
            <th class="p-4 text-center">خيارات</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
          @forelse($notifications as $notify)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="p-4 font-bold text-gray-800">
                {{ $notify->patient_name ?? 'غير محدد' }}
                @if($notify->reservation_id)
                  <span class="block text-[10px] text-gray-400 font-mono mt-0.5">موعد #{{ $notify->reservation_id }}</span>
                @endif
              </td>
              <td class="p-4 text-gray-600 font-mono" dir="ltr">{{ $notify->recipient }}</td>
              <td class="p-4">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $typeColors[$notify->type] ?? '' }}">
                  <i data-lucide="{{ $typeIcons[$notify->type] ?? 'message-square' }}" class="w-3.5 h-3.5"></i>
                  <span>{{ $typeLabels[$notify->type] ?? $notify->type }}</span>
                </span>
              </td>
              <td class="p-4 text-gray-600 max-w-xs md:max-w-md truncate" title="{{ $notify->message }}">
                {{ $notify->message }}
              </td>
              <td class="p-4 text-gray-700">
                <span class="font-bold">{{ $notify->created_at->format('Y-m-d') }}</span>
                <span class="text-xs text-gray-400 font-mono block mt-0.5">{{ $notify->created_at->format('h:i A') }}</span>
              </td>
              <td class="p-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusColors[$notify->status] ?? '' }}">
                  {{ $statusLabels[$notify->status] ?? $notify->status }}
                </span>
              </td>
              <td class="p-4">
                <div class="flex items-center justify-center gap-2">
                  <!-- Resend Simulation Button -->
                  <button
                    onclick="resendSimulation('{{ $notify->recipient }}', '{{ $notify->type }}')"
                    class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer"
                    title="محاكاة إعادة الإرسال"
                  >
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                  </button>

                  <!-- Delete Single Log -->
                  <form action="{{ route('admin.notifications.destroy', $notify->id) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا السجل نهائياً؟');" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors cursor-pointer" title="حذف">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="p-16 text-center text-gray-400">
                <i data-lucide="bell-off" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
                <p>لا توجد إشعارات مسجلة حالياً في السجل</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
      <div class="p-4 border-t border-gray-100 text-right">
        {{ $notifications->links() }}
      </div>
    @endif
  </div>

  <script>
    function resendSimulation(recipient, type) {
      alert(`🔄 محاكاة إعادة الإرسال:\nتمت إعادة إرسال الإشعار بنجاح إلى المستلم (${recipient}) عبر قناة (${type === 'sms' ? 'SMS' : 'WhatsApp'}).`);
    }
  </script>
@endsection
