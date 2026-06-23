<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        return response()->json(Screen::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'component' => 'required',
            'enabled' => 'boolean',
            'order' => 'integer',
            'icon' => 'nullable|string',
        ]);

        return response()->json(Screen::create($validated), 201);
    }

    public function show($id)
    {
        return response()->json(Screen::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $screen = Screen::findOrFail($id);
        $screen->update($request->all());
        return response()->json($screen);
    }

    public function destroy($id)
    {
        Screen::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
