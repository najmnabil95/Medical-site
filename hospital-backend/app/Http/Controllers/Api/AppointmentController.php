<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required',
            'phone' => 'required',
            'department' => 'required',
            'doctor' => 'nullable',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'sometimes|in:normal,offer,consultation',
            'offer_id' => 'nullable',
            'notes' => 'nullable',
        ]);

        $validated['status'] = 'pending';
        return response()->json(Appointment::create($validated), 201);
    }

    public function show($id)
    {
        return response()->json(Appointment::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $validated = $request->validate([
            'patient_name' => 'sometimes',
            'phone' => 'sometimes',
            'department' => 'sometimes',
            'doctor' => 'nullable',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable',
        ]);

        $appointment->update($validated);
        return response()->json($appointment);
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
