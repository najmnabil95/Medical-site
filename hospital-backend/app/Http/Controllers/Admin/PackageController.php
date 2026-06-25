<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('id', 'desc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'period' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'popular' => 'sometimes|boolean',
            'gradient' => 'required|string|max:255',
            'features_raw' => 'required|string',
            'active' => 'sometimes|boolean',
        ]);

        $validated['popular'] = $request->has('popular');
        $validated['active'] = $request->has('active');

        // Parse features line by line
        $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_raw']))));
        $validated['features'] = $features;

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'تم إنشاء باقة الكشف بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'period' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'popular' => 'sometimes|boolean',
            'gradient' => 'required|string|max:255',
            'features_raw' => 'required|string',
            'active' => 'sometimes|boolean',
        ]);

        $validated['popular'] = $request->has('popular');
        $validated['active'] = $request->has('active');

        $features = array_values(array_filter(array_map('trim', explode("\n", $validated['features_raw']))));
        $validated['features'] = $features;

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'تم تحديث باقة الكشف بنجاح.');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'تم حذف الباقة بنجاح.');
    }
}
