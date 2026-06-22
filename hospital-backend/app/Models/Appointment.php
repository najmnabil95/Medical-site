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
}
