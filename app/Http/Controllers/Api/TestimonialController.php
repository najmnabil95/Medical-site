<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json(Testimonial::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'text' => 'required',
            'rating' => 'integer|min:1|max:5',
            'avatar' => 'required',
            'color' => 'required',
        ]);

        return response()->json(Testimonial::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($request->all());
        return response()->json($testimonial);
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
