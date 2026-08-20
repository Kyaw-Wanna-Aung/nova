<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthUserController extends Controller
{
    // ၁။ User Management Page ကိုပြရန် (Search, Role Filter နှင့် Pagination ပါဝင်သည်)
    public function index(Request $request)
    {
        $query = AuthUser::with(['roles', 'permissions']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($request->filled('role')) {
            $query->role($request->input('role'));
        }

        // Pagination (တစ်မျက်နှာကို 10 ခုပြရန်)
        $users = $query->paginate(10)->withQueryString();
        
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.index', compact('users', 'roles', 'permissions'));
    }

    // ၂။ User အသစ်ဆောက်ပြီး Spatie Role ထည့်ခြင်း
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:150|unique:auth_user',
            'email' => 'required|email|max:254|unique:auth_user',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        $user = AuthUser::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => 1,
            'date_joined' => now(),
        ]);

        $user->assignRole($validated['role']);

        return back()->with('success', 'User created successfully!');
    }

    // ၃။ User အချက်အလက်များကို ပြင်ဆင်ခြင်း (Update)
    public function updateUser(Request $request, AuthUser $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:150|unique:auth_user,username,' . $user->id,
            'email' => 'required|email|max:254|unique:auth_user,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Role ကို အသစ်လဲပေးခြင်း
        $user->syncRoles([$validated['role']]);

        return back()->with('success', 'User updated successfully!');
    }

    // ၄။ User ကို ဖျက်ခြင်း (Delete)
    public function destroyUser(AuthUser $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    // ၅။ Role အသစ်ဆောက်ခြင်း
    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        
        Role::create(['name' => $request->name]);

        return back()->with('success', 'Role created successfully!');
    }

    // ၆။ Role ကို Permission တွေ ပေးခြင်း (Group Permissions)
    public function assignPermissions(Request $request)
    {
        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Group permissions updated successfully!');
    }

    // ၇။ Individual User ကို တိုက်ရိုက် Permission တွေ ပေးခြင်း
    public function updateUserPermissions(Request $request, AuthUser $user)
    {
        $user->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'User permissions updated successfully!');
    }
}