<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('id', 'desc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'color' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'تم إنشاء الخدمة بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'color' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة بنجاح.');
    }
}
