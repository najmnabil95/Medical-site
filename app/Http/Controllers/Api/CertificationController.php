<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index()
    {
        return response()->json(Certification::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required',
            'name' => 'required',
            'full_name' => 'required',
            'desc' => 'required',
            'year' => 'required',
            'color' => 'required',
            'border' => 'required',
            'bg' => 'required',
        ]);

        return response()->json(Certification::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $cert = Certification::findOrFail($id);
        $cert->update($request->all());
        return response()->json($cert);
    }

    public function destroy($id)
    {
        Certification::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
