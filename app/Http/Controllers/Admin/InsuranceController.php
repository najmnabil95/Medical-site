<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::orderBy('id', 'desc')->get();
        return view('admin.insurances.index', compact('insurances'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbr' => 'required|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        Insurance::create($validated);

        return redirect()->route('admin.insurances.index')->with('success', 'تم إضافة شركة التأمين بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $insurance = Insurance::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbr' => 'required|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        $insurance->update($validated);

        return redirect()->route('admin.insurances.index')->with('success', 'تم تحديث شركة التأمين بنجاح.');
    }

    public function destroy($id)
    {
        $insurance = Insurance::findOrFail($id);
        $insurance->delete();

        return redirect()->route('admin.insurances.index')->with('success', 'تم حذف شركة التأمين بنجاح.');
    }
}
