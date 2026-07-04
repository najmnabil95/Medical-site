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
        'notification_channel',
        'about_image_1',
        'about_image_2',
        'about_image_3',
        'about_image_4',
        'font_family',
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

    public function getAboutImage1Attribute($value)
    {
        if (empty($value)) {
            return 'https://images.pexels.com/photos/20081928/pexels-photo-20081928.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=420&w=380';
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getAboutImage2Attribute($value)
    {
        if (empty($value)) {
            return 'https://images.pexels.com/photos/33216715/pexels-photo-33216715.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=320&w=380';
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getAboutImage3Attribute($value)
    {
        if (empty($value)) {
            return 'https://images.pexels.com/photos/4769133/pexels-photo-4769133.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=320&w=300';
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }

    public function getAboutImage4Attribute($value)
    {
        if (empty($value)) {
            return 'https://images.pexels.com/photos/33216690/pexels-photo-33216690.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=420&w=300';
        }
        if (str_starts_with($value, 'http') || str_starts_with($value, 'data:')) {
            return $value;
        }
        return asset($value);
    }
}
