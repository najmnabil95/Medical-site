<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = [
        'name',
        'component',
        'enabled',
        'order',
        'icon',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'order' => 'integer',
    ];
}
