<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Department extends Model
{
    use LogsActivity;

    protected $fillable = [
        'icon',
        'name',
        'desc',
        'color',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
