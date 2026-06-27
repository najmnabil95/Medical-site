<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json(Partner::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'sub' => 'required',
            'emoji' => 'required',
        ]);

        return response()->json(Partner::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->update($request->all());
        return response()->json($partner);
    }

    public function destroy($id)
    {
        Partner::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
