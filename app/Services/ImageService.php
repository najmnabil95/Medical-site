<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * ImageService - خدمة مركزية لمعالجة الصور ورفعها وحذفها.
 *
 * تُوفر هذه الخدمة واجهة موحدة لكل عمليات الصور في المشروع،
 * بما يشمل الرفع والتخزين وحذف الصور القديمة ومعالجة أيقونة المتصفح (Favicon).
 */
class ImageService
{
    /**
     * رفع صورة جديدة وتخزينها في القرص العام.
     *
     * @param  Request  $request   كائن الطلب الحالي.
     * @param  string   $fieldName اسم حقل الملف في النموذج (مثل 'logo', 'image').
     * @param  string   $folder    المجلد الفرعي للتخزين (مثل 'uploads', 'doctors').
     * @return string|null         المسار النسبي للصورة المرفوعة، أو null إذا لم يُرفع ملف.
     */
    public function upload(Request $request, string $fieldName, string $folder = 'uploads'): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $path = $request->file($fieldName)->store($folder, 'public');

        return 'storage/' . $path;
    }

    /**
     * حذف صورة قديمة من قرص التخزين العام.
     *
     * يتحقق أولاً من أن الصورة مُخزنة محلياً (وليست رابطاً خارجياً)
     * قبل محاولة الحذف لتجنب أخطاء الملفات غير الموجودة.
     *
     * @param  string|null  $currentValue  القيمة الحالية المخزنة في قاعدة البيانات.
     * @param  string       $storageMarker جزء من المسار يُحدد أن الملف محلي (مثل 'storage/uploads').
     * @return void
     */
    public function deleteOldImage(?string $currentValue, string $storageMarker = 'storage/'): void
    {
        if (empty($currentValue)) {
            return;
        }

        if (!str_contains($currentValue, $storageMarker)) {
            return;
        }

        $relativePath = str_replace('storage/', '', $currentValue);
        $relativePath = ltrim($relativePath, '/');

        Storage::disk('public')->delete($relativePath);
    }

    /**
     * معالجة صورة أيقونة المتصفح (Favicon) بإعادة تحجيمها وإضافة خلفية وإطار.
     *
     * تقوم بقراءة الصورة المرفوعة، وتحويلها إلى مربع 128×128 بكسل
     * مع خلفية بيضاء وهوامش داخلية (12px) وإطار رمادي خفيف.
     *
     * @param  string  $physicalPath  المسار الفعلي الكامل للصورة على القرص.
     * @return bool    true إذا تمت المعالجة بنجاح، false إذا فشلت.
     */
    public function processFavicon(string $physicalPath): bool
    {
        if (!file_exists($physicalPath)) {
            return false;
        }

        try {
            $info = getimagesize($physicalPath);
            if (!$info) {
                return false;
            }

            $src = $this->createImageFromMime($info['mime'], $physicalPath);
            if (!$src) {
                return false;
            }

            $targetSize = 128;
            $padding = 12;
            $maxSize = $targetSize - ($padding * 2);

            $srcWidth = imagesx($src);
            $srcHeight = imagesy($src);

            // حساب أبعاد الصورة المقصوصة مع الحفاظ على نسبة العرض إلى الارتفاع
            if ($srcWidth > $srcHeight) {
                $dstWidth = $maxSize;
                $dstHeight = (int) round(($srcHeight / $srcWidth) * $maxSize);
            } else {
                $dstHeight = $maxSize;
                $dstWidth = (int) round(($srcWidth / $srcHeight) * $maxSize);
            }

            $dst = imagecreatetruecolor($targetSize, $targetSize);

            // ملء الخلفية بالأبيض
            $white = imagecolorallocate($dst, 255, 255, 255);
            imagefill($dst, 0, 0, $white);

            // توسيط الصورة داخل المربع
            $dstX = (int) round(($targetSize - $dstWidth) / 2);
            $dstY = (int) round(($targetSize - $dstHeight) / 2);

            imagecopyresampled($dst, $src, $dstX, $dstY, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight);

            // رسم إطار رمادي خفيف
            $borderColor = imagecolorallocate($dst, 226, 232, 240);
            imagerectangle($dst, 0, 0, $targetSize - 1, $targetSize - 1, $borderColor);

            imagepng($dst, $physicalPath);
            imagedestroy($src);
            imagedestroy($dst);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * إنشاء مورد صورة GD من ملف بناءً على نوع MIME.
     *
     * @param  string       $mime      نوع MIME للصورة (مثل 'image/png').
     * @param  string       $path      المسار الفعلي للصورة.
     * @return \GdImage|false          مورد صورة GD أو false إذا كان النوع غير مدعوم.
     */
    private function createImageFromMime(string $mime, string $path): \GdImage|false
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
            'image/png'               => imagecreatefrompng($path),
            'image/webp'              => imagecreatefromwebp($path),
            'image/gif'               => imagecreatefromgif($path),
            default                   => false,
        };
    }
}
