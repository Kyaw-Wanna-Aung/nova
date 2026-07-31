<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // 1. Admin Login Form (Blade View ပြသရန်)
    public function showLoginForm()
    {
        return view('admin.login'); // resources/views/admin/login.blade.php
    }

    // 2. Admin Login (Session ဖြင့် Login ဝင်ခြင်း)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Session ဖြင့် Login ဝင်ရန် ကြိုးစားခြင်း
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                             ->with('success', 'Admin အကောင့်သို့ အောင်မြင်စွာ ဝင်ရောက်ပြီးပါပြီ။');
        }

        return back()->withErrors([
            'email' => 'ပေးပို့ထားသော အချက်အလက်များ မမှန်ကန်ပါ။',
        ])->onlyInput('email');
    }

    // 3. Register New Admin Form (Blade View ပြသရန်)
    public function showRegisterForm()
    {
        return view('admin.register'); // resources/views/admin/register.blade.php
    }

    // 4. Register New Admin (Admin အသစ် ဆောက်ခြင်း)
    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:admins',
            'phone'    => 'required|string|max:20|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Admin အသစ် အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။');
    }

    // 5. Admin Profile (Blade View)
    public function me()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    // 6. Admin Logout (Session ဖျက်ပြီး ထွက်ခြင်း)
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
                         ->with('success', 'အကောင့်မှ အောင်မြင်စွာ ထွက်ပြီးပါပြီ။');
    }
}