<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', 'desc')->get();
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:1000',
            'content' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'read_time' => 'required|string|max:50',
            'category_color' => 'required|string|max:255',
            'featured' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $validated['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = asset('storage/' . $imagePath);
        } else {
            $validated['image'] = 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80'; // fallback cover image
        }

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'تم نشر الخبر بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $newsItem = News::findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:1000',
            'content' => 'required|string',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'read_time' => 'required|string|max:50',
            'category_color' => 'required|string|max:255',
            'featured' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $validated['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            // Delete old image if it exists in public storage
            if ($newsItem->image && str_contains($newsItem->image, 'storage/news')) {
                $oldPath = str_replace(asset('storage/'), '', $newsItem->image);
                Storage::disk('public')->delete($oldPath);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = asset('storage/' . $imagePath);
        }

        $newsItem->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'تم تحديث الخبر بنجاح.');
    }

    public function destroy($id)
    {
        $newsItem = News::findOrFail($id);

        if ($newsItem->image && str_contains($newsItem->image, 'storage/news')) {
            $oldPath = str_replace(asset('storage/'), '', $newsItem->image);
            Storage::disk('public')->delete($oldPath);
        }

        $newsItem->delete();

        return redirect()->route('admin.news.index')->with('success', 'تم حذف الخبر بنجاح.');
    }
}
