<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(Notification::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:sms,whatsapp,email,internal',
            'recipient' => 'required',
            'message' => 'required',
            'reservation_id' => 'nullable',
            'patient_name' => 'nullable',
        ]);

        $validated['status'] = 'pending';
        $notification = Notification::create($validated);
        return response()->json($notification, 201);
    }

    public function destroy($id)
    {
        Notification::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
