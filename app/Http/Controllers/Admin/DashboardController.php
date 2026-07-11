<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        if ($user && $user->hasRole('Doctor')) {
            return redirect()->route('doctor.appointments.index');
        }

        if ($user && $user->hasRole('Nurse')) {
            return redirect()->route('admin.appointments.index');
        }

        $stats = [
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'today_appointments' => Appointment::whereDate('created_at', today())->count(),
            'total_doctors' => Doctor::where('active', true)->count(),
            'total_departments' => Department::where('active', true)->count(),
            'total_users' => User::count(),
            'unread_messages' => Message::where('status', 'new')->count(),
            'recent_appointments' => Appointment::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        // Prepare data for bookings chart (last 30 days) using Collection grouping to avoid ONLY_FULL_GROUP_BY errors
        $appointmentsLast30Days = Appointment::where('created_at', '>=', now()->subDays(30))->get();
        
        $chartData = $appointmentsLast30Days->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function ($group) {
            return $group->count();
        })->sortKeys();

        $chartLabels = $chartData->keys()->map(function($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();
        $chartCounts = $chartData->values()->toArray();
        
        $stats['chart_labels'] = $chartLabels;
        $stats['chart_counts'] = $chartCounts;

        return view('admin.dashboard', compact('stats'));
    }
}
