<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Partner extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'sub',
        'emoji',
    ];
}
