<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceItem;
use Illuminate\Http\Request;

class PriceItemController extends Controller
{
    public function index()
    {
        $prices = PriceItem::orderBy('id', 'desc')->get();
        return view('admin.prices.index', compact('prices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:50',
            'duration' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        PriceItem::create($validated);

        return redirect()->route('admin.prices.index')->with('success', 'تم إضافة البند المالي بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $priceItem = PriceItem::findOrFail($id);

        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:50',
            'duration' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'active' => 'sometimes|boolean',
        ]);

        $validated['active'] = $request->has('active');

        $priceItem->update($validated);

        return redirect()->route('admin.prices.index')->with('success', 'تم تحديث البند المالي بنجاح.');
    }

    public function destroy($id)
    {
        $priceItem = PriceItem::findOrFail($id);
        $priceItem->delete();

        return redirect()->route('admin.prices.index')->with('success', 'تم حذف البند المالي بنجاح.');
    }
}
