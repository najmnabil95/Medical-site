<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'desc',
        'color',
        'number',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
