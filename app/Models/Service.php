<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Service extends Model
{
    use LogsActivity;

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
