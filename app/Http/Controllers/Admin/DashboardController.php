<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\RouteManagement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRoutes = RouteManagement::count();
        $totalPromotions = Promotion::count();

        return view('admin.dashboard', compact(
            'totalRoutes',
            'totalPromotions'
        ));
    }
}