<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = [
        'name',
        'component',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
