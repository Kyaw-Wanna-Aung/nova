<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AdminAuthController as ApiAdminAuthController;
use App\Http\Controllers\Api\HeroBannerController as ApiHeroBannerController;
use App\Http\Controllers\Api\PromotionController as ApiPromotionController;
use App\Http\Controllers\Api\RouteController as ApiRouteController;

use App\Http\Controllers\Admin\HeroBannerController as AdminHeroBannerController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;


/*
|--------------------------------------------------------------------------
| Public API Endpoints
|--------------------------------------------------------------------------
*/

Route::get('/promotions', [ApiPromotionController::class, 'index']);

Route::get('/hero-banner', [ApiHeroBannerController::class, 'show']);

Route::get('/routes', [ApiRouteController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Admin API Authentication
|--------------------------------------------------------------------------
*/

Route::post('/admin/login', [ApiAdminAuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Protected Admin API Endpoints
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Account
        |--------------------------------------------------------------------------
        */

        Route::get('/me', [ApiAdminAuthController::class, 'me']);

        Route::post('/logout', [ApiAdminAuthController::class, 'logout']);

        Route::post('/register', [ApiAdminAuthController::class, 'register']);


        /*
        |--------------------------------------------------------------------------
        | Hero Banner Management
        |--------------------------------------------------------------------------
        */

        Route::match(
            ['put', 'post'],
            '/hero-banner',
            [AdminHeroBannerController::class, 'update']
        );


        /*
        |--------------------------------------------------------------------------
        | Promotion Management
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/promotions',
            [AdminPromotionController::class, 'store']
        );

        Route::match(
            ['put', 'post'],
            '/promotions/{promotion}',
            [AdminPromotionController::class, 'update']
        );

        Route::delete(
            '/promotions/{promotion}',
            [AdminPromotionController::class, 'destroy']
        );
    });