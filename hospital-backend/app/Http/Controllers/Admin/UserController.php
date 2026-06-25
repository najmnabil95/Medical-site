<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,name',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'active' => 'sometimes|boolean',
            'assigned_departments' => 'nullable|array',
            'assigned_doctors' => 'nullable|array',
        ]);

        $validated['active'] = $request->has('active');
        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Protect admin account from critical modifications
        if ($user->hasRole('Super Admin') || $user->username === 'admin') {
            if ($request->has('active') && !$request->boolean('active')) {
                return back()->with('error', 'لا يمكن إيقاف حساب مدير النظام.');
            }
            if ($request->filled('phone') && $request->input('phone') !== $user->phone) {
                return back()->with('error', 'لا يمكن تغيير رقم هاتف مدير النظام.');
            }
            if ($request->filled('role') && $request->input('role') !== 'Super Admin') {
                return back()->with('error', 'لا يمكن تغيير صلاحيات مدير النظام.');
            }
        }

        $validated = $request->validate([
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|exists:roles,name',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'active' => 'sometimes|boolean',
            'assigned_departments' => 'nullable|array',
            'assigned_doctors' => 'nullable|array',
        ]);

        $validated['active'] = $request->has('active');

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->hasRole('Super Admin') || $user->username === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكن حذف حساب مدير النظام.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
