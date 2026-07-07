<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Package extends Model
{
    use LogsActivity;

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
