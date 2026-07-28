<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    // 1. Admin Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['ပေးပို့ထားသော အချက်အလက်များ မမှန်ကန်ပါ။'],
            ]);
        }

        // Sanctum Bearer Token ထုတ်ပေးခြင်း
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Admin အကောင့်သို့ အောင်မြင်စွာ ဝင်ရောက်ပြီးပါပြီ။',
            'token' => $token,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
            ]
        ], 200);
    }

    // 2. Register New Admin (Admin သာလျှင် Admin အသစ် ဆောက်ခွင့်ရှိမည်)
    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'phone' => 'required|string|max:20|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        $newAdmin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin အသစ် အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။',
            'data' => $newAdmin
        ], 201);
    }

    // 3. Get Logged in Admin Profile
    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'admin' => $request->user()
        ], 200);
    }

    // 4. Admin Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'အကောင့်မှ အောင်မြင်စွာ ထွက်ပြီးပါပြီ။'
        ], 200);
    }
}