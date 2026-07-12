<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * ReportController - متحكم التقارير والإحصائيات المتقدمة.
 *
 * يعرض تقارير تفصيلية عن أداء المستشفى، الحجوزات، الأقسام، والأطباء.
 */
class ReportController extends Controller
{
    /**
     * عرض صفحة التقارير الشاملة.
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // default: last 30 days
        $startDate = now()->subDays((int) $period);
        $endDate = now();

        // ===== الإحصائيات العامة =====
        $totalAppointments = Appointment::count();
        $periodAppointments = Appointment::where('created_at', '>=', $startDate)->count();
        $completedAppointments = Appointment::where('status', 'completed')->where('created_at', '>=', $startDate)->count();
        $cancelledAppointments = Appointment::where('status', 'cancelled')->where('created_at', '>=', $startDate)->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->where('created_at', '>=', $startDate)->count();

        // ===== رسومات بيانية: الحجوزات اليومية =====
        $dailyAppointments = Appointment::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($a) => Carbon::parse($a->created_at)->format('Y-m-d'))
            ->map(fn($group) => $group->count())
            ->sortKeys();

        $dailyLabels = $dailyAppointments->keys()->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
        $dailyCounts = $dailyAppointments->values()->toArray();

        // ===== توزيع الحالات =====
        $statusDistribution = Appointment::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy('status')
            ->map(fn($group) => $group->count());

        // ===== الأقسام الأكثر طلباً =====
        $topDepartments = Appointment::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy('department')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(8);

        // ===== أداء الأطباء =====
        $doctorPerformance = Appointment::where('created_at', '>=', $startDate)
            ->whereNotNull('doctor')
            ->get()
            ->groupBy('doctor')
            ->map(function ($group) {
                return [
                    'total' => $group->count(),
                    'completed' => $group->where('status', 'completed')->count(),
                    'cancelled' => $group->where('status', 'cancelled')->count(),
                    'pending' => $group->where('status', 'pending')->count(),
                ];
            })
            ->sortByDesc('total')
            ->take(10);

        // ===== الحجوزات حسب نوع الكشف =====
        $typeDistribution = Appointment::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy('type')
            ->map(fn($group) => $group->count());

        // ===== ساعات الذروة =====
        $peakHours = Appointment::where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($a) => $a->time)
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(10);

        // ===== الرسائل الواردة =====
        $totalMessages = Message::where('created_at', '>=', $startDate)->count();
        $newMessages = Message::where('status', 'new')->where('created_at', '>=', $startDate)->count();

        return view('admin.reports.index', compact(
            'period',
            'totalAppointments',
            'periodAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'dailyLabels',
            'dailyCounts',
            'statusDistribution',
            'topDepartments',
            'doctorPerformance',
            'typeDistribution',
            'peakHours',
            'totalMessages',
            'newMessages'
        ));
    }
}
