<?php $__env->startSection('title', 'إعدادات الموقع - لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
  <!-- Header -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 text-right">
    <div>
      <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2 justify-end">
        <i data-lucide="settings" class="w-7 h-7 text-primary-600"></i>
        <span>إعدادات الموقع العامة</span>
      </h1>
      <p class="text-gray-500 text-sm mt-1">تعديل الشعار، اسم الموقع، معلومات الاتصال، وروابط التواصل الاجتماعي</p>
    </div>
  </div>

  <!-- Info Box -->
  <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-3 text-right">
    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
      <i data-lucide="info" class="text-blue-600 w-5.5 h-5.5"></i>
    </div>
    <div>
      <p class="font-bold text-blue-700 mb-1">تعليمات هامة</p>
      <ul class="text-sm text-blue-600 space-y-1">
        <li>• هذه الإعدادات تنعكس بشكل فوري على الموقع الرئيسي وجميع النماذج والـ Navbar.</li>
        <li>• للحفاظ على أفضل مظهر للمستشفى، يرجى استخدام صور شعار (Logo) ذات خلفية شفافة ومربعة.</li>
        <li>• لا تنسَ النقر على زر "حفظ التغييرات" بالأسفل بعد الانتهاء من التعديل.</li>
      </ul>
    </div>
  </div>

  <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6 text-right">
    <?php echo csrf_field(); ?>

    <div class="grid lg:grid-cols-2 gap-6">
      
      <!-- Box 1: Site Identity & Assets -->
      <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
          <h3 class="font-bold text-gray-800 flex items-center gap-2 justify-end">
            <i data-lucide="globe" class="w-5 h-5 text-gray-400"></i>
            <span>هوية الموقع والشعارات</span>
          </h3>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">اسم الموقع (بالعربية) <span class="text-red-500">*</span></label>
              <input type="text" name="site_name" value="<?php echo e(old('site_name', $settings->site_name)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">اسم الموقع (بالإنجليزية) <span class="text-red-500">*</span></label>
              <input type="text" name="site_name_en" value="<?php echo e(old('site_name_en', $settings->site_name_en)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">وصف الموقع التعريفي</label>
            <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none resize-none"><?php echo e(old('description', $settings->description)); ?></textarea>
          </div>

          <!-- Logo Upload -->
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">شعار المستشفى (Logo)</label>
            <div class="flex items-center gap-4 justify-start">
              <div id="logo-preview-container" class="w-18 h-18 border border-gray-200 rounded-xl flex items-center justify-center overflow-hidden bg-white shadow-sm shrink-0 p-1.5">
                <?php if(!empty($settings->logo)): ?>
                   <?php if(str_starts_with($settings->logo, 'http') || str_starts_with($settings->logo, 'data:')): ?>
                    <img id="logo-preview" src="<?php echo e($settings->logo); ?>" alt="Logo" class="w-full h-full object-contain" />
                  <?php else: ?>
                    <span class="text-3xl font-bold text-primary-600"><?php echo e($settings->logo); ?></span>
                  <?php endif; ?>
                <?php else: ?>
                  <i id="logo-preview-icon" data-lucide="image" class="text-gray-300 w-8 h-8"></i>
                <?php endif; ?>
              </div>
              <div class="flex-1 space-y-2">
                <input type="file" name="logo" id="logo-file-input" accept="image/*" class="hidden" onchange="previewSelectedImage(event, 'logo-preview')" />
                <label for="logo-file-input" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-600 rounded-xl text-sm font-bold hover:bg-primary-100 transition-all cursor-pointer">
                  <i data-lucide="upload" class="w-4 h-4"></i>
                  <span>رفع صورة شعار جديدة</span>
                </label>
                <p class="text-xs text-gray-400">يدعم صيغ JPG, PNG, WEBP, SVG حتى 5MB</p>
              </div>
            </div>
          </div>

          <!-- Favicon Upload -->
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">أيقونة المتصفح (Favicon)</label>
            <div class="flex items-center gap-4 justify-start">
              <div id="favicon-preview-container" class="w-12 h-12 border border-gray-200 rounded-xl flex items-center justify-center overflow-hidden bg-gray-50 shrink-0">
                <?php if(!empty($settings->favicon)): ?>
                  <img id="favicon-preview" src="<?php echo e($settings->favicon); ?>" alt="Favicon" class="w-full h-full object-cover" />
                <?php else: ?>
                  <i id="favicon-preview-icon" data-lucide="image" class="text-gray-300 w-6 h-6"></i>
                <?php endif; ?>
              </div>
              <div class="flex-1 space-y-2">
                <input type="file" name="favicon" id="favicon-file-input" accept="image/*" class="hidden" onchange="previewSelectedImage(event, 'favicon-preview')" />
                <label for="favicon-file-input" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-600 rounded-xl text-sm font-bold hover:bg-primary-100 transition-all cursor-pointer">
                  <i data-lucide="upload" class="w-4 h-4"></i>
                  <span>رفع أيقونة جديدة</span>
                </label>
                <p class="text-xs text-gray-400">يفضل أن تكون بصيغة ICO أو PNG وبمقاس 32x32 أو 64x64</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Box 2: Contacts & Address -->
      <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
          <h3 class="font-bold text-gray-800 flex items-center gap-2 justify-end">
            <i data-lucide="phone" class="w-5 h-5 text-gray-400"></i>
            <span>معلومات الاتصال والوصول</span>
          </h3>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف الرئيسي <span class="text-red-500">*</span></label>
              <input type="text" name="phone" value="<?php echo e(old('phone', $settings->phone)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="+966 12 345 6789" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم خدمة العملاء (المختصر)</label>
              <input type="text" name="phone_en" value="<?php echo e(old('phone_en', $settings->phone_en)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="920012345" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم الطوارئ السريع <span class="text-red-500">*</span></label>
              <input type="text" name="emergency" value="<?php echo e(old('emergency', $settings->emergency)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم الواتساب (دون ترميز +) <span class="text-red-500">*</span></label>
              <input type="text" name="whatsapp" value="<?php echo e(old('whatsapp', $settings->whatsapp)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="966123456789" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني الرسمي <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="<?php echo e(old('email', $settings->email)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="info@alshifa.com" />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">العنوان والشارع <span class="text-red-500">*</span></label>
              <input type="text" name="address" value="<?php echo e(old('address', $settings->address)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">المدينة والدولة <span class="text-red-500">*</span></label>
              <input type="text" name="city" value="<?php echo e(old('city', $settings->city)); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">رابط الخريطة الجغرافية (جوجل ماب Embed) - اختياري</label>
            <input type="text" name="map_link" value="<?php echo e(old('map_link', $settings->map_link)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="https://www.google.com/maps/embed?pb=..." />
            <p class="text-xs text-gray-400 mt-1">إذا لم تقم بوضع رابط مخصص، فسيقوم النظام بتوليد خريطة تلقائية بناءً على العنوان والمدينة أعلاه.</p>
          </div>
        </div>
      </div>

    </div>

    <!-- Box 3: Social Media Links -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800 flex items-center gap-2 justify-end">
          <i data-lucide="share-2" class="w-5 h-5 text-gray-400"></i>
          <span>حسابات التواصل الاجتماعي</span>
        </h3>
      </div>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط فيسبوك (Facebook)</label>
          <input type="text" name="facebook" value="<?php echo e(old('facebook', $settings->facebook)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط تويتر/إكس (Twitter/X)</label>
          <input type="text" name="twitter" value="<?php echo e(old('twitter', $settings->twitter)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط انستغرام (Instagram)</label>
          <input type="text" name="instagram" value="<?php echo e(old('instagram', $settings->instagram)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط يوتيوب (YouTube)</label>
          <input type="text" name="youtube" value="<?php echo e(old('youtube', $settings->youtube)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط لينكد إن (LinkedIn)</label>
          <input type="text" name="linkedin" value="<?php echo e(old('linkedin', $settings->linkedin)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط سناب شات (Snapchat)</label>
          <input type="text" name="snapchat" value="<?php echo e(old('snapchat', $settings->snapchat)); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
      </div>
    </div>

    <!-- Actions Save Buttons -->
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
      <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">تراجع</a>
      <button type="submit" class="px-8 py-3 bg-gradient-to-l from-emerald-500 to-emerald-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-emerald-500/25 transition-all hover:-translate-y-0.5 cursor-pointer">
        حفظ التغييرات
      </button>
    </div>

  </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  function previewSelectedImage(event, previewId) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const container = document.getElementById(previewId + '-container');
        if (container) {
          container.innerHTML = `<img id="${previewId}" src="${e.target.result}" alt="Preview" class="w-full h-full object-cover" />`;
        }
      };
      reader.readAsDataURL(file);
    }
  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-hospital-website-development\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>