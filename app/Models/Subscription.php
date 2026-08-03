<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'subscribed_at'];

    protected function casts(): array
    {
        return ['subscribed_at' => 'datetime'];
    }
}
