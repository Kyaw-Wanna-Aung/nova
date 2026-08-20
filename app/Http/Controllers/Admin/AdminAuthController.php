<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthUser; // Admin အစား AuthUser ကို သုံးရန်
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // 1. Admin Login Form (Blade View ပြသရန်)
    public function showLoginForm()
    {
        return view('admin.login'); 
    }

    // 2. Admin Login (Session ဖြင့် Login ဝင်ခြင်း)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Default guard ('web') သို့မဟုတ် auth_user ကို သုံး၍ ဝင်ခြင်း
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
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
        return view('admin.register'); 
    }

    // 4. Register New Admin (Admin အသစ် ဆောက်ခြင်း)
    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:150|unique:auth_user',
            'email'    => 'required|string|email|max:254|unique:auth_user',
            'password' => 'required|string|min:6',
        ]);

        AuthUser::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => 1,
            'date_joined' => now(),
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Admin အသစ် အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။');
    }

    // 5. Admin Profile (Blade View)
    public function me()
    {
        $admin = Auth::guard('web')->user();
        return view('admin.profile', compact('admin'));
    }

    // 6. Admin Logout (Session ဖျက်ပြီး ထွက်ခြင်း)
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
                         ->with('success', 'အကောင့်မှ အောင်မြင်စွာ ထွက်ပြီးပါပြီ။');
    }
}