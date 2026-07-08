<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Trait LogsActivity
 *
 * Provides automatic activity logging for Eloquent models.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @method static void created(\Closure $callback)
 * @method static void updated(\Closure $callback)
 * @method static void deleted(\Closure $callback)
 */
trait LogsActivity
{
    /**
     * Boot the trait to listen to Eloquent model events.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logAction($model, 'create');
        });

        static::updated(function ($model) {
            $dirty = $model->getDirty();
            unset($dirty['updated_at']);

            if (!empty($dirty)) {
                self::logAction($model, 'update');
            }
        });

        static::deleted(function ($model) {
            self::logAction($model, 'delete');
        });
    }

    /**
     * Log the action to the database.
     *
     * @param  mixed   $model
     * @param  string  $type
     */
    protected static function logAction($model, string $type)
    {
        try {
            $user = Auth::check() ? Auth::user()->name : 'زائر الموقع';

            $action = self::getActivityMessage($model, $type);

            ActivityLog::create([
                'action' => $action,
                'type' => $type,
                'user' => $user,
                'timestamp' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to write activity log: " . $e->getMessage());
        }
    }

    /**
     * Generate Arabic action description for the activity log.
     *
     * @param  mixed   $model
     * @param  string  $type
     * @return string
     */
    protected static function getActivityMessage($model, string $type): string
    {
        if (method_exists($model, 'toActivityLogMessage')) {
            return $model->toActivityLogMessage($type);
        }

        $modelName = self::getModelArabicName(class_basename($model));

        $nameField = $model->name ?? $model->title ?? $model->patient_name ?? $model->service ?? $model->username ?? $model->id;

        switch ($type) {
            case 'create':
                return "تم إضافة {$modelName} جديد: {$nameField}";
            case 'update':
                return "تم تعديل بيانات {$modelName}: {$nameField}";
            case 'delete':
                return "تم حذف {$modelName}: {$nameField}";
            default:
                return "عملية {$type} على {$modelName} المعرّف بـ: {$nameField}";
        }
    }

    /**
     * Translate model class names to reader-friendly Arabic terms.
     *
     * @param  string  $className
     * @return string
     */
    protected static function getModelArabicName(string $className): string
    {
        $map = [
            'Doctor'        => 'طبيب',
            'Department'    => 'قسم طبي',
            'Service'       => 'خدمة',
            'Package'       => 'باقة علاجية',
            'News'          => 'خبر',
            'Faq'           => 'سؤال شائع',
            'Testimonial'   => 'رأي مريض',
            'Partner'       => 'شريك نجاح',
            'Certification' => 'شهادة اعتماد',
            'PriceItem'     => 'بند تسعيرة',
            'Setting'       => 'إعدادات الموقع',
            'User'          => 'مستخدم نظام',
            'Appointment'   => 'حجز موعد',
            'Message'       => 'رسالة تواصل',
            'Screen'        => 'مكون شاشة',
            'Insurance'     => 'شركة تأمين',
        ];

        return $map[$className] ?? $className;
    }
}
