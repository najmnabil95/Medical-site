@extends('layouts.admin')

@section('title', 'المقالات والأخبار - لوحة التحكم')

@section('content')
  @php
    $categories = [
      'أخبار المستشفى' => 'أزرق (أخبار المستشفى)',
      'نصائح طبية' => 'أخضر (نصائح طبية)',
      'التغذية والرياضة' => 'بنفسجي (التغذية والرياضة)',
      'الأبحاث والدراسات' => 'عسلي (الأبحاث والدراسات)',
    ];

    $categoryColors = [
      'أخبار المستشفى' => 'blue',
      'نصائح طبية' => 'emerald',
      'التغذية والرياضة' => 'purple',
      'الأبحاث والدراسات' => 'amber',
    ];

    $badgeColors = [
      'blue' => 'bg-blue-50 text-blue-700 border-blue-150',
      'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-150',
      'purple' => 'bg-purple-50 text-purple-700 border-purple-150',
      'amber' => 'bg-amber-50 text-amber-700 border-amber-150',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="newspaper" class="w-7 h-7 text-primary-600"></i>
        <span>المدونة الإخبارية والمقالات الطبية</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">نشر مقالات التوعية الصحية، وأخبار المؤتمرات الطبية وإنجازات المستشفى</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>نشر مقال/خبر جديد</span>
    </button>
  </div>

  <!-- Search Filter -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم المقال، الكاتب، أو التصنيف..."
        onkeyup="filterNews()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- News List Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="news-grid">
    @forelse($news as $item)
      @php
        $catColor = $categoryColors[$item->category] ?? 'blue';
        $badgeClass = $badgeColors[$catColor] ?? 'bg-blue-50 text-blue-700';
      @endphp
      <div
        class="news-card bg-white rounded-3xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all relative flex flex-col justify-between"
        data-title="{{ $item->title }}"
        data-author="{{ $item->author }}"
        data-cat="{{ $item->category }}"
      >
        @if($item->featured)
          <span class="absolute top-4 right-4 bg-red-500 text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm z-10">
            مقال مميز
          </span>
        @endif

        <div>
          <!-- Article Cover Image -->
          <div class="h-48 overflow-hidden bg-gray-50 relative">
            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80'" />
          </div>

          <div class="p-5 text-right">
            <!-- Category Badge -->
            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $badgeClass }} mb-3">
              {{ $item->category }}
            </span>

            <h3 class="font-bold text-gray-800 text-base leading-tight mb-2 hover:text-primary-600 transition-colors">
              {{ $item->title }}
            </h3>
            
            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed mb-4">
              {{ $item->excerpt }}
            </p>

            <!-- Metadata info -->
            <div class="flex items-center gap-3 justify-start text-[11px] text-gray-400 font-bold border-t border-gray-50 pt-3">
              <span class="flex items-center gap-1">
                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                <span>{{ $item->author }}</span>
              </span>
              <span class="flex items-center gap-1 font-mono">
                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                <span>{{ $item->date ? (\Carbon\Carbon::parse($item->date)->format('Y-m-d')) : '' }}</span>
              </span>
              <span class="flex items-center gap-1 font-mono">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                <span>{{ $item->read_time }}</span>
              </span>
            </div>
          </div>
        </div>

        <!-- Action tools -->
        <div class="p-5 pt-0 text-right">
          <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
            <button
              onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->category) }}', '{{ addslashes($item->excerpt) }}', '{{ addslashes($item->content) }}', '{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : '' }}', '{{ addslashes($item->author) }}', '{{ $item->read_time }}', '{{ $item->category_color }}', {{ $item->featured ? 'true' : 'false' }})"
              class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
            >
              <i data-lucide="edit" class="w-3.5 h-3.5"></i>
              <span>تعديل</span>
            </button>

            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('هل تريد حذف هذا المقال نهائياً؟');">
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="w-full py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
              >
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <span>حذف</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="newspaper" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا يوجد أخبار أو مقالات منشورة حالياً</p>
      </div>
    @endforelse
  </div>

  <!-- Create Modal -->
  <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">نشر خبر/مقال جديد</h3>
      </div>
      
      <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-gray-700">
        @csrf
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">عنوان المقال/الخبر الرئيسي</label>
          <input type="text" name="title" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="افتتاح العيادات التخصصية الجديدة بمستشفى الشفاء" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التصنيف</label>
            <select name="category" onchange="updateCategoryColor(this, 'create')" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              @foreach($categories as $name => $lbl)
                <option value="{{ $name }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اللون المميز للتصنيف (تلقائي)</label>
            <input type="text" name="category_color" id="create-cat-color" value="blue" readonly required class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm outline-none text-gray-500 font-mono" />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الكاتب</label>
            <input type="text" name="author" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="د. محمد الشريف" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">تاريخ النشر</label>
            <input type="date" name="date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" value="{{ date('Y-m-d') }}" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">وقت القراءة المقدر</label>
            <input type="text" name="read_time" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="5 دقائق" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">صورة الغلاف للمقال</label>
          <input type="file" name="image" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" accept="image/*" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">نبذة مختصرة (تظهر في الواجهة الرئيسية)</label>
          <textarea name="excerpt" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-16" placeholder="ملخص سريع وجذاب للمحتوى..."></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">المحتوى الكامل للمقال</label>
          <textarea name="content" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-40" placeholder="اكتب محتوى المقال الكامل هنا..."></textarea>
        </div>

        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2">
            <input type="checkbox" name="featured" value="1" id="create-featured" />
            <label for="create-featured" class="text-sm font-bold text-red-600">تثبيت كـ (خبر مميز بالرئيسية)</label>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">نشر المقال</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات المقال/الخبر</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-gray-700">
        @csrf
        @method('PUT')
        
        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">عنوان المقال/الخبر الرئيسي</label>
          <input type="text" name="title" id="edit-title" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التصنيف</label>
            <select name="category" id="edit-category" onchange="updateCategoryColor(this, 'edit')" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
              @foreach($categories as $name => $lbl)
                <option value="{{ $name }}">{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اللون المميز للتصنيف (تلقائي)</label>
            <input type="text" name="category_color" id="edit-cat-color" readonly required class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm outline-none text-gray-500 font-mono" />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم الكاتب</label>
            <input type="text" name="author" id="edit-author" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">تاريخ النشر</label>
            <input type="date" name="date" id="edit-date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">وقت القراءة المقدر</label>
            <input type="text" name="read_time" id="edit-read-time" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">صورة الغلاف <span class="text-gray-400 font-normal">(اتركها فارغة لعدم التعديل)</span></label>
          <input type="file" name="image" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" accept="image/*" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">نبذة مختصرة (تظهر في الواجهة الرئيسية)</label>
          <textarea name="excerpt" id="edit-excerpt" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-16"></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">المحتوى الكامل للمقال</label>
          <textarea name="content" id="edit-content" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-40"></textarea>
        </div>

        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2">
            <input type="checkbox" name="featured" value="1" id="edit-featured" />
            <label for="edit-featured" class="text-sm font-bold text-red-600">تثبيت كـ (خبر مميز بالرئيسية)</label>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const categoryColorsMap = {
      'أخبار المستشفى': 'blue',
      'نصائح طبية': 'emerald',
      'التغذية والرياضة': 'purple',
      'الأبحاث والدراسات': 'amber'
    };

    function updateCategoryColor(selectElem, mode) {
      const color = categoryColorsMap[selectElem.value] || 'blue';
      document.getElementById(`${mode}-cat-color`).value = color;
    }

    function filterNews() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.news-card');
      
      cards.forEach(card => {
        const title = card.getAttribute('data-title').toLowerCase();
        const author = card.getAttribute('data-author').toLowerCase();
        const cat = card.getAttribute('data-cat').toLowerCase();
        
        if (title.includes(query) || author.includes(query) || cat.includes(query)) {
          card.style.display = '';
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

    function openEditModal(id, title, category, excerpt, content, date, author, readTime, categoryColor, featured) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/news/${id}`;
      
      document.getElementById('edit-title').value = title;
      document.getElementById('edit-category').value = category;
      document.getElementById('edit-cat-color').value = categoryColor;
      document.getElementById('edit-excerpt').value = excerpt;
      document.getElementById('edit-content').value = content;
      document.getElementById('edit-date').value = date;
      document.getElementById('edit-author').value = author;
      document.getElementById('edit-read-time').value = readTime;
      document.getElementById('edit-featured').checked = featured;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }
  </script>
@endsection
