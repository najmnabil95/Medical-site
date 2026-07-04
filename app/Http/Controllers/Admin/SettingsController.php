<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_name_en' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'phone_en' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'emergency' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:50',
            'facebook' => 'nullable|string|max:500',
            'twitter' => 'nullable|string|max:500',
            'instagram' => 'nullable|string|max:500',
            'youtube' => 'nullable|string|max:500',
            'linkedin' => 'nullable|string|max:500',
            'snapchat' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'map_link' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico,svg,webp|max:2048',
            'hero_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'hero_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'hero_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'about_image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'font_family' => 'nullable|string|max:100',
            'hero_overlay_opacity' => 'nullable|integer|min:0|max:100',
            'notification_channel' => 'nullable|string|in:whatsapp,sms,both',
        ]);

        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }

        // Handle file uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && (str_contains($settings->logo, 'storage/uploads') || str_contains($settings->logo, 'uploads/'))) {
                $rawLogo = $settings->getRawOriginal('logo') ?: $settings->logo;
                $oldPath = str_replace(asset('storage/'), '', $rawLogo);
                $oldPath = str_replace('storage/', '', $oldPath);
                $oldPath = ltrim($oldPath, '/');
                Storage::disk('public')->delete($oldPath);
            }
            $logoPath = $request->file('logo')->store('uploads', 'public');
            $validated['logo'] = 'storage/' . $logoPath;
        }

        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon && (str_contains($settings->favicon, 'storage/uploads') || str_contains($settings->favicon, 'uploads/'))) {
                $rawFavicon = $settings->getRawOriginal('favicon') ?: $settings->favicon;
                $oldPath = str_replace(asset('storage/'), '', $rawFavicon);
                $oldPath = str_replace('storage/', '', $oldPath);
                $oldPath = ltrim($oldPath, '/');
                Storage::disk('public')->delete($oldPath);
            }
            $faviconPath = $request->file('favicon')->store('uploads', 'public');
            $validated['favicon'] = 'storage/' . $faviconPath;

            // Process uploaded favicon image
            $fullPhysicalPath = public_path('storage/' . $faviconPath);
            if (file_exists($fullPhysicalPath)) {
                try {
                    $info = getimagesize($fullPhysicalPath);
                    if ($info) {
                        $mime = $info['mime'];
                        $src = null;
                        switch ($mime) {
                            case 'image/jpeg':
                            case 'image/jpg':
                                $src = imagecreatefromjpeg($fullPhysicalPath);
                                break;
                            case 'image/png':
                                $src = imagecreatefrompng($fullPhysicalPath);
                                break;
                            case 'image/webp':
                                $src = imagecreatefromwebp($fullPhysicalPath);
                                break;
                            case 'image/gif':
                                $src = imagecreatefromgif($fullPhysicalPath);
                                break;
                        }
                        if ($src) {
                            $srcWidth = imagesx($src);
                            $srcHeight = imagesy($src);
                            $targetSize = 128;
                            $dst = imagecreatetruecolor($targetSize, $targetSize);
                            $white = imagecolorallocate($dst, 255, 255, 255);
                            imagefill($dst, 0, 0, $white);
                            
                            $padding = 12;
                            $maxSize = $targetSize - ($padding * 2);
                            if ($srcWidth > $srcHeight) {
                                $dstWidth = $maxSize;
                                $dstHeight = round(($srcHeight / $srcWidth) * $maxSize);
                            } else {
                                $dstHeight = $maxSize;
                                $dstWidth = round(($srcWidth / $srcHeight) * $maxSize);
                            }
                            $dstX = round(($targetSize - $dstWidth) / 2);
                            $dstY = round(($targetSize - $dstHeight) / 2);
                            
                            imagecopyresampled($dst, $src, $dstX, $dstY, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
                            
                            $borderColor = imagecolorallocate($dst, 226, 232, 240);
                            imagerectangle($dst, 0, 0, $targetSize - 1, $targetSize - 1, $borderColor);
                            
                            imagepng($dst, $fullPhysicalPath);
                            imagedestroy($src);
                            imagedestroy($dst);
                        }
                    }
                } catch (\Exception $e) {
                    // Fail silently and keep original image if processing fails
                }
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            $fieldName = 'hero_image_' . $i;
            if ($request->hasFile($fieldName)) {
                // Delete old image if exists
                if ($settings->$fieldName && (str_contains($settings->$fieldName, 'storage/uploads') || str_contains($settings->$fieldName, 'uploads/'))) {
                    $rawImg = $settings->getRawOriginal($fieldName) ?: $settings->$fieldName;
                    $oldPath = str_replace(asset('storage/'), '', $rawImg);
                    $oldPath = str_replace('storage/', '', $oldPath);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('public')->delete($oldPath);
                }
                $imgPath = $request->file($fieldName)->store('uploads', 'public');
                $validated[$fieldName] = 'storage/' . $imgPath;
            }
        }

        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'about_image_' . $i;
            if ($request->hasFile($fieldName)) {
                // Delete old image if exists
                if ($settings->$fieldName && (str_contains($settings->$fieldName, 'storage/uploads') || str_contains($settings->$fieldName, 'uploads/'))) {
                    $rawImg = $settings->getRawOriginal($fieldName) ?: $settings->$fieldName;
                    $oldPath = str_replace(asset('storage/'), '', $rawImg);
                    $oldPath = str_replace('storage/', '', $oldPath);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('public')->delete($oldPath);
                }
                $imgPath = $request->file($fieldName)->store('uploads', 'public');
                $validated[$fieldName] = 'storage/' . $imgPath;
            }
        }

        $settings->fill($validated);
        $settings->save();

        return redirect()->route('admin.settings.index')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
