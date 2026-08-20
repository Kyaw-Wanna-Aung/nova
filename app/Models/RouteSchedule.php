<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteSchedule extends Model
{
    use HasFactory;

    protected $table = 'novapi_routescheds'; // သင့် database ဇယားနာမည်အမှန်

    


    protected $fillable = [
        'route_id',
        'route_date',
        'complete',
        'driver_id',
        'vehicle_id',
    ];

    // Relationships (Relationships တွေအတွက် ဇယားမရှိသေးရင်လည်း error မတက်အောင် လိုအပ်သလို ချိန်ထားနိုင်ပါတယ်)
    public function route()
    {
        return $this->belongsTo(TravelRoute::class, 'route_id');
    }
    public function driver() {
    return $this->belongsTo(NovapiDriverProfiles::class, 'driver_id');
    }

    public function vehicle() {
        return $this->belongsTo(NovapiVehicle::class, 'vehicle_id');
    }
}