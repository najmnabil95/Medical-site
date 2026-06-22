<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return response()->json(News::orderBy('date', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable',
            'category' => 'required',
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'nullable',
            'date' => 'required|date',
            'author' => 'required',
            'read_time' => 'required',
            'category_color' => 'required',
            'featured' => 'boolean',
        ]);

        return response()->json(News::create($validated), 201);
    }

    public function show($id)
    {
        return response()->json(News::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());
        return response()->json($news);
    }

    public function destroy($id)
    {
        News::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
