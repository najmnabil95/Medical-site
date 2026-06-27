<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        $screens = Screen::orderBy('order', 'asc')->get();
        return view('admin.screens.index', compact('screens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'component' => 'required|string|max:255',
            'enabled' => 'sometimes|boolean',
            'order' => 'required|integer|min:0',
            'icon' => 'required|string|max:255',
        ]);

        $validated['enabled'] = $request->has('enabled');

        Screen::create($validated);
        $this->reorderAll();

        return redirect()->route('admin.screens.index')->with('success', 'تم إضافة قسم العرض بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $screen = Screen::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'component' => 'required|string|max:255',
            'enabled' => 'sometimes|boolean',
            'order' => 'required|integer|min:0',
            'icon' => 'required|string|max:255',
        ]);

        $validated['enabled'] = $request->has('enabled');

        $screen->update($validated);

        return redirect()->route('admin.screens.index')->with('success', 'تم تحديث قسم العرض بنجاح.');
    }

    public function destroy($id)
    {
        $screen = Screen::findOrFail($id);
        $screen->delete();
        $this->reorderAll();

        return redirect()->route('admin.screens.index')->with('success', 'تم حذف قسم العرض بنجاح.');
    }

    public function moveUp($id)
    {
        $this->reorderAll();
        
        $screen = Screen::findOrFail($id);
        if ($screen->order > 1) {
            $previousScreen = Screen::where('order', $screen->order - 1)->first();
            if ($previousScreen) {
                $previousScreen->order = $screen->order;
                $previousScreen->save();
            }
            $screen->order = $screen->order - 1;
            $screen->save();
        }
        return redirect()->route('admin.screens.index')->with('success', 'تم تعديل ترتيب القسم للأعلى بنجاح.');
    }

    public function moveDown($id)
    {
        $this->reorderAll();
        
        $screen = Screen::findOrFail($id);
        $totalScreens = Screen::count();
        if ($screen->order < $totalScreens) {
            $nextScreen = Screen::where('order', $screen->order + 1)->first();
            if ($nextScreen) {
                $nextScreen->order = $screen->order;
                $nextScreen->save();
            }
            $screen->order = $screen->order + 1;
            $screen->save();
        }
        return redirect()->route('admin.screens.index')->with('success', 'تم تعديل ترتيب القسم للأسفل بنجاح.');
    }

    private function reorderAll()
    {
        $screens = Screen::orderBy('order', 'asc')->get();
        foreach ($screens as $index => $screen) {
            $screen->order = $index + 1;
            $screen->save();
        }
    }
}
