<?php $__env->startSection('title', 'إدارة الحجوزات - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $departments = \App\Models\Department::where('active', true)->get();
    $doctors = \App\Models\Doctor::where('active', true)->get();

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

    $statusBgGradients = [
      'pending' => 'from-amber-500 to-orange-600',
      'confirmed' => 'from-blue-500 to-indigo-600',
      'completed' => 'from-emerald-500 to-teal-600',
      'cancelled' => 'from-rose-500 to-red-600',
    ];
  ?>

  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="calendar" class="w-7 h-7 text-primary-600"></i>
        <span>إدارة الحجوزات الطبية</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">عرض، تعديل حالات، وجدولة حجوزات المرضى بالمستشفى</p>
    </div>
    
    <button
      onclick="openCreateModal()"
      class="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer self-start md:self-auto"
    >
      <i data-lucide="plus" class="w-4.5 h-4.5"></i>
      <span>حجز موعد جديد</span>
    </button>
  </div>

  <!-- Status Counter Widgets -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-right relative overflow-hidden">
        <div class="w-10 h-10 bg-gradient-to-br <?php echo e($statusBgGradients[$status]); ?> rounded-lg flex items-center justify-center text-white mb-2">
          <i data-lucide="clock" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-black text-gray-800 tabular-nums">
          <?php echo e(\App\Models\Appointment::where('status', $status)->count()); ?>

        </div>
        <div class="text-xs text-gray-400 mt-1 font-medium"><?php echo e($label); ?></div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- Tabs Navigation -->
  <div class="flex gap-2 mb-6 border-b border-gray-100 pb-2 overflow-x-auto">
    <a href="<?php echo e(route('admin.appointments.index', ['tab' => 'today'])); ?>" 
       class="px-4 py-2 text-sm font-bold rounded-xl transition-all whitespace-nowrap <?php echo e($tab === 'today' ? 'bg-primary-50 text-primary-700' : 'text-gray-500 hover:bg-gray-50'); ?>">
      حجوزات اليوم 
      <?php if($todayRemaining > 0): ?>
        <span class="mr-2 px-2 py-0.5 text-xs bg-primary-100 text-primary-700 rounded-full"><?php echo e($todayRemaining); ?></span>
      <?php endif; ?>
    </a>
    <a href="<?php echo e(route('admin.appointments.index', ['tab' => 'pending'])); ?>" 
       class="px-4 py-2 text-sm font-bold rounded-xl transition-all whitespace-nowrap <?php echo e($tab === 'pending' ? 'bg-amber-50 text-amber-700' : 'text-gray-500 hover:bg-gray-50'); ?>">
      قيد الانتظار
    </a>
    <a href="<?php echo e(route('admin.appointments.index', ['tab' => 'all'])); ?>" 
       class="px-4 py-2 text-sm font-bold rounded-xl transition-all whitespace-nowrap <?php echo e($tab === 'all' ? 'bg-gray-100 text-gray-800' : 'text-gray-500 hover:bg-gray-50'); ?>">
      جميع الحجوزات
    </a>
  </div>

  <!-- Search & Filter Bar -->
  <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
    <div class="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
      <i data-lucide="search" class="text-gray-400 w-4 h-4"></i>
      <input
        type="text"
        id="search-input"
        placeholder="بحث باسم المريض، رقم الهاتف، أو الطبيب..."
        onkeyup="filterAppointments()"
        class="bg-transparent outline-none flex-1 text-sm text-right"
      />
    </div>
  </div>

  <!-- Appointments Table -->
  <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse" id="appointments-table">
        <thead>
          <tr class="bg-gray-50 text-gray-400 text-xs font-bold border-b border-gray-100">
            <th class="p-4">المريض</th>
            <th class="p-4">رقم الهاتف</th>
            <th class="p-4">العيادة / القسم</th>
            <th class="p-4">الطبيب المعالج</th>
            <th class="p-4">التاريخ والوقت</th>
            <th class="p-4 text-center">النوع</th>
            <th class="p-4 text-center">الحالة</th>
            <th class="p-4 text-center">الخيارات</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
          <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr
              class="appointment-row hover:bg-gray-50 transition-colors"
              data-patient="<?php echo e($appt->patient_name); ?>"
              data-phone="<?php echo e($appt->phone); ?>"
              data-doctor="<?php echo e($appt->doctor); ?>"
              data-dept="<?php echo e($appt->department); ?>"
            >
              <td class="p-4 font-bold text-gray-800"><?php echo e($appt->patient_name); ?></td>
              <td class="p-4 text-gray-600 font-mono" dir="ltr"><?php echo e($appt->phone); ?></td>
              <td class="p-4 text-gray-600"><?php echo e($appt->department); ?></td>
              <td class="p-4 text-primary-700 font-medium"><?php echo e($appt->doctor); ?></td>
              <td class="p-4 text-gray-700">
                <span class="font-bold"><?php echo e($appt->date->format('Y-m-d')); ?></span>
                <span class="text-xs text-gray-400 font-mono block mt-0.5"><?php echo e($appt->time); ?></span>
              </td>
              <td class="p-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                  <?php echo e($appt->type); ?>

                </span>
              </td>
              <td class="p-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold border <?php echo e($statusColors[$appt->status] ?? ''); ?>">
                  <?php echo e($statusLabels[$appt->status] ?? $appt->status); ?>

                </span>
              </td>
              <td class="p-4">
                <div class="flex items-center justify-center gap-2">
                  
                  <!-- Quick Actions -->
                  <?php if($appt->status === 'pending'): ?>
                    <form action="<?php echo e(route('admin.appointments.updateStatus', $appt->id)); ?>" method="POST" class="inline-block">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PUT'); ?>
                      <input type="hidden" name="status" value="confirmed">
                      <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors cursor-pointer" title="تأكيد الموعد">
                        <i data-lucide="check" class="w-4 h-4"></i>
                      </button>
                    </form>
                  <?php endif; ?>

                  <?php if($appt->status === 'confirmed'): ?>
                    <form action="<?php echo e(route('admin.appointments.updateStatus', $appt->id)); ?>" method="POST" class="inline-block">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PUT'); ?>
                      <input type="hidden" name="status" value="completed">
                      <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors cursor-pointer" title="إتمام الموعد">
                        <i data-lucide="check-square" class="w-4 h-4"></i>
                      </button>
                    </form>
                  <?php endif; ?>

                  <?php if($appt->status !== 'cancelled' && $appt->status !== 'completed'): ?>
                    <form action="<?php echo e(route('admin.appointments.updateStatus', $appt->id)); ?>" method="POST" class="inline-block">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PUT'); ?>
                      <input type="hidden" name="status" value="cancelled">
                      <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 transition-colors cursor-pointer" title="إلغاء الموعد" onclick="return confirm('هل أنت متأكد من إلغاء هذا الحجز؟');">
                        <i data-lucide="x" class="w-4 h-4"></i>
                      </button>
                    </form>
                  <?php endif; ?>

                  <!-- Edit -->
                  <button
                    onclick="openEditModal(<?php echo e($appt->id); ?>, '<?php echo e(addslashes($appt->patient_name)); ?>', '<?php echo e($appt->phone); ?>', '<?php echo e(addslashes($appt->department)); ?>', '<?php echo e(addslashes($appt->doctor)); ?>', '<?php echo e($appt->date->format('Y-m-d')); ?>', '<?php echo e($appt->time); ?>', '<?php echo e($appt->status); ?>', '<?php echo e(addslashes($appt->type)); ?>', '<?php echo e(addslashes($appt->notes)); ?>', '<?php echo e($appt->offer_id); ?>')"
                    class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer"
                    title="تعديل تفاصيل"
                  >
                    <i data-lucide="edit" class="w-4 h-4"></i>
                  </button>

                  <!-- Delete -->
                  <form action="<?php echo e(route('admin.appointments.destroy', $appt->id)); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحجز نهائياً؟');" class="inline-block">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors cursor-pointer" title="حذف">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="8" class="p-16 text-center text-gray-400">
                <i data-lucide="calendar" class="mx-auto mb-4 opacity-30 w-16 h-16"></i>
                <p>لا توجد حجوزات مسجلة حالياً</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Create Appointment Modal -->
  <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">حجز موعد جديد</h3>
      </div>
      
      <form action="<?php echo e(route('admin.appointments.store')); ?>" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المريض</label>
            <input type="text" name="patient_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="محمد أحمد" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">رقم الهاتف</label>
            <input type="text" name="phone" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="050XXXXXXXX" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">القسم الطبي</label>
            <select name="department" id="create-department-select" required onchange="updateCreateDoctors()" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <option value="">اختر القسم</option>
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الطبيب</label>
            <select name="doctor" id="create-doctor-select" disabled required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed">
              <option value="">يرجى اختيار القسم أولاً</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التاريخ</label>
            <input type="date" name="date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الوقت</label>
            <input type="text" name="time" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="10:30 ص" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">نوع الموعد</label>
            <input type="text" name="type" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="استشارة / متابعة" value="استشارة" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">معرف العرض (اختياري)</label>
            <input type="text" name="offer_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="OFFER-100" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الحالة</label>
          <select name="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
            <?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($status); ?>"><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">ملاحظات إضافية</label>
          <textarea name="notes" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 h-20" placeholder="أي تفاصيل أو ملاحظات عن حالة المريض..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ الحجز</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Appointment Modal -->
  <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-scale-in text-right">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <h3 class="text-xl font-bold text-gray-800">تعديل بيانات الحجز</h3>
      </div>
      
      <form id="edit-form" action="" method="POST" class="p-6 space-y-4 text-gray-700">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">اسم المريض</label>
            <input type="text" name="patient_name" id="edit-patient-name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">رقم الهاتف</label>
            <input type="text" name="phone" id="edit-phone" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">القسم الطبي</label>
            <select name="department" id="edit-department" required onchange="updateEditDoctors()" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->name); ?>"><?php echo e($dept->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الطبيب</label>
            <select name="doctor" id="edit-doctor" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <!-- populated dynamically -->
            </select>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">التاريخ</label>
            <input type="date" name="date" id="edit-date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">الوقت</label>
            <input type="text" name="time" id="edit-time" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">نوع الموعد</label>
            <input type="text" name="type" id="edit-type" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">معرف العرض (اختياري)</label>
            <input type="text" name="offer_id" id="edit-offer-id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">الحالة</label>
          <select name="status" id="edit-status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none">
            <?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($status); ?>"><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 mb-2">ملاحظات إضافية</label>
          <textarea name="notes" id="edit-notes" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none h-20"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
          <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg cursor-pointer">حفظ التعديلات</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function filterAppointments() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const rows = document.querySelectorAll('.appointment-row');
      
      rows.forEach(row => {
        const patient = row.getAttribute('data-patient').toLowerCase();
        const phone = row.getAttribute('data-phone').toLowerCase();
        const doctor = row.getAttribute('data-doctor').toLowerCase();
        const dept = row.getAttribute('data-dept').toLowerCase();
        
        if (patient.includes(query) || phone.includes(query) || doctor.includes(query) || dept.includes(query)) {
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

    function openEditModal(id, patientName, phone, department, doctor, date, time, status, type, notes, offerId) {
      const form = document.getElementById('edit-form');
      form.action = `/admin/appointments/${id}`;
      
      document.getElementById('edit-patient-name').value = patientName;
      document.getElementById('edit-phone').value = phone;
      document.getElementById('edit-department').value = department;
      document.getElementById('edit-doctor').value = doctor;
      document.getElementById('edit-date').value = date;
      document.getElementById('edit-time').value = time;
      document.getElementById('edit-status').value = status;
      document.getElementById('edit-type').value = type;
      document.getElementById('edit-notes').value = notes;
      document.getElementById('edit-offer-id').value = offerId;
      
      document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('edit-modal').classList.add('hidden');
    }

    const allDoctorsList = <?php echo json_encode($doctors, 15, 512) ?>;

    function updateCreateDoctors() {
      const deptSelect = document.getElementById('create-department-select');
      const docSelect = document.getElementById('create-doctor-select');
      const selectedDept = deptSelect.value;

      if (!selectedDept) {
        docSelect.disabled = true;
        docSelect.innerHTML = '<option value="">يرجى اختيار القسم أولاً</option>';
        return;
      }

      docSelect.disabled = false;
      docSelect.innerHTML = '<option value="">اختر الطبيب</option>';

      const filteredDocs = allDoctorsList.filter(d => d.department === selectedDept);
      if (filteredDocs.length === 0) {
        docSelect.innerHTML = '<option value="">لا يوجد أطباء في هذا القسم</option>';
        docSelect.disabled = true;
        return;
      }

      filteredDocs.forEach(doc => {
        const opt = document.createElement('option');
        opt.value = doc.name;
        opt.textContent = `${doc.name} (${doc.specialty})`;
        docSelect.appendChild(opt);
      });
    }

    function updateEditDoctors(preSelectedDoctor = null) {
      const deptSelect = document.getElementById('edit-department');
      const docSelect = document.getElementById('edit-doctor');
      const selectedDept = deptSelect.value;

      docSelect.innerHTML = '<option value="">اختر الطبيب</option>';
      docSelect.disabled = false;

      const filteredDocs = allDoctorsList.filter(d => d.department === selectedDept);
      
      filteredDocs.forEach(doc => {
        const opt = document.createElement('option');
        opt.value = doc.name;
        opt.textContent = `${doc.name} (${doc.specialty})`;
        if (preSelectedDoctor === doc.name) {
          opt.selected = true;
        }
        docSelect.appendChild(opt);
      });
    }

    // Override openEditModal to handle the doctor list
    const originalOpenEditModal = openEditModal;
    openEditModal = function(id, patientName, phone, department, doctor, date, time, status, type, notes, offerId) {
      originalOpenEditModal(id, patientName, phone, department, doctor, date, time, status, type, notes, offerId);
      
      document.getElementById('edit-department').value = department;
      updateEditDoctors(doctor); // This will update the doctor list based on the department and select the current doctor
    };
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/admin/appointments/index.blade.php ENDPATH**/ ?>