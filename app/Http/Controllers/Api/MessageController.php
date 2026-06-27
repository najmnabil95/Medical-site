<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return response()->json(Message::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $validated['status'] = 'new';
        return response()->json(Message::create($validated), 201);
    }

    public function show($id)
    {
        return response()->json(Message::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $validated = $request->validate([
            'status' => 'sometimes|in:new,read,replied',
            'reply' => 'nullable',
        ]);

        $message->update($validated);
        return response()->json($message);
    }

    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
