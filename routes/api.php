<?php

use App\Http\Controllers\Api\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\HeroBannerController;
use App\Http\Controllers\Api\PromotionController;

/*
|--------------------------------------------------------------------------
| Public Admin Routes
|--------------------------------------------------------------------------
*/
// Admin Login API (No Token Required)
Route::post('/admin/login', [AdminAuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Protected Admin Routes (Sanctum Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    
    // Only logged-in Admins can register another Admin
    Route::post('/register', [AdminAuthController::class, 'registerAdmin']);
    
    // Fetch logged-in Admin details
    Route::get('/me', [AdminAuthController::class, 'me']);
    
    // Admin Logout API
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    
});

/*
|--------------------------------------------------------------------------
| Routes Management APIs
|--------------------------------------------------------------------------
*/

// Public: ခရီးစဉ်များကို မည်သူမဆို ကြည့်ရှုနိုင်မည်
Route::get('/routes', [RouteController::class, 'index']);
Route::get('/routes/{route}', [RouteController::class, 'show']);

// Protected: Admin သာလျှင် ခရီးစဉ် သစ်/ပြင်/ဖျက် လုပ်နိုင်မည်
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::post('/routes', [RouteController::class, 'store']);
    Route::put('/routes/{route}', [RouteController::class, 'update']);
    Route::delete('/routes/{route}', [RouteController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Public Endpoints
|--------------------------------------------------------------------------
*/
Route::get('/hero-banner', [HeroBannerController::class, 'show']);
Route::get('/promotions', [PromotionController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Protected Admin Endpoints
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // Top Hero Banner Update (POST with _method=PUT နှင့် PUT နှစ်မျိုးလုံး လက်ခံသည်)
    Route::match(['put', 'post'], '/hero-banner', [HeroBannerController::class, 'update']);

    // Promotions Add / Edit / Delete
    Route::post('/promotions', [PromotionController::class, 'store']);
    
    // POST (with _method=PUT) နှင့် PUT နှစ်မျိုးလုံး လက်ခံရန်
    Route::match(['put', 'post'], '/promotions/{promotion}', [PromotionController::class, 'update']);
    
    Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy']);
});