<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, LogsActivity;

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
                return "تم إنشاء مستخدم جديد في النظام: {$this->name} ({$this->role})";
            case 'update':
                if ($this->isDirty('active')) {
                    $state = $this->active ? 'نشط' : 'غير نشط';
                    return "تم تغيير حالة حساب المستخدم {$this->name} إلى ({$state})";
                }
                return "تم تعديل بيانات المستخدم {$this->name}";
            case 'delete':
                return "تم حذف المستخدم {$this->name} من النظام";
            default:
                return "عملية {$type} على حساب المستخدم {$this->name}";
        }
    }


    protected $fillable = [
        'username',
        'password',
        'role',
        'name',
        'email',
        'phone',
        'active',
        'assigned_departments',
        'assigned_doctors',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'assigned_departments' => 'array',
        'assigned_doctors' => 'array',
    ];
}
