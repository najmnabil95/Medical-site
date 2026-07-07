<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Appointment extends Model
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
                return "تم حجز موعد جديد للمريض {$this->patient_name} في عيادة {$this->department}";
            case 'update':
                if ($this->isDirty('status')) {
                    $statusArabic = match($this->status) {
                        'pending'   => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'cancelled' => 'ملغي',
                        'completed' => 'مكتمل',
                        default     => $this->status
                    };
                    return "تم تغيير حالة موعد المريض {$this->patient_name} إلى ({$statusArabic})";
                }
                return "تم تعديل بيانات موعد المريض {$this->patient_name}";
            case 'delete':
                return "تم حذف موعد المريض {$this->patient_name}";
            default:
                return "عملية {$type} على حجز موعد للمريض {$this->patient_name}";
        }
    }

    protected $fillable = [
        'patient_name',
        'phone',
        'department',
        'doctor',
        'date',
        'time',
        'status',
        'type',
        'offer_id',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function booted()
    {
        static::created(function ($appointment) {
            event(new \App\Events\AppointmentStatusChanged($appointment, null));
        });

        static::updated(function ($appointment) {
            if ($appointment->isDirty('status')) {
                event(new \App\Events\AppointmentStatusChanged($appointment, $appointment->getOriginal('status')));
            }
        });
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('date', '>', today());
    }

    public function scopePast($query)
    {
        return $query->whereDate('date', '<', today());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeForDoctor($query, $doctorName)
    {
        return $query->where('doctor', $doctorName);
    }
}
