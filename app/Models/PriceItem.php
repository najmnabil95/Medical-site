<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceItem extends Model
{
    protected $fillable = [
        'service',
        'category',
        'price',
        'price_to',
        'currency',
        'duration',
        'description',
        'active',
    ];

    protected $casts = [
        'price' => 'float',
        'price_to' => 'float',
        'active' => 'boolean',
    ];
}
