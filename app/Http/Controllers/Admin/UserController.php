<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * UserController - متحكم إدارة مستخدمي النظام.
 *
 * يتعامل مع إنشاء وتعديل وحذف حسابات المستخدمين
 * وإسناد الأدوار لهم. يتطلب صلاحية Super Admin أو Manager.
 */
class UserController extends Controller
{
    /**
     * عرض قائمة مستخدمي النظام مع الأدوار المتاحة.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * إنشاء حساب مستخدم جديد مع تشفير كلمة المرور.
     *
     * @param  Request  $request  بيانات المستخدم الجديد.
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * تحديث بيانات مستخدم موجود مع حماية حساب المدير العام.
     *
     * @param  Request  $request  البيانات المعدلة.
     * @param  int      $id       معرف المستخدم.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();

        // 1. Prevent users from editing their own accounts
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'لا يمكنك تعديل حسابك الشخصي من هنا.');
        }

        // 2. Protect Super Admin account from modifications
        if ($user->hasRole('Super Admin') || $user->username === 'admin') {
            // Only another Super Admin can edit a Super Admin account
            if (!$currentUser->hasRole('Super Admin')) {
                return back()->with('error', 'لا يمكنك تعديل بيانات مدير النظام.');
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

    /**
     * حذف حساب مستخدم مع منع حذف الحساب الشخصي وحساب المدير.
     *
     * @param  int  $id  معرف المستخدم المراد حذفه.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();

        // Prevent users from deleting their own accounts
        if ($currentUser->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكنك حذف حسابك الشخصي.');
        }
        
        if ($user->hasRole('Super Admin') || $user->username === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكن حذف حساب مدير النظام.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
