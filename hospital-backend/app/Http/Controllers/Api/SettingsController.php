<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getPublic()
    {
        $settings = Setting::first();
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'sometimes|string|max:255',
            'site_name_en' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:50',
            'phone_en' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|max:255',
            'address' => 'sometimes|string|max:500',
            'city' => 'sometimes|string|max:255',
            'emergency' => 'sometimes|string|max:50',
            'whatsapp' => 'sometimes|string|max:50',
            'facebook' => 'sometimes|string|max:500',
            'twitter' => 'sometimes|string|max:500',
            'instagram' => 'sometimes|string|max:500',
            'youtube' => 'sometimes|string|max:500',
            'linkedin' => 'sometimes|string|max:500',
            'snapchat' => 'sometimes|string|max:500',
        ]);

        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }
        $settings->fill($validated);
        $settings->save();
        return response()->json($settings);
    }
}
