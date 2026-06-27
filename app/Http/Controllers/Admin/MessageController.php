<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('id', 'desc')->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'status' => 'required|in:unread,read,replied',
            'reply' => 'nullable|string|max:2000',
        ]);

        Message::create($validated);

        return redirect()->route('admin.messages.index')->with('success', 'تم إنشاء الرسالة بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'status' => 'required|in:unread,read,replied',
            'reply' => 'nullable|string|max:2000',
        ]);

        // Auto transition status if a reply is filled
        if (!empty($validated['reply']) && $validated['status'] !== 'replied') {
            $validated['status'] = 'replied';
        }

        $message->update($validated);

        return redirect()->route('admin.messages.index')->with('success', 'تم تحديث حالة الرسالة بنجاح.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'تم حذف الرسالة بنجاح.');
    }
}
