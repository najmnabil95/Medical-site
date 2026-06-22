<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
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
