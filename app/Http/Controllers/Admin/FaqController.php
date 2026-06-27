<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('id', 'desc')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:1000',
            'answer' => 'required|string|max:2000',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'تم إنشاء السؤال الشائع بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'question' => 'required|string|max:1000',
            'answer' => 'required|string|max:2000',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'تم تحديث السؤال الشائع بنجاح.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'تم حذف السؤال الشائع بنجاح.');
    }
}
