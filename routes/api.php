<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\HeroBannerController as AdminHeroBannerController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;

use App\Http\Controllers\Api\HeroBannerController as ApiHeroBannerController;
use App\Http\Controllers\Api\PromotionController as ApiPromotionController;
use App\Http\Controllers\Api\RouteController as ApiRouteController;


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
| Admin Authentication
|--------------------------------------------------------------------------
|
| NOTE:
| These currently use AdminAuthController, which is primarily written for
| Blade/session authentication. Keep them for now until admin API auth is
| properly separated into its own API controller.
|
*/

Route::post('/admin/login', [AdminAuthController::class, 'login']);


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

        Route::post('/register', [AdminAuthController::class, 'registerAdmin']);
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);


        /*
        |--------------------------------------------------------------------------
        | Hero Banner
        |--------------------------------------------------------------------------
        */

        Route::match(
            ['put', 'post'],
            '/hero-banner',
            [AdminHeroBannerController::class, 'update']
        );


        /*
        |--------------------------------------------------------------------------
        | Promotions
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