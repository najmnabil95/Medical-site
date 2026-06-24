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

        // Prepare data for bookings chart (last 30 days)
        $chartData = Appointment::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();
        $chartLabels = $chartData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();
        $chartCounts = $chartData->pluck('count')->toArray();
        $stats['chart_labels'] = $chartLabels;
        $stats['chart_counts'] = $chartCounts;

        return view('admin.dashboard', compact('stats'));
    }
}
