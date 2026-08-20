<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles; // Spatie Roles များနှင့် ချိတ်သုံးရန်

class AuthUser extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $table = 'auth_user'; 

    protected $fillable = [
        'password',
        'username',
        'first_name',
        'last_name',
        'email',
        'is_active',
        'last_login',
        'date_joined',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login' => 'datetime',
            'date_joined' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}   