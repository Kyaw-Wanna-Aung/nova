<?php
use App\Http\Controllers\Admin\HeroBannerController as AdminHeroBannerController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Api\AdminAuthController as ApiAdminAuthController;
use App\Http\Controllers\Api\BlogController as ApiBlogController;
use App\Http\Controllers\Api\FaqController as ApiFaqController;
use App\Http\Controllers\Api\HeroBannerController as ApiHeroBannerController;
use App\Http\Controllers\Api\PromotionController as ApiPromotionController;
use App\Http\Controllers\Api\RouteController as ApiRouteController;
use App\Http\Controllers\Api\TestimonialController as ApiTestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsletterController as ApiNewsletterController;
use App\Http\Controllers\Api\VisionMissionController as ApiVisionMissionController;
use App\Http\Controllers\Api\VehicleBrandController as ApiVehicleBrandController;
use App\Http\Controllers\Api\VehicleModelController as ApiVehicleModelController;
use App\Http\Controllers\Api\VehicleController as ApiVehicleController;

/*
|--------------------------------------------------------------------------
| Public API Endpoints
|--------------------------------------------------------------------------
*/

Route::get('/promotions', [ApiPromotionController::class, 'index']);

Route::get('/hero-banner', [ApiHeroBannerController::class, 'show']);

Route::get('/routes', [ApiRouteController::class, 'index']);
Route::get('/testimonials', [ApiTestimonialController::class, 'index']);
Route::get('/faqs', [ApiFaqController::class, 'index']);
Route::get('/blogs', [ApiBlogController::class, 'index']);
Route::get('/vision-mission', [ApiVisionMissionController::class, 'show']);

Route::post('/newsletter/subscribe', [ApiNewsletterController::class, 'store']);
Route::get(
    '/blogs/{blog:slug}',
    [ApiBlogController::class, 'show']
);
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

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Vehicle Brand Management
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/vehicle-brands',
            [ApiVehicleBrandController::class, 'index']
        );

        Route::post(
            '/vehicle-brands',
            [ApiVehicleBrandController::class, 'store']
        );

        Route::put(
            '/vehicle-brands/{vehicleBrand}',
            [ApiVehicleBrandController::class, 'update']
        );

        Route::delete(
            '/vehicle-brands/{vehicleBrand}',
            [ApiVehicleBrandController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Vehicle Model Management
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/vehicle-models',
            [ApiVehicleModelController::class, 'index']
        );

        Route::post(
            '/vehicle-models',
            [ApiVehicleModelController::class, 'store']
        );

        Route::put(
            '/vehicle-models/{vehicleModel}',
            [ApiVehicleModelController::class, 'update']
        );

        Route::delete(
            '/vehicle-models/{vehicleModel}',
            [ApiVehicleModelController::class, 'destroy']
        );
        /*
        |--------------------------------------------------------------------------
        | Vehicle Management
        |--------------------------------------------------------------------------
        */
        Route::post(
            '/vehicles',
            [ApiVehicleController::class, 'store']
        );
        Route::put(
        '/vehicles/{vehicle}',
        [ApiVehicleController::class, 'update']
            );
        Route::get(
            '/vehicles/{vehicleId}/history',
            [ApiVehicleController::class, 'history']
        );
        Route::delete(
            '/vehicles/{vehicle}',
            [ApiVehicleController::class, 'destroy']
        );
        
        Route::patch(
            '/vehicles/{vehicle}/approve',
            [ApiVehicleController::class, 'approve']
        );

        Route::patch(
            '/vehicles/{vehicle}/reject',
            [ApiVehicleController::class, 'reject']
        );
        Route::get(
            '/vehicles',
            [ApiVehicleController::class, 'index']
        );
        Route::get(
            '/vehicles/{vehicle}',
            [ApiVehicleController::class, 'show']
        );
        Route::patch(
            '/vehicles/{vehicle}/status',
            [ApiVehicleController::class, 'updateStatus']
        );
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
