@extends('layouts.admin')

@section('title', 'رسائل التواصل - لوحة التحكم')

@section('content')
  @php
    $statusLabels = [
      'unread' => 'غير مقروءة',
      'read' => 'مقروءة',
      'replied' => 'تم الرد عليها',
    ];

    $statusColors = [
      'unread' => 'bg-amber-50 text-amber-700 border-amber-200',
      'read' => 'bg-blue-50 text-blue-700 border-blue-200',
      'replied' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    ];

    $statusGradients = [
      'unread' => 'from-amber-500 to-orange-600',
      'read' => 'from-blue-500 to-indigo-600',
      'replied' => 'from-emerald-500 to-teal-600',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="mail" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة رسائل التواصل واستفسارات المرضى</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">قراءة والرد على الرسائل الواردة من نموذج اتصل بنا بالموقع</p>
    </div>
  </div>

  <!-- Stats Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @foreach($statusLabels as $status => $label)
      <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
        <div class="w-10 h-10 bg-gradient-to-br {{ $statusGradients[$status] }} rounded-lg flex items-center justify-center text-white mb-2">
          <i data-lucide="mail-open" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-black text-gray-800 tabular-nums">
          {{ $messages->where('status', $status)->count() }}
        </div>
        <div class="text-xs text-gray-400 mt-1 font-medium">{{ $label }}</div>
      </div>
    @endforeach
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم المرسل، البريد، أو الموضوع..."
        onkeyup="filterMessages()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Messages Table -->
  <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse" id="messages-table">
        <thead>
          <tr class="bg-gray-50 text-gray-400 text-xs font-bold border-b border-gray-100">
            <th class="p-4">المرسل</th>
            <th class="p-4">البريد الإلكتروني</th>
            <th class="p-4">الموضوع</th>
            <th class="p-4">مقتطف من الرسالة</th>
            <th class="p-4 text-center">الحالة</th>
            <th class="p-4 text-center">تاريخ الإرسال</th>
            <th class="p-4 text-center">الخيارات</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
          @forelse($messages as $msg)
            <tr
              class="message-row hover:bg-gray-50 transition-colors {{ $msg->status === 'unread' ? 'font-bold bg-amber-50/20' : '' }}"
              data-name="{{ $msg->name }}"
              data-email="{{ $msg->email }}"
              data-subject="{{ $msg->subject }}"
              data-body="{{ $msg->message }}"
            >
              <td class="p-4 text-gray-800">{{ $msg->name }}</td>
              <td class="p-4 text-gray-600 font-mono" dir="ltr">{{ $msg->email }}</td>
              <td class="p-4 text-gray-700">{{ $msg->subject }}</td>
              <td class="p-4 text-gray-400 max-w-xs truncate">{{ $msg->message }}</td>
              <td class="p-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusColors[$msg->status] ?? '' }}">
                  {{ $statusLabels[$msg->status] ?? $msg->status }}
                </span>
              </td>
              <td class="p-4 text-center text-gray-500 text-xs font-mono">
                {{ $msg->created_at ? $msg->created_at->format('Y-m-d H:i') : 'لا يوجد' }}
              </td>
              <td class="p-4">
                <div class="flex items-center justify-center gap-2">
                  <button
                    onclick="openResponseModal({{ $msg->id }}, '{{ addslashes($msg->name) }}', '{{ $msg->email }}', '{{ addslashes($msg->subject) }}', '{{ addslashes($msg->message) }}', '{{ $msg->status }}', '{{ addslashes($msg->reply) }}')"
                    class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer"
                    title="عرض / رد"
                  >
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                  </button>
                  <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذه الرسالة؟');">
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
                <i data-lucide="mail" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
                <p>لا توجد رسائل واردة حالياً</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Message Response Modal -->
  <div id="response-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeResponseModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeResponseModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">قراءة واستجابة الرسالة</h3>
      </div>
      
      <form id="response-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="name" id="msg-name-input" />
        <input type="hidden" name="email" id="msg-email-input" />
        <input type="hidden" name="subject" id="msg-subject-input" />
        <input type="hidden" name="message" id="msg-body-input" />

        <div class="space-y-3 bg-gray-50 rounded-2xl p-4 border border-gray-100 text-sm">
          <div>
            <span class="text-gray-400 text-xs">المرسل:</span>
            <span class="font-bold text-gray-800 block" id="view-name"></span>
          </div>
          <div>
            <span class="text-gray-400 text-xs">البريد الإلكتروني:</span>
            <span class="font-mono text-gray-800 block" dir="ltr" id="view-email"></span>
          </div>
          <div>
            <span class="text-gray-400 text-xs">الموضوع:</span>
            <span class="font-bold text-gray-800 block" id="view-subject"></span>
          </div>
          <div class="pt-2 border-t border-gray-200">
            <span class="text-gray-400 text-xs">نص الرسالة:</span>
            <p class="text-gray-700 mt-1 whitespace-pre-line leading-relaxed" id="view-message"></p>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">تحديث الحالة</label>
          <select name="status" id="edit-status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
            @foreach($statusLabels as $status => $label)
              <option value="{{ $status }}">{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">نص الرد الإداري</label>
          <textarea name="reply" id="edit-reply" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-28" placeholder="اكتب الرد الرسمي الذي سيتم إرساله أو حفظه كمرجع..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeResponseModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ وحفظ الرد</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterMessages() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const rows = document.querySelectorAll('.message-row');
      
      rows.forEach(row => {
        const name = row.getAttribute('data-name').toLowerCase();
        const email = row.getAttribute('data-email').toLowerCase();
        const subject = row.getAttribute('data-subject').toLowerCase();
        const body = row.getAttribute('data-body').toLowerCase();
        
        if (name.includes(query) || email.includes(query) || subject.includes(query) || body.includes(query)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function openResponseModal(id, name, email, subject, message, status, reply) {
      const form = document.getElementById('response-form');
      form.action = `/admin/messages/${id}`;
      
      // Hidden inputs for validation
      document.getElementById('msg-name-input').value = name;
      document.getElementById('msg-email-input').value = email;
      document.getElementById('msg-subject-input').value = subject;
      document.getElementById('msg-body-input').value = message;

      // Layout texts
      document.getElementById('view-name').textContent = name;
      document.getElementById('view-email').textContent = email;
      document.getElementById('view-subject').textContent = subject;
      document.getElementById('view-message').textContent = message;
      
      // Status & Reply form inputs
      document.getElementById('edit-status').value = status;
      document.getElementById('edit-reply').value = reply === 'null' || reply === null ? '' : reply;

      document.getElementById('response-modal').classList.remove('hidden');
    }

    function closeResponseModal() {
      document.getElementById('response-modal').classList.add('hidden');
    }
  </script>
@endsection
