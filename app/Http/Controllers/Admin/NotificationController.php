<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::orderBy('created_at', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search in recipient, patient_name or message
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('recipient', 'like', "%{$search}%")
                  ->orWhere('patient_name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->paginate(15)->withQueryString();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'تم حذف سجل الإشعار بنجاح.');
    }

    public function clearAll()
    {
        Notification::truncate();

        return redirect()->back()->with('success', 'تم تفريغ سجل الإشعارات بالكامل.');
    }
}
