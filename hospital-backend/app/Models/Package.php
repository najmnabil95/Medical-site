<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'price',
        'period',
        'icon',
        'popular',
        'gradient',
        'features',
        'active',
    ];

    protected $casts = [
        'popular' => 'boolean',
        'active' => 'boolean',
        'features' => 'array',
    ];
}
