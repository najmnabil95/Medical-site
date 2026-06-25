<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'color' => 'required|string|max:255',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
            $validated['avatar'] = asset('storage/' . $avatarPath);
        } else {
            $validated['avatar'] = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=250&q=80'; // fallback avatar
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'تم إضافة رأي المريض بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'color' => 'required|string|max:255',
        ]);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar && str_contains($testimonial->avatar, 'storage/testimonials')) {
                $oldPath = str_replace(asset('storage/'), '', $testimonial->avatar);
                Storage::disk('public')->delete($oldPath);
            }
            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
            $validated['avatar'] = asset('storage/' . $avatarPath);
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'تم تحديث رأي المريض بنجاح.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->avatar && str_contains($testimonial->avatar, 'storage/testimonials')) {
            $oldPath = str_replace(asset('storage/'), '', $testimonial->avatar);
            Storage::disk('public')->delete($oldPath);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'تم حذف رأي المريض بنجاح.');
    }
}
