<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Message extends Model
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
                return "تم إرسال رسالة تواصل جديدة من: {$this->name} بعنوان ({$this->subject})";
            case 'update':
                if ($this->isDirty('status')) {
                    $statusArabic = match($this->status) {
                        'new' => 'جديدة',
                        'read' => 'مقروءة',
                        'replied' => 'تم الرد عليها',
                        default => $this->status
                    };
                    return "تم تغيير حالة رسالة المريض {$this->name} إلى ({$statusArabic})";
                }
                return "تم تعديل بيانات رسالة التواصل من: {$this->name}";
            case 'delete':
                return "تم حذف رسالة تواصل من: {$this->name}";
            default:
                return "عملية {$type} على رسالة تواصل من: {$this->name}";
        }
    }

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'reply',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
