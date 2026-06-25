<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all'); // default tab

        $query = Appointment::orderBy('date', 'asc')->orderBy('time', 'asc');

        if ($tab === 'today') {
            $query->today();
        } elseif ($tab === 'pending') {
            $query->pending();
        }

        $appointments = $query->get();
        
        $todayRemaining = Appointment::today()->whereIn('status', ['pending', 'confirmed'])->count();

        return view('admin.appointments.index', compact('appointments', 'tab', 'todayRemaining'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'department' => 'required|string|max:255',
            'doctor' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'type' => 'required|string|max:255',
            'offer_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        Appointment::create($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'تم إنشاء الحجز بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'department' => 'required|string|max:255',
            'doctor' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'type' => 'required|string|max:255',
            'offer_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'تم تحديث الحجز بنجاح.');
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $status = $request->get('status');
        
        if (in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $appointment->update(['status' => $status]);
        }
        
        return redirect()->back()->with('success', 'تم تحديث حالة الحجز بنجاح.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->back()->with('success', 'تم حذف الحجز بنجاح.');
    }
}
