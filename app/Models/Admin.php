<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Mass Assignment ပြုလုပ်ခွင့်ပေးမည့် Column များ
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * Response ပြန်ပေးသည့်အခါ ဝှက်ထားရမည့် Column များ
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Data Type များကို Auto Convert ပြုလုပ်ပေးမည့် နည်းလမ်းများ
     */
    protected $casts = [
        'password' => 'hashed', // Password သိမ်းသည့်အခါ Hash အလိုအလျောက် လုပ်ပေးမည်
    ];
}