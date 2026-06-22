<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialty',
        'department',
        'image',
        'rating',
        'experience',
        'patients',
        'gradient',
        'active',
    ];

    protected $casts = [
        'rating' => 'float',
        'active' => 'boolean',
    ];
}
