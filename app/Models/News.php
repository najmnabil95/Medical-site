<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'image',
        'category',
        'title',
        'excerpt',
        'content',
        'date',
        'author',
        'read_time',
        'category_color',
        'featured',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'date' => 'date',
    ];
}
