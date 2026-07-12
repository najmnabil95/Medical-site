<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Doctor extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'specialty',
        'description',
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
