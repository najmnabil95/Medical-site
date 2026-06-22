<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return response()->json(Doctor::where('active', true)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'specialty' => 'required',
            'department' => 'required',
            'image' => 'nullable',
            'rating' => 'numeric|min:0|max:5',
            'experience' => 'required',
            'patients' => 'nullable',
            'gradient' => 'required',
            'active' => 'boolean',
        ]);

        return response()->json(Doctor::create($validated), 201);
    }

    public function show($id)
    {
        return response()->json(Doctor::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());
        return response()->json($doctor);
    }

    public function destroy($id)
    {
        Doctor::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
