<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * DoctorController - متحكم إدارة بيانات الأطباء.
 *
 * يتعامل مع عرض وإضافة وتعديل وحذف سجلات الأطباء
 * من لوحة تحكم الإدارة. يتطلب صلاحية Editor أو أعلى.
 */
class DoctorController extends Controller
{
    /**
     * عرض قائمة جميع الأطباء.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $doctors = Doctor::orderBy('id', 'desc')->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * حفظ سجل طبيب جديد.
     *
     * @param  Request  $request  بيانات الطبيب الجديد.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'rating' => 'required|numeric|min:1|max:5',
            'experience' => 'required|integer|min:0',
            'patients' => 'required|integer|min:0',
            'gradient' => 'required|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctors', 'public');
            $validated['image'] = asset('storage/' . $imagePath);
        } else {
            $validated['image'] = 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80'; // fallback doctor avatar
        }

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'تم إضافة الطبيب بنجاح.');
    }

    /**
     * تحديث بيانات طبيب موجود.
     *
     * @param  Request  $request  البيانات المعدلة.
     * @param  int      $id       معرف الطبيب.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'rating' => 'required|numeric|min:1|max:5',
            'experience' => 'required|integer|min:0',
            'patients' => 'required|integer|min:0',
            'gradient' => 'required|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        if ($request->hasFile('image')) {
            // Delete old image if it's in local storage
            if ($doctor->image && str_contains($doctor->image, 'storage/doctors')) {
                $oldPath = str_replace(asset('storage/'), '', $doctor->image);
                Storage::disk('public')->delete($oldPath);
            }
            $imagePath = $request->file('image')->store('doctors', 'public');
            $validated['image'] = asset('storage/' . $imagePath);
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'تم تحديث بيانات الطبيب بنجاح.');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        if ($doctor->image && str_contains($doctor->image, 'storage/doctors')) {
            $oldPath = str_replace(asset('storage/'), '', $doctor->image);
            Storage::disk('public')->delete($oldPath);
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'تم حذف الطبيب بنجاح.');
    }
}
