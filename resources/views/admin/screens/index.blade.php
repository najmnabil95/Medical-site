@extends('layouts.admin')

@section('title', 'أقسام العرض (Screens) - لوحة التحكم')

@section('content')
  @php
    $iconsList = [
      'monitor' => 'شاشة عرض',
      'heart' => 'قلب / رعاية صحية',
      'activity' => 'نبض / خدمات',
      'user-cog' => 'طبيب / كادر طبي',
      'calendar' => 'تقويم / حجوزات',
      'help-circle' => 'علامة استفهام / الأسئلة',
      'shield-check' => 'درع الأمان / التأمينات',
      'message-square' => 'صندوق الحوار / الآراء',
      'handshake' => 'مصافحة / الشركاء',
      'award' => 'وسام الاعتماد',
      'dollar-sign' => 'عملة مالية / قائمة الأسعار',
      'phone' => 'هاتف / تواصل معنا',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="monitor" class="w-7 h-7 text-primary-600"></i>
        <span>أقسام عرض الصفحة الرئيسية (Screens)</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تفعيل أو إيقاف عرض وتغيير ترتيب أقسام وهياكل الصفحة الرئيسية للمستشفى</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة قسم عرض جديد</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم القسم أو المكون البرمجي..."
        onkeyup="filterScreens()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Screens Table/List -->
  <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse" id="screens-table">
        <thead>
          <tr class="bg-gray-50 text-gray-400 text-xs font-bold border-b border-gray-100">
            <th class="p-4 text-center">الترتيب</th>
            <th class="p-4">اسم القسم الإداري</th>
            <th class="p-4">اسم المكون البرمجي (Component)</th>
            <th class="p-4 text-center">الأيقونة</th>
            <th class="p-4 text-center">الحالة</th>
            <th class="p-4 text-center">الخيارات</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
          @forelse($screens as $screen)
            <tr
              class="screen-row hover:bg-gray-50 transition-colors {{ !$screen->enabled ? 'opacity-60 bg-gray-50/40' : '' }}"
              data-name="{{ $screen->name }}"
              data-component="{{ $screen->component }}"
            >
              <td class="p-4 text-center font-bold text-primary-700 font-mono tabular-nums">
                <div class="flex items-center justify-center gap-1.5">
                  <form action="{{ route('admin.screens.up', $screen->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-1 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all cursor-pointer" title="نقل للأعلى">
                      <i data-lucide="chevron-up" class="w-4 h-4"></i>
                    </button>
                  </form>
                  <span class="w-6 text-center text-sm font-bold text-gray-700">{{ $screen->order }}</span>
                  <form action="{{ route('admin.screens.down', $screen->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-1 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all cursor-pointer" title="نقل للأسفل">
                      <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
              <td class="p-4 font-bold text-gray-800">{{ $screen->name }}</td>
              <td class="p-4 text-gray-500 font-mono">{{ $screen->component }}</td>
              <td class="p-4">
                <div class="flex items-center justify-center text-gray-600">
                  <i data-lucide="{{ $screen->icon }}" class="w-5 h-5"></i>
                </div>
              </td>
              <td class="p-4 text-center">
                <!-- Active Toggle Button -->
                <form action="{{ route('admin.screens.update', $screen->id) }}" method="POST" class="inline">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="name" value="{{ $screen->name }}" />
                  <input type="hidden" name="component" value="{{ $screen->component }}" />
                  <input type="hidden" name="order" value="{{ $screen->order }}" />
                  <input type="hidden" name="icon" value="{{ $screen->icon }}" />
                  @if($screen->enabled)
                    <button type="submit" class="text-emerald-500 hover:scale-115 transition-transform cursor-pointer">
                      <i data-lucide="toggle-right" class="w-8 h-8"></i>
                    </button>
                  @else
                    <button type="submit" name="enabled" value="1" class="text-gray-300 hover:scale-115 transition-transform cursor-pointer">
                      <i data-lucide="toggle-left" class="w-8 h-8"></i>
                    </button>
                  @endif
                </form>
              </td>
              <td class="p-4">
                <div class="flex items-center justify-center gap-2">
                  <button
                    onclick="openEditModal({{ $screen->id }}, '{{ addslashes($screen->name) }}', '{{ addslashes($screen->component) }}', '{{ $screen->order }}', '{{ $screen->icon }}', {{ $screen->enabled ? 'true' : 'false' }})"
                    class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer"
                    title="تعديل"
                  >
                    <i data-lucide="edit" class="w-4 h-4"></i>
                  </button>
                  
                  <form action="{{ route('admin.screens.destroy', $screen->id) }}" method="POST" onsubmit="return confirm('حذف هذا القسم قد يخفي بياناته تماماً من واجهة المستخدم. هل تريد الحذف بالفعل؟');">
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
              <td colspan="6" class="p-16 text-center text-gray-400">
                <i data-lucide="monitor" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
                <p>لا توجد أقسام عرض مسجلة</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Create Modal -->
  <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">إضافة قسم عرض جديد</h3>
      </div>
      
      <form action="{{ route('admin.screens.store') }}" method="POST" class="p-6 space-y-4 text-gray-700">
        @csrf
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم القسم الإداري</label>
          <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="قسم خدماتنا الرئيسية" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المكون البرمجي (Blade Component)</label>
            <input type="text" name="component" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 font-mono" placeholder="Hero" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة</label>
            <select name="icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              @foreach($iconsList as $name => $lbl)
                <option value="{{ $name }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">ترتيب الظهور (الرقم الأصغر يظهر أولاً)</label>
          <input type="number" name="order" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="1" />
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="enabled" value="1" checked id="create-enabled" />
          <label for="create-enabled" class="text-sm font-bold">تفعيل القسم فورياً وعرضه بالصفحة الرئيسية</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">إضافة القسم</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات قسم العرض</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        @csrf
        @method('PUT')
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم القسم الإداري</label>
          <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المكون البرمجي (Blade Component)</label>
            <input type="text" name="component" id="edit-component" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none font-mono" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الأيقونة</label>
            <select name="icon" id="edit-icon" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              @foreach($iconsList as $name => $lbl)
                <option value="{{ $name }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">ترتيب الظهور (الرقم الأصغر يظهر أولاً)</label>
          <input type="number" name="order" id="edit-order" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="enabled" value="1" id="edit-enabled" />
          <label for="edit-enabled" class="text-sm font-bold">تفعيل القسم فورياً وعرضه بالصفحة الرئيسية</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterScreens() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const rows = document.querySelectorAll('.screen-row');
      
      rows.forEach(row => {
        const name = row.getAttribute('data-name').toLowerCase();
        const component = row.getAttribute('data-component').toLowerCase();
        
        if (name.includes(query) || component.includes(query)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function openCreateModal() {
      document.getElementById('create-modal').classList.remove('hidden');
    }

    function closeCreateModal() {
      document.getElementById('create-modal').classList.add('hidden');
    }

    function openEditModal(id, name, component, order, icon, enabled) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/screens/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-component').value = component;
      document.getElementById('edit-order').value = order;
      document.getElementById('edit-icon').value = icon;
      document.getElementById('edit-enabled').checked = enabled;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
@endsection
