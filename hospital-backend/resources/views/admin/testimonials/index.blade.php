@extends('layouts.admin')

@section('title', 'آراء المرضى - لوحة التحكم')

@section('content')
  @php
    $colorsList = [
      'emerald' => 'أخضر زمردي',
      'blue' => 'أزرق',
      'purple' => 'بنفسجي',
      'amber' => 'عسلي / برتقالي',
      'rose' => 'وردي / أحمر',
    ];

    $colorClasses = [
      'emerald' => 'bg-emerald-50 border-emerald-100 text-emerald-800 shadow-emerald-500/10',
      'blue' => 'bg-blue-50 border-blue-100 text-blue-800 shadow-blue-500/10',
      'purple' => 'bg-purple-50 border-purple-100 text-purple-800 shadow-purple-500/10',
      'amber' => 'bg-amber-50 border-amber-100 text-amber-800 shadow-amber-500/10',
      'rose' => 'bg-rose-50 border-rose-100 text-rose-800 shadow-rose-500/10',
    ];

    $badgeColors = [
      'emerald' => 'bg-emerald-500',
      'blue' => 'bg-blue-500',
      'purple' => 'bg-purple-500',
      'amber' => 'bg-amber-500',
      'rose' => 'bg-rose-500',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="message-square" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة آراء المرضى والمراجعين</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">عرض، إضافة، وتعديل آراء المرضى المنشورة على الصفحة الرئيسية للموقع</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة رأي مريض</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم المريض أو التقييم أو نص الرأي..."
        onkeyup="filterTestimonials()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Testimonials Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="testimonials-grid">
    @forelse($testimonials as $test)
      @php
        $colorClass = $colorClasses[$test->color] ?? 'bg-white border-gray-100 text-gray-800 shadow-sm';
        $badgeClass = $badgeColors[$test->color] ?? 'bg-primary-500';
      @endphp
      <div
        class="testimonial-card border rounded-3xl p-5 text-right flex flex-col justify-between hover:shadow-xl transition-all {{ $colorClass }}"
        data-name="{{ $test->name }}"
        data-role="{{ $test->role }}"
        data-text="{{ $test->text }}"
      >
        <div>
          <!-- Patient header -->
          <div class="flex items-center justify-start gap-3 mb-4">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-sm shrink-0">
              <img src="{{ $test->avatar }}" alt="{{ $test->name }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80'" />
            </div>
            <div class="text-right">
              <h4 class="font-bold text-sm block leading-tight">{{ $test->name }}</h4>
              <span class="text-[10px] text-gray-400 font-bold">{{ $test->role }}</span>
            </div>
          </div>

          <!-- Stars Rating -->
          <div class="flex items-center justify-start gap-0.5 text-amber-400 mb-3" dir="rtl">
            @for($i = 1; $i <= 5; $i++)
              @if($i <= $test->rating)
                <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
              @else
                <i data-lucide="star" class="w-3.5 h-3.5 opacity-30"></i>
              @endif
            @endfor
          </div>

          <p class="text-xs leading-relaxed opacity-90 italic">
            "{{ $test->text }}"
          </p>
        </div>

        <div class="flex items-center gap-2 pt-4 mt-6 border-t border-black/5">
          <button
            onclick="openEditModal({{ $test->id }}, '{{ addslashes($test->name) }}', '{{ addslashes($test->role) }}', '{{ addslashes($test->text) }}', '{{ $test->rating }}', '{{ $test->color }}')"
            class="flex-1 py-2 bg-white/60 text-blue-700 rounded-lg text-xs font-bold hover:bg-white transition-colors flex items-center justify-center gap-1 cursor-pointer border border-black/5"
          >
            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
            <span>تعديل</span>
          </button>

          <form action="{{ route('admin.testimonials.destroy', $test->id) }}" method="POST" class="flex-1" onsubmit="return confirm('هل تريد إزالة هذا الرأي نهائياً؟');">
            @csrf
            @method('DELETE')
            <button
              type="submit"
              class="w-full py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1 cursor-pointer border border-red-100"
            >
              <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
              <span>حذف</span>
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400 shadow-sm">
        <i data-lucide="message-square-dashed" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا توجد آراء مرضى مضافة حالياً</p>
      </div>
    @endforelse
  </div>

  <!-- Create Modal -->
  <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">إضافة رأي مراجع جديد</h3>
      </div>
      
      <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-gray-700">
        @csrf
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المريض/المراجع</label>
            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="عبد الرحمن الغامدي" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الصفة / المهنة</label>
            <input type="text" name="role" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="مراجع قسم الأسنان" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التقييم (1-5 نجوم)</label>
            <select name="rating" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <option value="5">5 نجوم (ممتاز)</option>
              <option value="4">4 نجوم (جيد جداً)</option>
              <option value="3">3 نجوم (جيد)</option>
              <option value="2">2 نجوم (مقبول)</option>
              <option value="1">نجمة واحدة (ضعيف)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">النمط اللوني للبطاقة</label>
            <select name="color" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              @foreach($colorsList as $val => $lbl)
                <option value="{{ $val }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">صورة المريض الشخصية</label>
          <input type="file" name="avatar" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" accept="image/*" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">نص شهادة الرأي</label>
          <textarea name="text" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-24" placeholder="الحمد لله كانت تجربة رائعة في قسم الأسنان والخدمة متميزة وسريعة جداً..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ الرأي</button>
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
        <h3 class="text-xl font-bold text-gray-800">تعديل رأي المراجع</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-gray-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المريض/المراجع</label>
            <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الصفة / المهنة</label>
            <input type="text" name="role" id="edit-role" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التقييم (1-5 نجوم)</label>
            <select name="rating" id="edit-rating" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              <option value="5">5 نجوم (ممتاز)</option>
              <option value="4">4 نجوم (جيد جداً)</option>
              <option value="3">3 نجوم (جيد)</option>
              <option value="2">2 نجوم (مقبول)</option>
              <option value="1">نجمة واحدة (ضعيف)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">النمط اللوني للبطاقة</label>
            <select name="color" id="edit-color" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              @foreach($colorsList as $val => $lbl)
                <option value="{{ $val }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">تحديث صورة المريض <span class="text-gray-400 font-normal">(اتركها فارغة لعدم التعديل)</span></label>
          <input type="file" name="avatar" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" accept="image/*" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">نص شهادة الرأي</label>
          <textarea name="text" id="edit-text" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-24"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterTestimonials() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.testimonial-card');
      
      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const role = card.getAttribute('data-role').toLowerCase();
        const text = card.getAttribute('data-text').toLowerCase();
        
        if (name.includes(query) || role.includes(query) || text.includes(query)) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    function openCreateModal() {
      document.getElementById('create-modal').classList.remove('hidden');
    }

    function closeCreateModal() {
      document.getElementById('create-modal').classList.add('hidden');
    }

    function openEditModal(id, name, role, text, rating, color) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/testimonials/${id}`;
      
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-role').value = role;
      document.getElementById('edit-text').value = text;
      document.getElementById('edit-rating').value = rating;
      document.getElementById('edit-color').value = color;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
@endsection
