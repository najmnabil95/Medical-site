<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,doctor,nurse,reception,accountant',
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'active' => 'boolean',
            'assigned_departments' => 'nullable|array',
            'assigned_doctors' => 'nullable|array',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'sometimes|unique:users,username,' . $id,
            'password' => 'sometimes|min:6',
            'role' => 'sometimes|in:admin,doctor,nurse,reception,accountant',
            'name' => 'sometimes',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'active' => 'boolean',
            'assigned_departments' => 'nullable|array',
            'assigned_doctors' => 'nullable|array',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
