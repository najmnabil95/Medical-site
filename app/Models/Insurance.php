<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Insurance extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'abbr',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
