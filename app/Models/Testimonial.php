<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Testimonial extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'role',
        'text',
        'rating',
        'avatar',
        'color',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];
}
