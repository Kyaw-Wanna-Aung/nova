<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    use HasFactory;

    // updated_by ကို ဖြုတ်လိုက်ပါပြီ
    protected $fillable = ['vision', 'mission'];

    // Admin relationship လည်း မလိုတော့လို့ ဖယ်ရှားလိုက်ပါပြီ
}