<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Certification extends Model
{
    use LogsActivity;

    protected $fillable = [
        'icon',
        'name',
        'full_name',
        'desc',
        'year',
        'color',
        'border',
        'bg',
    ];
}
