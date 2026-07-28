<?php

namespace Database\Seeders;
use App\Models\HeroBanner;
use App\Models\Admin; // Admin Model ကို ချိတ်ဆက်ခြင်း
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Hash ကို အသုံးပြုရန် ချိတ်ဆက်ခြင်း

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@nova.com',
            'phone' => '09123456789',
            'password' => Hash::make('password123'),
        ]);
        HeroBanner::updateOrCreate(
            ['id' => 1],
            [
                'category' => 'SUSTAINABLE TRAVEL',
                'title' => '20% OFF YOUR FIRST RIDE',
                'description' => 'Join the movement toward cleaner transit. Use code NOVAEV24 and experience our all-electric premium fleet for less.',
                'promo_code' => 'NOVAEV24',
                'badge_1_title' => '100% Electric',
                'badge_1_sub' => 'Zero Emissions',
                'badge_2_title' => 'Business Class',
                'badge_2_sub' => 'Ultimate Comfort',
                'image' => 'hero-bg.jpg',
                'card_title' => 'Sustainable Luxury',
                'card_description' => 'Redefining the intercity commute with silent engines and zero emissions.',
            ]
        );
    }
}