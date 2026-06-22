<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PriceItem;
use Illuminate\Http\Request;

class PriceItemController extends Controller
{
    public function index()
    {
        return response()->json(PriceItem::where('active', true)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'price_to' => 'nullable|numeric',
            'currency' => 'required',
            'duration' => 'nullable',
            'description' => 'nullable',
            'active' => 'boolean',
        ]);

        return response()->json(PriceItem::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $priceItem = PriceItem::findOrFail($id);
        $priceItem->update($request->all());
        return response()->json($priceItem);
    }

    public function destroy($id)
    {
        PriceItem::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
