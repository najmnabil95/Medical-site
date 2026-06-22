<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'name',
        'abbr',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
