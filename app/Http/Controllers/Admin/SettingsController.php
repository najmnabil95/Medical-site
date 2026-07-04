<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\Request;

/**
 * SettingsController - متحكم إدارة إعدادات الموقع العامة.
 *
 * يتعامل مع عرض وتحديث إعدادات المستشفى الرئيسية
 * بما يشمل البيانات النصية والصور (الشعار، الأيقونة، صور الواجهة).
 * يتطلب صلاحية Super Admin للوصول.
 */
class SettingsController extends Controller
{
    /**
     * @param ImageService $imageService خدمة معالجة ورفع الصور.
     */
    public function __construct(
        private readonly ImageService $imageService
    ) {}

    /**
     * عرض صفحة إعدادات الموقع.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::first() ?? new Setting();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * تحديث إعدادات الموقع (نصوص وصور).
     *
     * @param  Request  $request  كائن الطلب يحتوي على البيانات المُحدّثة.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'            => 'required|string|max:255',
            'site_name_en'         => 'required|string|max:255',
            'phone'                => 'required|string|max:50',
            'phone_en'             => 'nullable|string|max:50',
            'email'                => 'required|email|max:255',
            'address'              => 'required|string|max:500',
            'city'                 => 'required|string|max:255',
            'emergency'            => 'required|string|max:50',
            'whatsapp'             => 'required|string|max:50',
            'facebook'             => 'nullable|string|max:500',
            'twitter'              => 'nullable|string|max:500',
            'instagram'            => 'nullable|string|max:500',
            'youtube'              => 'nullable|string|max:500',
            'linkedin'             => 'nullable|string|max:500',
            'snapchat'             => 'nullable|string|max:500',
            'description'          => 'nullable|string|max:1000',
            'map_link'             => 'nullable|string|max:1000',
            'logo'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'favicon'              => 'nullable|image|mimes:jpeg,png,jpg,gif,ico,svg,webp|max:2048',
            'hero_image_1'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'hero_image_2'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'hero_image_3'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_1'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_2'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_3'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_4'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'font_family'          => 'nullable|string|max:100',
            'hero_overlay_opacity' => 'nullable|integer|min:0|max:100',
            'notification_channel' => 'nullable|string|in:whatsapp,sms,both',
        ]);

        $settings = Setting::first() ?? new Setting();

        // رفع الشعار (Logo)
        $this->handleImageUpload($request, $validated, $settings, 'logo', 'uploads');

        // رفع ومعالجة الأيقونة (Favicon)
        $this->handleFaviconUpload($request, $validated, $settings);

        // رفع صور الواجهة الرئيسية (Hero Images 1-3)
        for ($i = 1; $i <= 3; $i++) {
            $this->handleImageUpload($request, $validated, $settings, "hero_image_{$i}", 'uploads');
        }

        // رفع صور قسم "من نحن" (About Images 1-4)
        for ($i = 1; $i <= 4; $i++) {
            $this->handleImageUpload($request, $validated, $settings, "about_image_{$i}", 'uploads');
        }

        $settings->fill($validated);
        $settings->save();

        return redirect()->route('admin.settings.index')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }

    /**
     * معالجة رفع صورة عادية: حذف القديمة ورفع الجديدة.
     *
     * @param  Request  $request    كائن الطلب.
     * @param  array    &$validated مصفوفة البيانات المُتحقق منها (تُعدّل بالمرجع).
     * @param  Setting  $settings   كائن الإعدادات الحالي.
     * @param  string   $fieldName  اسم حقل الصورة.
     * @param  string   $folder     المجلد الفرعي للتخزين.
     */
    private function handleImageUpload(Request $request, array &$validated, Setting $settings, string $fieldName, string $folder): void
    {
        if (!$request->hasFile($fieldName)) {
            return;
        }

        // حذف الصورة القديمة إن وُجدت
        $rawValue = $settings->getRawOriginal($fieldName) ?: $settings->$fieldName;
        $this->imageService->deleteOldImage($rawValue);

        // رفع الصورة الجديدة
        $validated[$fieldName] = $this->imageService->upload($request, $fieldName, $folder);
    }

    /**
     * معالجة رفع أيقونة المتصفح: حذف القديمة، رفع الجديدة، ثم معالجتها بصرياً.
     *
     * @param  Request  $request    كائن الطلب.
     * @param  array    &$validated مصفوفة البيانات المُتحقق منها (تُعدّل بالمرجع).
     * @param  Setting  $settings   كائن الإعدادات الحالي.
     */
    private function handleFaviconUpload(Request $request, array &$validated, Setting $settings): void
    {
        if (!$request->hasFile('favicon')) {
            return;
        }

        // حذف الأيقونة القديمة
        $rawValue = $settings->getRawOriginal('favicon') ?: $settings->favicon;
        $this->imageService->deleteOldImage($rawValue);

        // رفع الأيقونة الجديدة
        $newPath = $this->imageService->upload($request, 'favicon', 'uploads');
        $validated['favicon'] = $newPath;

        // معالجة الأيقونة (قص + خلفية بيضاء + إطار)
        $physicalPath = public_path($newPath);
        $this->imageService->processFavicon($physicalPath);
    }
}
