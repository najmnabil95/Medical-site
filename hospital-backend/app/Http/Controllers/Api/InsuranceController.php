<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index()
    {
        return response()->json(Insurance::where('active', true)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'abbr' => 'required',
            'active' => 'boolean',
        ]);

        return response()->json(Insurance::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $insurance = Insurance::findOrFail($id);
        $insurance->update($request->all());
        return response()->json($insurance);
    }

    public function destroy($id)
    {
        Insurance::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
