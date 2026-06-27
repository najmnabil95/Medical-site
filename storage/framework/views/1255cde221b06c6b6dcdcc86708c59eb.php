<?php $__env->startSection('title', 'إدارة المستخدمين - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $departments = \App\Models\Department::where('active', true)->get();
    $doctorsList = \App\Models\Doctor::where('active', true)->get();

    $roleLabels = [
      'Super Admin' => 'مدير النظام (Super Admin)',
      'Manager' => 'مدير عام',
      'Doctor' => 'طبيب',
      'Nurse' => 'ممرض/ممرضة',
      'Reception' => 'موظف استقبال',
      'Accountant' => 'محاسب',
      'Editor' => 'محرر محتوى',
    ];

    $roleColors = [
      'Super Admin' => 'from-red-500 to-rose-600',
      'Manager' => 'from-blue-500 to-indigo-600',
      'Doctor' => 'from-purple-500 to-violet-600',
      'Nurse' => 'from-pink-500 to-rose-600',
      'Reception' => 'from-cyan-500 to-teal-600',
      'Accountant' => 'from-amber-500 to-orange-600',
      'Editor' => 'from-emerald-500 to-teal-600',
    ];
  ?>

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
    <?php $__currentLoopData = $roleLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right">
        <div class="w-10 h-10 bg-gradient-to-br <?php echo e($roleColors[$role]); ?> rounded-lg flex items-center justify-center text-white mb-2">
          <i data-lucide="user" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-black text-gray-800 tabular-nums">
          <?php echo e($users->where('role', $role)->count()); ?>

        </div>
        <div class="text-xs text-gray-400 mt-1 font-medium"><?php echo e($label); ?></div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $userRoleName = $user->roles->first()?->name ?? $user->role ?? 'مستخدم';
        $roleColor = $roleColors[$userRoleName] ?? 'from-gray-500 to-gray-700';
        $roleLabel = $roleLabels[$userRoleName] ?? $userRoleName;
      ?>
      <div
        class="user-card bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all <?php echo e(!$user->active ? 'opacity-60' : ''); ?>"
        data-name="<?php echo e($user->name); ?>"
        data-username="<?php echo e($user->username); ?>"
        data-email="<?php echo e($user->email); ?>"
      >
        <div class="h-2 bg-gradient-to-l <?php echo e($roleColor); ?>"></div>
        <div class="p-5 text-right">
          
          <!-- Card Header Info -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gradient-to-br <?php echo e($roleColor); ?> rounded-xl flex items-center justify-center text-white font-black text-lg">
                <?php echo e(substr($user->name, 0, 2)); ?>

              </div>
              <div class="text-right">
                <h3 class="font-bold text-gray-800"><?php echo e($user->name); ?></h3>
                <p class="text-xs text-gray-400">@<span><?php echo e($user->username); ?></span></p>
              </div>
            </div>

            <!-- Active Toggle Button -->
            <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST" class="inline">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>
              <input type="hidden" name="name" value="<?php echo e($user->name); ?>" />
              <input type="hidden" name="username" value="<?php echo e($user->username); ?>" />
              <input type="hidden" name="role" value="<?php echo e($userRoleName); ?>" />
              <input type="hidden" name="email" value="<?php echo e($user->email); ?>" />
              <input type="hidden" name="phone" value="<?php echo e($user->phone); ?>" />
              <?php if($userRoleName !== 'Super Admin' && $user->username !== 'admin' && Auth::user()->id !== $user->id): ?>
                <?php if($user->active): ?>
                  <button type="submit" class="text-green-500 hover:scale-110 transition-transform cursor-pointer">
                    <i data-lucide="toggle-right" class="w-8 h-8"></i>
                  </button>
                <?php else: ?>
                  <button type="submit" name="active" value="1" class="text-gray-400 hover:scale-110 transition-transform cursor-pointer">
                    <i data-lucide="toggle-left" class="w-8 h-8"></i>
                  </button>
                <?php endif; ?>
              <?php else: ?>
                <span class="text-red-500 opacity-50" title="<?php echo e(Auth::user()->id === $user->id ? 'لا يمكنك تعديل حسابك الشخصي' : 'لا يمكن إيقاف حساب مدير النظام'); ?>">
                  <i data-lucide="toggle-right" class="w-8 h-8"></i>
                </span>
              <?php endif; ?>
            </form>
          </div>

          <!-- Card Details -->
          <div class="space-y-2 mb-5 text-sm text-gray-600">
            <div class="flex items-center gap-2 justify-start">
              <i data-lucide="mail" class="text-gray-400 w-4 h-4"></i>
              <span class="truncate"><?php echo e($user->email ?? 'لا يوجد بريد إلكتروني'); ?></span>
            </div>
            <div class="flex items-center gap-2 justify-start">
              <i data-lucide="phone" class="text-gray-400 w-4 h-4"></i>
              <span dir="ltr"><?php echo e($user->phone ?? 'لا يوجد رقم'); ?></span>
            </div>
            
            <div class="pt-2 flex items-center gap-2 justify-start">
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-l <?php echo e($roleColor); ?> text-white">
                <?php echo e($roleLabel); ?>

              </span>
            </div>
          </div>

          <!-- Card Actions (Edit, Delete) -->
          <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
            <?php if(($userRoleName !== 'Super Admin' && $user->username !== 'admin' || Auth::user()->hasRole('Super Admin')) && Auth::user()->id !== $user->id): ?>
              <button
                onclick="openEditUserModal(<?php echo e($user->id); ?>, '<?php echo e(addslashes($user->name)); ?>', '<?php echo e(addslashes($user->username)); ?>', '<?php echo e($userRoleName); ?>', '<?php echo e($user->email); ?>', '<?php echo e($user->phone); ?>', <?php echo e($user->active ? 'true' : 'false'); ?>, <?php echo e(json_encode($user->assigned_departments ?? [])); ?>, <?php echo e(json_encode($user->assigned_doctors ?? [])); ?>)"
                class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
              >
                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                <span>تعديل</span>
              </button>
            <?php else: ?>
              <button
                disabled
                class="flex-1 py-2 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold cursor-not-allowed flex items-center justify-center gap-1"
                title="<?php echo e(Auth::user()->id === $user->id ? 'لا يمكنك تعديل حسابك الشخصي' : 'لا يمكنك تعديل حساب مدير النظام'); ?>"
              >
                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                <span>تعديل</span>
              </button>
            <?php endif; ?>

            <?php if($userRoleName !== 'Super Admin' && $user->username !== 'admin' && Auth::user()->id !== $user->id): ?>
              <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المستخدم نهائياً؟');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button
                  type="submit"
                  class="w-full py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1 cursor-pointer"
                >
                  <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                  <span>حذف</span>
                </button>
              </form>
            <?php else: ?>
              <button
                disabled
                class="flex-1 py-2 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold cursor-not-allowed flex items-center justify-center gap-1"
                title="<?php echo e(Auth::user()->id === $user->id ? 'لا يمكنك حذف حسابك الشخصي' : 'لا يمكن حذف حساب مدير النظام'); ?>"
              >
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <span>حذف</span>
              </button>
            <?php endif; ?>
          </div>

        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-span-full bg-white rounded-3xl p-16 border border-gray-100 text-center text-gray-400">
        <i data-lucide="shield" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
        <p>لا يوجد مستخدمين مسجلين</p>
      </div>
    <?php endif; ?>
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
      
      <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" class="p-6 space-y-5 text-gray-700">
        <?php echo csrf_field(); ?>
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
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleObj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($roleObj->name); ?>"><?php echo e($roleLabels[$roleObj->name] ?? $roleObj->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <!-- Nurse fields -->
        <div id="create-nurse-fields" class="hidden bg-emerald-50 border border-emerald-100 rounded-xl p-4 space-y-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أقسام التمريض المسندة</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_departments[]" value="<?php echo e($dept->name); ?>" />
                  <span><?php echo e($dept->name); ?></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أطباء المتابعة المرتبطين</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              <?php $__currentLoopData = $doctorsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_doctors[]" value="<?php echo e($doc->name); ?>" />
                  <span><?php echo e($doc->name); ?> - <?php echo e($doc->department); ?></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
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
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleObj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($roleObj->name); ?>"><?php echo e($roleLabels[$roleObj->name] ?? $roleObj->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <!-- Nurse fields -->
        <div id="edit-nurse-fields" class="hidden bg-emerald-50 border border-emerald-100 rounded-xl p-4 space-y-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أقسام التمريض المسندة</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_departments[]" class="edit-nurse-dept-cb" value="<?php echo e($dept->name); ?>" />
                  <span><?php echo e($dept->name); ?></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2 font-black">أطباء المتابعة المرتبطين</label>
            <div class="bg-white p-3 rounded-lg border border-gray-200 max-h-32 overflow-y-auto space-y-2">
              <?php $__currentLoopData = $doctorsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-2 text-sm justify-start cursor-pointer">
                  <input type="checkbox" name="assigned_doctors[]" class="edit-nurse-doc-cb" value="<?php echo e($doc->name); ?>" />
                  <span><?php echo e($doc->name); ?> - <?php echo e($doc->department); ?></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
      const roleLower = role ? role.toLowerCase() : '';

      const docFields = document.getElementById(type + '-doctor-fields');
      const nurseFields = document.getElementById(type + '-nurse-fields');

      if (roleLower === 'doctor') {
        docFields.classList.remove('hidden');
        nurseFields.classList.add('hidden');
      } else if (roleLower === 'nurse') {
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
      if (role === 'Super Admin' || username === 'admin') {
        document.getElementById('edit-user-name').disabled = true;
        document.getElementById('edit-user-username').disabled = true;
        document.getElementById('edit-user-email').disabled = true;
        document.getElementById('edit-user-phone').disabled = true;
        document.getElementById('edit-user-active').disabled = true;
        roleSelect.disabled = true;
      } else {
        document.getElementById('edit-user-name').disabled = false;
        document.getElementById('edit-user-username').disabled = false;
        document.getElementById('edit-user-email').disabled = false;
        document.getElementById('edit-user-phone').disabled = false;
        document.getElementById('edit-user-active').disabled = false;
        roleSelect.disabled = false;
      }

      // Reset and fill Doctor department option
      const docDeptSelect = document.getElementById('edit-doctor-dept-select');
      const roleLower = role ? role.toLowerCase() : '';
      docDeptSelect.value = (roleLower === 'doctor' && assignedDepts.length > 0) ? assignedDepts[0] : '';

      // Reset and fill Nurse checkbox arrays
      const nurseDeptCbs = document.querySelectorAll('.edit-nurse-dept-cb');
      nurseDeptCbs.forEach(cb => {
        cb.checked = (roleLower === 'nurse' && assignedDepts.includes(cb.value));
      });

      const nurseDocCbs = document.querySelectorAll('.edit-nurse-doc-cb');
      nurseDocCbs.forEach(cb => {
        cb.checked = (roleLower === 'nurse' && assignedDocs.includes(cb.value));
      });

      toggleRoleAssignedFields('edit');
      modal.classList.remove('hidden');
    }

    function closeEditUserModal() {
      document.getElementById('edit-user-modal').classList.add('hidden');
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/admin/users/index.blade.php ENDPATH**/ ?>