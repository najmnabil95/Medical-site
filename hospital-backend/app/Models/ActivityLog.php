<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'action',
        'type',
        'user',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];
}
