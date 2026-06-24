@extends('layouts.admin')

@section('title', 'إدارة المستخدمين - لوحة التحكم')

@section('content')
  @php
    $departments = \App\Models\Department::where('active', true)->get();
    $doctorsList = \App\Models\Doctor::where('active', true)->get();

    $roleLabels = [
      'admin' => 'مدير النظام',
      'doctor' => 'طبيب استشاري',
      'nurse' => 'ممرض/ة',
      'reception' => 'موظف استقبال',
      'accountant' => 'محاسب',
    ];

    $roleColors = [
      'admin' => 'from-red-500 to-rose-600',
      'doctor' => 'from-blue-500 to-indigo-600',
      'nurse' => 'from-emerald-500 to-teal-600',
      'reception' => 'from-amber-500 to-orange-600',
      'accountant' => 'from-purple-500 to-violet-600',
    ];
  @endphp

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="shield" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة مستخدمي النظام</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">إضافة، تعديل، وإيقاف حسابات موظفي وأطباء المستشفى</p>
    </div>
    
    <button
      onclick="openCreateUserModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>إضافة مستخدم جديد</span>
    </button>
  </div>

  <!-- Role Counters Filters -->
  <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    @foreach($roleLabels as $role => $label)
      <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
        <div class="w-10 h-10 bg-gradient-to-br {{ $roleColors[$role] }} rounded-lg flex items-center justify-center text-white mb-2">
          <i data-lucide="user" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-black text-gray-800 tabular-nums">
          {{ $users->where('role', $role)->count() }}
        </div>
        <div class="text-xs text-gray-400 mt-1 font-medium">{{ $label }}</div>
      </div>
    @endforeach
  </div>

  <!-- Filters Search Bar -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
    <div class="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="user-search-input"
        placeholder="بحث بالاسم أو اسم المستخدم أو البريد..."
        onkeyup="filterUsers()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Users Cards Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="users-cards-grid">
    @forelse($users as $user)
      @php
        $roleColor = $roleColors[$user->role] ?? 'from-gray-500 to-gray-700';
        $roleLabel = $roleLabels[$user->role] ?? 'مستخدم';
      @endphp
      <div
        class="user-card bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all {{ !$user->active ? 'opacity-60' : '' }}"
        data-name="{{ $user->name }}"
        data-username="{{ $user->username }}"
        data-email="{{ $user->email }}"
      >
        <div class="h-2 bg-gradient-to-l {{ $roleColor }}"></div>
        <div class="p-5 text-right">
          
          <!-- Card Header Info -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gradient-to-br {{ $roleColor }} rounded-xl flex items-center justify-center text-white font-black text-lg">
                {{ substr($user->name, 0, 2) }}
              </div>
              <div class="text-right">
                <h3 class="font-bold text-gray-800">{{ $user->name }}</h3>
                <p class="text-xs text-gray-400">@<span>{{ $user->username }}</span></p>
              </div>
            </div>

            <!-- Active Toggle Button -->
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="inline">
              @csrf
              @method('PUT')
              <input type="hidden" name="name" value="{{ $user->name }}" />
              <input type="hidden" name="username" value="{{ $user->username }}" />
              <input type="hidden" name="role" value="{{ $user->role }}" />
              <input type="hidden" name="email" value="{{ $user->email }}" />
              <input type="hidden" name="phone" value="{{ $user->phone }}" />
              @if($user->role !== 'admin')
                @if($user->active)
                  <button type="submit" class="text-green-500 hover:scale-110 transition-transform cursor-pointer">
                    <i data-lucide="toggle-right" class="w-8 h-8"></i>
                  </button>
                @else
                  <button type="submit" name="active" value="1" class="text-gray-400 hover:scale-110 transition-transform cursor-pointer">
                    <i data-lucide="toggle-left" class="w-8 h-8"></i>
                  </button>
                @endif
              @else
                <span class="text-red-500 opacity-50" title="لا يمكن إيقاف حساب مدير النظام">
                  <i data-lucide="toggle-right" class="w-8 h-8"></i>
                </span>
              @endif
            </form>
          </div>

          <!-- Card Details -->
          <div class="space-y-2 mb-5 text-sm text-gray-600">
            <div class="flex items-center gap-2 justify-start">
              <i data-lucide="mail" class="text-gray-400 w-4 h-4"></i>
              <span class="truncate">{{ $user->email ?? 'لا يوجد بريد إلكتروني' }}</span>
            </div>
            <div class="flex items-center gap-2 justify-start">
              <i data-lucide="phone" class="text-gray-400 w-4 h-4"></i>
              <span dir="ltr">{{ $user->phone ?? 'لا يوجد رقم' }}</span>
            </div>
            
            <div class="pt-2 flex items-center gap-2 justify-start">
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-l {{ $roleColor }} text-white">
                {{ $roleLabel }}
              </span>
            </div>
          </div>

          <!-- Card Actions (Edit, Delete) -->
          <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
            <button
              onclick="openEditUserModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}', '{{ $user->role }}', '{{ $user->email }}', '{{ $user->phone }}', {{ $user->active ? 'true' : 'false' }}, {{ json_encode($user->assigned_departments ?? []) }}, {{ json_encode($user->assigned_doctors ?? []) }})"
              class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
            >
              <i data-lucide="edit" class="w-3.5 h-3.5"></i>
              <span>تعديل</span>
            </button>

            @if($user->role !== 'admin')
              <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المستخدم نهائياً؟');">
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
            @else
              <button
                disabled
                class="flex-1 py-2 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold cursor-not-allowed flex items-center justify-center gap-1"
                title="لا يمكن حذف حساب مدير النظام"
              >
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <span>حذف</span>
              </button>
            @endif
          </div>

        </div>
      </div>
    @empty
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="shield" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا يوجد مستخدمين مسجلين</p>
      </div>
    @endforelse
  </div>

  <!-- ============================================
       Create User Modal
       ============================================ -->
  <div id="create-user-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateUserModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateUserModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">إضافة مستخدم جديد</h3>
      </div>
      
      <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-5 text-gray-700">
        @csrf
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الاسم الكامل</label>
            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="د. أحمد محمد" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المستخدم</label>
            <input type="text" name="username" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="ahmed.doctor" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">كلمة المرور</label>
          <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="كلمة مرور لا تقل عن 6 أحرف" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الدور</label>
          <select name="role" id="create-user-role-select" onchange="toggleRoleAssignedFields('create')" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
            @foreach($roleLabels as $role => $label)
              <option value="{{ $role }}">{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">البريد الإلكتروني</label>
            <input type="email" name="email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="doctor@alshifa.com" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">رقم الهاتف</label>
            <input type="tel" name="phone" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="+96650000000" />
          </div>
        </div>

        <!-- Doctor fields -->
        <div id="create-doctor-fields" class="hidden bg-blue-50 border border-blue-100 rounded-xl p-4">
          <label class="block text-xs font-bold text-gray-700 mb-2">القسم الطبي المسند</label>
          <select name="assigned_departments[]" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none">
            <option value="">اختر القسم</option>
            @foreach($departments as $dept)
              <option value="{{ $dept->name }}">{{ $dept->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Nurse fields -->
        <div id="create-nurse-fields" class="hidden bg-emerald-50 border border-emerald-100 rounded-xl p-4 space-y-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أقسام التمريض المسندة</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              @foreach($departments as $dept)
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_departments[]" value="{{ $dept->name }}" />
                  <span>{{ $dept->name }}</span>
                </label>
              @endforeach
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أطباء المتابعة المرتبطين</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              @foreach($doctorsList as $doc)
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_doctors[]" value="{{ $doc->name }}" />
                  <span>{{ $doc->name }} - {{ $doc->department }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" checked id="create-active" />
          <label for="create-active" class="text-sm font-bold">الحساب نشط (تمكينه من الدخول)</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateUserModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">إنشاء الحساب</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ============================================
       Edit User Modal
       ============================================ -->
  <div id="edit-user-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditUserModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditUserModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات المستخدم</h3>
      </div>
      
      <form id="edit-user-form" action="" method="POST" class="p-6 space-y-5 text-gray-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الاسم الكامل</label>
            <input type="text" name="name" id="edit-user-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المستخدم</label>
            <input type="text" name="username" id="edit-user-username" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">كلمة المرور الجديدة <span class="text-gray-400 font-normal">(اتركها فارغة إذا لم ترد التعديل)</span></label>
          <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="••••••••" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الدور</label>
          <select name="role" id="edit-user-role-select" onchange="toggleRoleAssignedFields('edit')" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
            @foreach($roleLabels as $role => $label)
              <option value="{{ $role }}">{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">البريد الإلكتروني</label>
            <input type="email" name="email" id="edit-user-email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">رقم الهاتف</label>
            <input type="tel" name="phone" id="edit-user-phone" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <!-- Doctor fields -->
        <div id="edit-doctor-fields" class="hidden bg-blue-50 border border-blue-100 rounded-xl p-4">
          <label class="block text-xs font-bold text-gray-700 mb-2">القسم الطبي المسند</label>
          <select name="assigned_departments[]" id="edit-doctor-dept-select" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none">
            <option value="">اختر القسم</option>
            @foreach($departments as $dept)
              <option value="{{ $dept->name }}">{{ $dept->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Nurse fields -->
        <div id="edit-nurse-fields" class="hidden bg-emerald-50 border border-emerald-100 rounded-xl p-4 space-y-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أقسام التمريض المسندة</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              @foreach($departments as $dept)
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_departments[]" class="edit-nurse-dept-cb" value="{{ $dept->name }}" />
                  <span>{{ $dept->name }}</span>
                </label>
              @endforeach
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أطباء المتابعة المرتبطين</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              @foreach($doctorsList as $doc)
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_doctors[]" class="edit-nurse-doc-cb" value="{{ $doc->name }}" />
                  <span>{{ $doc->name }} - {{ $doc->department }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" name="active" value="1" id="edit-user-active" />
          <label for="edit-user-active" class="text-sm font-bold">الحساب نشط (تمكينه من الدخول)</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditUserModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التغييرات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Search Filtering
    function filterUsers() {
      const query = document.getElementById('user-search-input').value.toLowerCase();
      const cards = document.querySelectorAll('.user-card');

      cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const username = card.getAttribute('data-username').toLowerCase();
        const email = card.getAttribute('data-email').toLowerCase();

        if (name.includes(query) || username.includes(query) || email.includes(query)) {
          card.classList.remove('hidden');
        } else {
          card.classList.add('hidden');
        }
      });
    }

    // Toggle dropdowns or extra modal fields based on role selection
    function toggleRoleAssignedFields(type) {
      const roleSelect = document.getElementById(type + '-user-role-select');
      const role = roleSelect.value;

      const docFields = document.getElementById(type + '-doctor-fields');
      const nurseFields = document.getElementById(type + '-nurse-fields');

      if (role === 'doctor') {
        docFields.classList.remove('hidden');
        nurseFields.classList.add('hidden');
      } else if (role === 'nurse') {
        docFields.classList.add('hidden');
        nurseFields.classList.remove('hidden');
      } else {
        docFields.classList.add('hidden');
        nurseFields.classList.add('hidden');
      }
    }

    // Modal Control
    function openCreateUserModal() {
      const modal = document.getElementById('create-user-modal');
      modal.classList.remove('hidden');
      toggleRoleAssignedFields('create');
    }

    function closeCreateUserModal() {
      document.getElementById('create-user-modal').classList.add('hidden');
    }

    function openEditUserModal(id, name, username, role, email, phone, active, assignedDepts, assignedDocs) {
      const modal = document.getElementById('edit-user-modal');
      const form = document.getElementById('edit-user-form');
      
      // Update form URL route
      form.action = '/admin/users/' + id;

      document.getElementById('edit-user-name').value = name;
      document.getElementById('edit-user-username').value = username;
      document.getElementById('edit-user-email').value = email;
      document.getElementById('edit-user-phone').value = phone;
      document.getElementById('edit-user-active').checked = active;
      
      const roleSelect = document.getElementById('edit-user-role-select');
      roleSelect.value = role;

      // Lock parameters for admin role editing safety
      if (role === 'admin' || username === 'admin') {
        roleSelect.disabled = true;
        document.getElementById('edit-user-phone').disabled = true;
      } else {
        roleSelect.disabled = false;
        document.getElementById('edit-user-phone').disabled = false;
      }

      // Reset and fill Doctor department option
      const docDeptSelect = document.getElementById('edit-doctor-dept-select');
      docDeptSelect.value = (role === 'doctor' && assignedDepts.length > 0) ? assignedDepts[0] : '';

      // Reset and fill Nurse checkbox arrays
      const nurseDeptCbs = document.querySelectorAll('.edit-nurse-dept-cb');
      nurseDeptCbs.forEach(cb => {
        cb.checked = (role === 'nurse' && assignedDepts.includes(cb.value));
      });

      const nurseDocCbs = document.querySelectorAll('.edit-nurse-doc-cb');
      nurseDocCbs.forEach(cb => {
        cb.checked = (role === 'nurse' && assignedDocs.includes(cb.value));
      });

      toggleRoleAssignedFields('edit');
      modal.classList.remove('hidden');
    }

    function closeEditUserModal() {
      document.getElementById('edit-user-modal').classList.add('hidden');
    }
  </script>
@endsection
