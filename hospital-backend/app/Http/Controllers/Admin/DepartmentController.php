<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('id', 'desc')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'color' => 'required|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        Department::create($validated);

        return redirect()->route('admin.departments.index')->with('success', 'تم إنشاء القسم الطبي بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'color' => 'required|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        $department->update($validated);

        return redirect()->route('admin.departments.index')->with('success', 'تم تحديث القسم الطبي بنجاح.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'تم حذف القسم الطبي بنجاح.');
    }
}
