<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getPublic()
    {
        $settings = \App\Models\Setting::first();
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $settings = \App\Models\Setting::first();
        if (!$settings) {
            $settings = new \App\Models\Setting();
        }
        $settings->fill($request->all());
        $settings->save();
        return response()->json($settings);
    }
}
