<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged in doctor's name
        // Assuming the user's name matches the doctor's name in the appointments table
        $doctorName = auth()->user()->name;

        $tab = $request->get('tab', 'today'); // default tab

        $query = Appointment::forDoctor($doctorName)->orderBy('date', 'asc')->orderBy('time', 'asc');

        if ($tab === 'today') {
            $query->today();
        } elseif ($tab === 'upcoming') {
            $query->upcoming();
        } elseif ($tab === 'past') {
            $query->past();
        }

        $appointments = $query->get();
        
        $todayRemaining = Appointment::forDoctor($doctorName)->today()->whereIn('status', ['pending', 'confirmed'])->count();

        return view('doctor.appointments.index', compact('appointments', 'tab', 'todayRemaining'));
    }

    public function updateStatus(Request $request, $id)
    {
        $doctorName = auth()->user()->name;
        $appointment = Appointment::forDoctor($doctorName)->findOrFail($id);
        
        $status = $request->get('status');
        
        // Doctors can usually only mark as completed or add notes
        if (in_array($status, ['completed'])) {
            $appointment->update(['status' => $status]);
        }
        
        if ($request->has('notes')) {
            $appointment->update(['notes' => $request->get('notes')]);
        }
        
        return redirect()->back()->with('success', 'تم التحديث بنجاح.');
    }
}
