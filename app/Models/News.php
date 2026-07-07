<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class News extends Model
{
    use LogsActivity;

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
