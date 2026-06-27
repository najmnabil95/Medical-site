<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use App\Models\Message;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'today_appointments' => Appointment::whereDate('created_at', today())->count(),
            'total_doctors' => Doctor::where('active', true)->count(),
            'total_departments' => Department::where('active', true)->count(),
            'total_users' => User::count(),
            'unread_messages' => Message::where('status', 'new')->count(),
            'recent_appointments' => Appointment::orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }
}
