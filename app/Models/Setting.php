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
        'logo',
        'favicon',
        'description',
        'map_link',
        'hero_image_1',
        'hero_image_2',
        'hero_image_3',
        'hero_overlay_opacity',
    ];

    public $timestamps = false;

    public function getLogoAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getFaviconAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getHeroImage1Attribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getHeroImage2Attribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getHeroImage3Attribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }
}
