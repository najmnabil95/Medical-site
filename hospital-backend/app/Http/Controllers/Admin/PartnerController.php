<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('id', 'desc')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sub' => 'required|string|max:255',
            'emoji' => 'required|string|max:255',
        ]);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'تم إضافة شريك النجاح بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sub' => 'required|string|max:255',
            'emoji' => 'required|string|max:255',
        ]);

        $partner->update($validated);

        return redirect()->route('admin.partners.index')->with('success', 'تم تحديث بيانات شريك النجاح بنجاح.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'تم حذف شريك النجاح بنجاح.');
    }
}
