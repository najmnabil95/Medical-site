<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

/**
 * ActivityLogController - متحكم إدارة واستعراض سجلات النشاطات.
 *
 * يتيح لـ Super Admin فقط استعراض سجلات التغييرات وعمليات تسجيل الدخول والخروج،
 * مع إمكانية إفراغ السجل بالكامل.
 */
class ActivityLogController extends Controller
{
    /**
     * عرض سجل النشاطات مرتباً تنازلياً مع الترقيم.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $logs = ActivityLog::orderBy('timestamp', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.activity-logs.index', compact('logs'));
    }

    /**
     * مسح السجل بالكامل من قاعدة البيانات.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAll()
    {
        ActivityLog::truncate();

        return redirect()->route('admin.activity-logs.index')->with('success', 'تم مسح سجل النشاطات بالكامل بنجاح.');
    }
}
