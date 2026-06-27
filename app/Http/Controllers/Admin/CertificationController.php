<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::orderBy('id', 'desc')->get();
        return view('admin.certifications.index', compact('certifications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:500',
            'desc' => 'required|string|max:1000',
            'year' => 'required|string|max:50',
            'color' => 'required|string|max:255',
            'border' => 'required|string|max:255',
            'bg' => 'required|string|max:255',
        ]);

        Certification::create($validated);

        return redirect()->route('admin.certifications.index')->with('success', 'تم إضافة شهادة الاعتماد بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $certification = Certification::findOrFail($id);

        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:500',
            'desc' => 'required|string|max:1000',
            'year' => 'required|string|max:50',
            'color' => 'required|string|max:255',
            'border' => 'required|string|max:255',
            'bg' => 'required|string|max:255',
        ]);

        $certification->update($validated);

        return redirect()->route('admin.certifications.index')->with('success', 'تم تحديث شهادة الاعتماد بنجاح.');
    }

    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();

        return redirect()->route('admin.certifications.index')->with('success', 'تم حذف شهادة الاعتماد بنجاح.');
    }
}
