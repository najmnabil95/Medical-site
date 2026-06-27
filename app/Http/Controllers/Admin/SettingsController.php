<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_name_en' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'phone_en' => 'nullable|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'emergency' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:50',
            'facebook' => 'nullable|string|max:500',
            'twitter' => 'nullable|string|max:500',
            'instagram' => 'nullable|string|max:500',
            'youtube' => 'nullable|string|max:500',
            'linkedin' => 'nullable|string|max:500',
            'snapchat' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico,svg,webp|max:2048',
        ]);

        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }

        // Handle file uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && str_contains($settings->logo, 'storage/uploads')) {
                $oldPath = str_replace(asset('storage/'), '', $settings->logo);
                Storage::disk('public')->delete($oldPath);
            }
            $logoPath = $request->file('logo')->store('uploads', 'public');
            $validated['logo'] = asset('storage/' . $logoPath);
        }

        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon && str_contains($settings->favicon, 'storage/uploads')) {
                $oldPath = str_replace(asset('storage/'), '', $settings->favicon);
                Storage::disk('public')->delete($oldPath);
            }
            $faviconPath = $request->file('favicon')->store('uploads', 'public');
            $validated['favicon'] = asset('storage/' . $faviconPath);
        }

        $settings->fill($validated);
        $settings->save();

        return redirect()->route('admin.settings.index')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
