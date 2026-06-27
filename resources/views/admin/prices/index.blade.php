@extends('layouts.admin')

@section('title', 'قائمة الأسعار - لوحة التحكم')

@section('content')
  @php
    $categories = [
      'الاستشارات والزيارات' => 'الاستشارات والزيارات',
      'التحاليل والمختبر' => 'التحاليل والمختبر',
      'الأشعة والتصوير' => 'الأشعة والتصوير',
      'العمليات والإجراءات' => 'العمليات والإجراءات',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="dollar-sign" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة قائمة أسعار الخدمات الطبية</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تعديل وتحديد تسعيرة الكشوفات، الرعاية، الأشعة، والتحاليل المخبرية</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة بند سعري جديد</span>
    </button>
  </div>

  <!-- Search & Category Filters -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
    <div class="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم الخدمة أو الوصف..."
        onkeyup="filterPrices()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
    <div class="w-full md:w-64">
      <select id="category-filter" onchange="filterPrices()" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-150 rounded-xl text-sm focus:outline-none focus:border-primary-500">
        <option value="">كل التصنيفات المالية</option>
        @foreach($categories as $name => $lbl)
          <option value="{{ $name }}">{{ $lbl }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <!-- Prices Table -->
  <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse" id="prices-table">
        <thead>
          <tr class="bg-gray-50 text-gray-400 text-xs font-bold border-b border-gray-100">
            <th class="p-4">اسم الإجراء / الخدمة</th>
            <th class="p-4">التصنيف</th>
            <th class="p-4 text-center">السعر</th>
            <th class="p-4 text-center">المدة التقديرية</th>
            <th class="p-4">الوصف</th>
            <th class="p-4 text-center">الحالة</th>
            <th class="p-4 text-center">الخيارات</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
          @forelse($prices as $price)
            <tr
              class="price-row hover:bg-gray-50 transition-colors"
              data-service="{{ $price->service }}"
              data-desc="{{ $price->description }}"
              data-cat="{{ $price->category }}"
            >
              <td class="p-4 font-bold text-gray-800">{{ $price->service }}</td>
              <td class="p-4 text-gray-600">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                  {{ $price->category }}
                </span>
              </td>
              <td class="p-4 text-center text-primary-700 font-black tabular-nums">
                @if($price->price_to)
                  {{ number_format((float) str_replace(',', '', $price->price)) }} - {{ number_format((float) str_replace(',', '', $price->price_to)) }}
                @else
                  {{ number_format((float) str_replace(',', '', $price->price)) }}
                @endif
                <span class="text-xs text-gray-400 font-normal mr-0.5">{{ $price->currency }}</span>
              </td>
              <td class="p-4 text-center text-gray-500 font-medium">
                {{ $price->duration ?? 'غير محدد' }}
              </td>
              <td class="p-4 text-gray-400 max-w-xs truncate">{{ $price->description ?? 'لا يوجد وصف' }}</td>
              <td class="p-4 text-center">
                <!-- Active Toggle Button -->
                <form action="{{ route('admin.prices.update', $price->id) }}" method="POST" class="inline">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="service" value="{{ $price->service }}" />
                  <input type="hidden" name="category" value="{{ $price->category }}" />
                  <input type="hidden" name="price" value="{{ $price->price }}" />
                  <input type="hidden" name="price_to" value="{{ $price->price_to }}" />
                  <input type="hidden" name="currency" value="{{ $price->currency }}" />
                  <input type="hidden" name="duration" value="{{ $price->duration }}" />
                  <input type="hidden" name="description" value="{{ $price->description }}" />
                  @if($price->active)
                    <button type="submit" class="text-emerald-500 hover:scale-115 transition-transform cursor-pointer">
                      <i data-lucide="toggle-right" class="w-8 h-8"></i>
                    </button>
                  @else
                    <button type="submit" name="active" value="1" class="text-gray-300 hover:scale-115 transition-transform cursor-pointer">
                      <i data-lucide="toggle-left" class="w-8 h-8"></i>
                    </button>
                  @endif
                </form>
              </td>
              <td class="p-4">
                <div class="flex items-center justify-center gap-2">
                  <button
                    onclick="openEditModal({{ $price->id }}, '{{ addslashes($price->service) }}', '{{ addslashes($price->category) }}', '{{ $price->price }}', '{{ $price->price_to }}', '{{ $price->currency }}', '{{ addslashes($price->duration) }}', '{{ addslashes($price->description) }}', {{ $price->active ? 'true' : 'false' }})"
                    class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer"
                    title="تعديل"
                  >
                    <i data-lucide="edit" class="w-4 h-4"></i>
                  </button>
                  
                  <form action="{{ route('admin.prices.destroy', $price->id) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا البند المالي نهائياً؟');">
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
                <i data-lucide="info" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
                <p>لا توجد بنود أسعار مضافة حالياً</p>
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
        <h3 class="text-xl font-bold text-gray-800">إضافة بند مالي جديد</h3>
      </div>
      
      <form action="{{ route('admin.prices.store') }}" method="POST" class="p-6 space-y-4 text-gray-700">
        @csrf
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم الخدمة أو الإجراء الطبي</label>
          <input type="text" name="service" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="تصوير أشعة الرنين المغناطيسي (MRI)" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التصنيف</label>
            <select name="category" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              @foreach($categories as $name => $lbl)
                <option value="{{ $name }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">العملة</label>
            <input type="text" name="currency" value="SAR" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 font-bold" />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">السعر الأساسي</label>
            <input type="number" name="price" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="150" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">السعر الأقصى (اختياري)</label>
            <input type="number" name="price_to" min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="300" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">المدة المقدرة (اختياري)</label>
            <input type="text" name="duration" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="30 دقيقة / يوم واحد" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف مختصر للخدمة المالية</label>
          <textarea name="description" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-20" placeholder="تغطية الفحص تشمل التقرير الفني والمطابقة..."></textarea>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" checked id="create-active" />
          <label for="create-active" class="text-sm font-bold">نشط ومتاح للجمهور</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ البند</button>
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
        <h3 class="text-xl font-bold text-gray-800">تعديل البند المالي</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        @csrf
        @method('PUT')
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">اسم الخدمة أو الإجراء الطبي</label>
          <input type="text" name="service" id="edit-service" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التصنيف</label>
            <select name="category" id="edit-category" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              @foreach($categories as $name => $lbl)
                <option value="{{ $name }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">العملة</label>
            <input type="text" name="currency" id="edit-currency" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">السعر الأساسي</label>
            <input type="number" name="price" id="edit-price" required min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">السعر الأقصى (اختياري)</label>
            <input type="number" name="price_to" id="edit-price-to" min="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">المدة المقدرة (اختياري)</label>
            <input type="text" name="duration" id="edit-duration" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">وصف مختصر للخدمة المالية</label>
          <textarea name="description" id="edit-description" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-20"></textarea>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" id="edit-active" />
          <label for="edit-active" class="text-sm font-bold">نشط ومتاح للجمهور</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterPrices() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const catFilter = document.getElementById('category-filter').value.toLowerCase();
      const rows = document.querySelectorAll('.price-row');
      
      rows.forEach(row => {
        const service = row.getAttribute('data-service').toLowerCase();
        const desc = row.getAttribute('data-desc').toLowerCase();
        const cat = row.getAttribute('data-cat').toLowerCase();
        
        const matchesQuery = service.includes(query) || desc.includes(query);
        const matchesCat = catFilter === '' || cat === catFilter;
        
        if (matchesQuery && matchesCat) {
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

    function openEditModal(id, service, category, price, priceTo, currency, duration, description, active) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/prices/${id}`;
      
      document.getElementById('edit-service').value = service;
      document.getElementById('edit-category').value = category;
      document.getElementById('edit-price').value = price;
      document.getElementById('edit-price-to').value = priceTo === 'null' || priceTo === null ? '' : priceTo;
      document.getElementById('edit-currency').value = currency;
      document.getElementById('edit-duration').value = duration === 'null' || duration === null ? '' : duration;
      document.getElementById('edit-description').value = description === 'null' || description === null ? '' : description;
      document.getElementById('edit-active').checked = active;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
@endsection
