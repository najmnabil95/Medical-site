<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'site_name_en',
        'phone',
        'phone_en',
        'email',
        'address',
        'city',
        'emergency',
        'whatsapp',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'snapchat',
    ];

    public $timestamps = false;
}
