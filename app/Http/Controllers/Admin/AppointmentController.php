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

        if (auth()->user()->hasRole('Nurse')) {
            $assignedDoctors = auth()->user()->assigned_doctors ?? [];
            $query->whereIn('doctor', $assignedDoctors);
        }

        if ($tab === 'today') {
            $query->today();
        } elseif ($tab === 'pending') {
            $query->pending();
        }

        $appointments = $query->get();
        
        $todayRemainingQuery = Appointment::today()->whereIn('status', ['pending', 'confirmed']);
        if (auth()->user()->hasRole('Nurse')) {
            $assignedDoctors = auth()->user()->assigned_doctors ?? [];
            $todayRemainingQuery->whereIn('doctor', $assignedDoctors);
        }
        $todayRemaining = $todayRemainingQuery->count();

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

        // Check for double booking conflict
        $conflictExists = Appointment::where('doctor', $request->doctor)
            ->whereDate('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflictExists) {
            return redirect()->back()->withInput()->withErrors(['doctor' => 'عذراً، هذا الطبيب لديه حجز آخر في نفس التاريخ والوقت المحددين.']);
        }

        if (auth()->user()->hasRole('Nurse')) {
            $assignedDoctors = auth()->user()->assigned_doctors ?? [];
            if (!in_array($request->doctor, $assignedDoctors)) {
                return redirect()->back()->withInput()->withErrors(['doctor' => 'غير مصرح لك بجدولة مواعيد لهذا الطبيب.']);
            }
        }

        Appointment::create($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'تم إنشاء الحجز بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if (auth()->user()->hasRole('Nurse')) {
            $assignedDoctors = auth()->user()->assigned_doctors ?? [];
            if (!in_array($appointment->doctor, $assignedDoctors)) {
                abort(403, 'غير مصرح لك بتعديل هذا الحجز.');
            }
            if ($appointment->doctor !== $request->doctor || $appointment->department !== $request->department) {
                abort(403, 'غير مصرح للممرض بتغيير الطبيب أو القسم الخاص بالحجز.');
            }
        }

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

        // Check for double booking conflict excluding current appointment
        $conflictExists = Appointment::where('doctor', $request->doctor)
            ->whereDate('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $id)
            ->exists();

        if ($conflictExists) {
            return redirect()->back()->withInput()->withErrors(['doctor' => 'عذراً، هذا الطبيب لديه حجز آخر في نفس التاريخ والوقت المحددين.']);
        }

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'تم تحديث الحجز بنجاح.');
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if (auth()->user()->hasRole('Nurse')) {
            $assignedDoctors = auth()->user()->assigned_doctors ?? [];
            if (!in_array($appointment->doctor, $assignedDoctors)) {
                abort(403, 'غير مصرح لك بتحديث حالة هذا الحجز.');
            }
        }

        $status = $request->get('status');
        
        if (in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $appointment->update(['status' => $status]);
        }
        
        return redirect()->back()->with('success', 'تم تحديث حالة الحجز بنجاح.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (auth()->user()->hasRole('Nurse')) {
            abort(403, 'غير مصرح للممرضين بحذف الحجوزات.');
        }

        $appointment->delete();

        return redirect()->back()->with('success', 'تم حذف الحجز بنجاح.');
    }
}
