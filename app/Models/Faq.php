<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Faq extends Model
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
        $shortQuestion = \Illuminate\Support\Str::limit($this->question, 40);
        switch ($type) {
            case 'create':
                return "تم إضافة سؤال شائع جديد: {$shortQuestion}";
            case 'update':
                return "تم تعديل السؤال الشائع: {$shortQuestion}";
            case 'delete':
                return "تم حذف السؤال الشائع: {$shortQuestion}";
            default:
                return "عملية {$type} على السؤال الشائع: {$shortQuestion}";
        }
    }

    protected $fillable = [
        'question',
        'answer',
    ];
}
