<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Screen extends Model
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
        switch ($type) {
            case 'create':
                return "تم إضافة قسم عرض جديد: {$this->name} ({$this->component})";
            case 'update':
                if ($this->isDirty('enabled')) {
                    $state = $this->enabled ? 'تفعيل' : 'تعطيل';
                    return "تم ({$state}) قسم العرض: {$this->name}";
                }
                return "تم تعديل بيانات قسم العرض: {$this->name}";
            case 'delete':
                return "تم حذف قسم العرض: {$this->name}";
            default:
                return "عملية {$type} على قسم العرض: {$this->name}";
        }
    }

    protected $fillable = [
        'name',
        'component',
        'enabled',
        'order',
        'icon',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'order' => 'integer',
    ];
}
