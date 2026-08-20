<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ၁။ Role များ ဖန်တီးခြင်း
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);

        // ၂။ Admin User အသစ် တစ်ယောက် ဖန်တီးခြင်း
        $admin = AuthUser::create([
            'username' => 'superadmin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Password ကို password123 အဖြစ်ထားမည်
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'is_active' => 1,
            'date_joined' => now(),
        ]);

        // ၃။ ထို Admin User ကို 'admin' Role ပေးခြင်း
        $admin->assignRole($adminRole);
    }
}