<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

/**
 * Setting - نموذج إعدادات الموقع العامة.
 *
 * يُخزن جميع البيانات القابلة للتخصيص من لوحة التحكم مثل
 * اسم الموقع، بيانات التواصل، مسارات الصور، والخطوط.
 * يستخدم جدولاً واحداً بصف واحد (Singleton Pattern).
 *
 * @property string|null $site_name      اسم الموقع بالعربية.
 * @property string|null $site_name_en   اسم الموقع بالإنجليزية.
 * @property string|null $phone          رقم الهاتف الرئيسي.
 * @property string|null $email          البريد الإلكتروني.
 * @property string|null $logo           مسار شعار الموقع.
 * @property string|null $favicon        مسار أيقونة المتصفح.
 * @property string|null $font_family    اسم خط Google Fonts المختار.
 */
class Setting extends Model
{
    use LogsActivity;

    /**
     * Customize the activity log message for this model.
     *
     * @param  string  $type
     * @return string
     */
    public function toActivityLogMessage(string $type): string
    {
        return "تم تحديث إعدادات الموقع العامة";
    }

    /**
     * مفتاح تخزين الكاش لـ إعدادات الموقع.
     */
    public const CACHE_KEY = 'site_settings';

    protected $fillable = [
        'site_name',
        'site_name_en',
        'phone',
        'phone_en',
        'email',
        'address',
        'city',
        'emergency',
        'whatsapp',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'snapchat',
        'logo',
        'favicon',
        'description',
        'map_link',
        'hero_image_1',
        'hero_image_2',
        'hero_image_3',
        'hero_overlay_opacity',
        'notification_channel',
        'about_image_1',
        'about_image_2',
        'about_image_3',
        'about_image_4',
        'font_family',
    ];

    public $timestamps = false;

    /**
     * تهيئة النموذج لإضافة مستمعين لأحداث حفظ وحذف النموذج لمسح الكاش تلقائياً.
     */
    protected static function booted()
    {
        static::saved(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }

    /**
     * الحصول على الإعدادات بشكل مخبأ (Cached) لتقليل الضغط على قاعدة البيانات.
     *
     * @return self
     */
    public static function getCached(): self
    {
        return \Illuminate\Support\Facades\Cache::rememberForever(self::CACHE_KEY, function () {
            return self::first() ?? new self();
        });
    }

    /**
     * مسح كاش الإعدادات يدوياً أو برمجياً عند التعديل.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        \Illuminate\Support\Facades\Cache::forget(self::CACHE_KEY);
    }

    /**
     * القيم الافتراضية لصور قسم "من نحن" عند عدم رفع صور مخصصة.
     */
    private const ABOUT_IMAGE_DEFAULTS = [
        'about_image_1' => 'https://images.pexels.com/photos/20081928/pexels-photo-20081928.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=420&w=380',
        'about_image_2' => 'https://images.pexels.com/photos/33216715/pexels-photo-33216715.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=320&w=380',
        'about_image_3' => 'https://images.pexels.com/photos/4769133/pexels-photo-4769133.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=320&w=300',
        'about_image_4' => 'https://images.pexels.com/photos/33216690/pexels-photo-33216690.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=420&w=300',
    ];

    // ─── Accessors (موحّدة عبر دالة resolveAssetUrl) ─────────────────

    public function getLogoAttribute($value)
    {
        return $this->resolveAssetUrl($value);
    }

    public function getFaviconAttribute($value)
    {
        return $this->resolveAssetUrl($value);
    }

    public function getHeroImage1Attribute($value)
    {
        return $this->resolveAssetUrl($value);
    }

    public function getHeroImage2Attribute($value)
    {
        return $this->resolveAssetUrl($value);
    }

    public function getHeroImage3Attribute($value)
    {
        return $this->resolveAssetUrl($value);
    }

    public function getAboutImage1Attribute($value)
    {
        return $this->resolveAssetUrl($value, self::ABOUT_IMAGE_DEFAULTS['about_image_1']);
    }

    public function getAboutImage2Attribute($value)
    {
        return $this->resolveAssetUrl($value, self::ABOUT_IMAGE_DEFAULTS['about_image_2']);
    }

    public function getAboutImage3Attribute($value)
    {
        return $this->resolveAssetUrl($value, self::ABOUT_IMAGE_DEFAULTS['about_image_3']);
    }

    public function getAboutImage4Attribute($value)
    {
        return $this->resolveAssetUrl($value, self::ABOUT_IMAGE_DEFAULTS['about_image_4']);
    }

    // ─── Private Helpers ─────────────────────────────────────────────

    /**
     * تحويل مسار الصورة المخزنة إلى رابط URL كامل.
     *
     * - إذا كانت القيمة فارغة → يُرجع القيمة الافتراضية (أو null).
     * - إذا كانت القيمة رابطاً خارجياً (http/data:) → يُرجعها كما هي.
     * - إذا كانت مساراً نسبياً → يُحولها إلى رابط كامل عبر asset().
     *
     * @param  string|null  $value    القيمة المخزنة في قاعدة البيانات.
     * @param  string|null  $default  القيمة الافتراضية عند الفراغ.
     * @return string|null
     */
    private function resolveAssetUrl(?string $value, ?string $default = null): ?string
    {
        if (empty($value)) {
            return $default;
        }

        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }

        return asset($value);
    }
}
