@extends('layouts.admin')

@section('title', 'إعدادات الموقع - لوحة التحكم')

@section('content')
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

  <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-right">
    @csrf

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
              <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">اسم الموقع (بالإنجليزية) <span class="text-red-500">*</span></label>
              <input type="text" name="site_name_en" value="{{ old('site_name_en', $settings->site_name_en) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">وصف الموقع التعريفي</label>
            <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none resize-none">{{ old('description', $settings->description) }}</textarea>
          </div>

          <!-- Logo Upload -->
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">شعار المستشفى (Logo)</label>
            <div class="flex items-center gap-4 justify-start">
              <div id="logo-preview-container" class="w-18 h-18 border border-gray-200 rounded-xl flex items-center justify-center overflow-hidden bg-white shadow-sm shrink-0 p-1.5">
                @if(!empty($settings->logo))
                   @if(str_starts_with($settings->logo, 'http') || str_starts_with($settings->logo, 'data:'))
                    <img id="logo-preview" src="{{ $settings->logo }}" alt="Logo" class="w-full h-full object-contain" />
                  @else
                    <span class="text-3xl font-bold text-primary-600">{{ $settings->logo }}</span>
                  @endif
                @else
                  <i id="logo-preview-icon" data-lucide="image" class="text-gray-300 w-8 h-8"></i>
                @endif
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
                @if(!empty($settings->favicon))
                  <img id="favicon-preview" src="{{ $settings->favicon }}" alt="Favicon" class="w-full h-full object-cover" />
                @else
                  <i id="favicon-preview-icon" data-lucide="image" class="text-gray-300 w-6 h-6"></i>
                @endif
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

          <!-- Hero Images Upload -->
          <div class="border-t border-gray-100 pt-4 mt-4 space-y-4">
            <h4 class="font-bold text-gray-800 text-sm">صور واجهة الموقع الرئيسية (Slider Images)</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              @for($i = 1; $i <= 3; $i++)
                @php $fieldName = 'hero_image_' . $i; @endphp
                <div class="space-y-2">
                  <label class="block text-xs font-bold text-gray-500">الصورة {{ $i }}</label>
                  <div class="flex flex-col items-center gap-3">
                    <div id="hero_image_{{ $i }}-preview-container" class="w-full h-32 border border-gray-200 rounded-xl flex items-center justify-center overflow-hidden bg-gray-50 shadow-sm shrink-0">
                      @if(!empty($settings->$fieldName))
                        <img id="hero_image_{{ $i }}-preview" src="{{ $settings->$fieldName }}" alt="Hero Image {{ $i }}" class="w-full h-full object-cover" />
                      @else
                        <i id="hero_image_{{ $i }}-preview-icon" data-lucide="image" class="text-gray-300 w-8 h-8"></i>
                      @endif
                    </div>
                    <div class="w-full text-center">
                      <input type="file" name="hero_image_{{ $i }}" id="hero_image_{{ $i }}-file-input" accept="image/*" class="hidden" onchange="previewSelectedImage(event, 'hero_image_{{ $i }}-preview')" />
                      <label for="hero_image_{{ $i }}-file-input" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 bg-primary-50 text-primary-600 rounded-xl text-xs font-bold hover:bg-primary-100 transition-all cursor-pointer">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                        <span>اختر صورة {{ $i }}</span>
                      </label>
                    </div>
                  </div>
                </div>
              @endfor
            </div>
          </div>
          
          <!-- Hero Overlay Opacity -->
          <div class="border-t border-gray-100 pt-4 mt-4 space-y-2">
            <label class="block text-sm font-bold text-gray-700 mb-1">شفافية غطاء الصورة الخلفية للواجهة (Background Overlay Opacity)</label>
            <div class="flex items-center gap-4">
              <input type="range" name="hero_overlay_opacity" min="0" max="100" value="{{ old('hero_overlay_opacity', $settings->hero_overlay_opacity ?? 80) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600" oninput="updateOpacityLabel(this.value)" />
              <span id="opacity-label" class="text-sm font-bold text-gray-700 shrink-0">{{ old('hero_overlay_opacity', $settings->hero_overlay_opacity ?? 80) }}%</span>
            </div>
            <p class="text-xs text-gray-400">تتحكم هذه القيمة في مدى وضوح النص فوق الصورة الخلفية (0% شفاف تماماً، 100% غطاء صلب بلون الخلفية).</p>
          </div>

          <!-- Notification Channel Option -->
          <div class="border-t border-gray-100 pt-4 mt-4 space-y-2">
            <label class="block text-sm font-bold text-gray-700 mb-1">قناة الإشعارات المفضلة (Notification Channel)</label>
            <select name="notification_channel" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
              <option value="whatsapp" {{ old('notification_channel', $settings->notification_channel ?? 'whatsapp') === 'whatsapp' ? 'selected' : '' }}>واتساب فقط (WhatsApp Only)</option>
              <option value="sms" {{ old('notification_channel', $settings->notification_channel ?? 'whatsapp') === 'sms' ? 'selected' : '' }}>رسائل نصية فقط (SMS Only)</option>
              <option value="both" {{ old('notification_channel', $settings->notification_channel ?? 'whatsapp') === 'both' ? 'selected' : '' }}>كلاهما (Both WhatsApp & SMS)</option>
            </select>
            <p class="text-xs text-gray-400">القناة الافتراضية لإرسال إشعارات الحجز للمرضى عند تأكيد الموعد.</p>
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
              <input type="text" name="phone" value="{{ old('phone', $settings->phone) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="+966 12 345 6789" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم خدمة العملاء (المختصر)</label>
              <input type="text" name="phone_en" value="{{ old('phone_en', $settings->phone_en) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="920012345" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم الطوارئ السريع <span class="text-red-500">*</span></label>
              <input type="text" name="emergency" value="{{ old('emergency', $settings->emergency) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">رقم الواتساب (دون ترميز +) <span class="text-red-500">*</span></label>
              <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="966123456789" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني الرسمي <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $settings->email) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="info@alshifa.com" />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">العنوان والشارع <span class="text-red-500">*</span></label>
              <input type="text" name="address" value="{{ old('address', $settings->address) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
            </div>
            <div>
              <label class="block text-sm font-bold text-gray-700 mb-2">المدينة والدولة <span class="text-red-500">*</span></label>
              <input type="text" name="city" value="{{ old('city', $settings->city) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">رابط الخريطة الجغرافية (جوجل ماب Embed) - اختياري</label>
            <input type="text" name="map_link" value="{{ old('map_link', $settings->map_link) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" placeholder="https://www.google.com/maps/embed?pb=..." />
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
          <input type="text" name="facebook" value="{{ old('facebook', $settings->facebook) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط تويتر/إكس (Twitter/X)</label>
          <input type="text" name="twitter" value="{{ old('twitter', $settings->twitter) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط انستغرام (Instagram)</label>
          <input type="text" name="instagram" value="{{ old('instagram', $settings->instagram) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط يوتيوب (YouTube)</label>
          <input type="text" name="youtube" value="{{ old('youtube', $settings->youtube) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط لينكد إن (LinkedIn)</label>
          <input type="text" name="linkedin" value="{{ old('linkedin', $settings->linkedin) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
        <div>
          <label class="block text-sm font-bold text-gray-700 mb-2">رابط سناب شات (Snapchat)</label>
          <input type="text" name="snapchat" value="{{ old('snapchat', $settings->snapchat) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none" />
        </div>
      </div>
    </div>

    <!-- Actions Save Buttons -->
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
      <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">تراجع</a>
      <button type="submit" class="px-8 py-3 bg-gradient-to-l from-emerald-500 to-emerald-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-emerald-500/25 transition-all hover:-translate-y-0.5 cursor-pointer">
        حفظ التغييرات
      </button>
    </div>

  </form>
@endsection

@section('scripts')
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

  function updateOpacityLabel(val) {
    const label = document.getElementById('opacity-label');
    if (label) {
      label.textContent = val + '%';
    }
  }
</script>
@endsection
