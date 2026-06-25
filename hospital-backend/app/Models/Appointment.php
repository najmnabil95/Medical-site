<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
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
