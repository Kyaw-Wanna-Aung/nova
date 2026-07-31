<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\PromotionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home Redirect to Admin Login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Public Guest Views
Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
Route::get('/routes/{route}', [RouteController::class, 'show'])->name('routes.show');
Route::get('/hero-banner', [HeroBannerController::class, 'show'])->name('hero-banner.show');
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');


/*
|--------------------------------------------------------------------------
| Admin Guest Routes (Login မဝင်ရသေးမီ ခေါ်ယူနိုင်သော Routes)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});


/*
|--------------------------------------------------------------------------
| Admin Protected Routes (Logged-in Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/me', [AdminAuthController::class, 'me'])->name('profile');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // 2. Admin Management (Admin အသစ်ထပ်ဆောက်ခြင်း)
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AdminAuthController::class, 'registerAdmin'])->name('register');

    // 3. Routes Management (Resource တစ်ကြောင်းတည်းဖြင့် index, create, store, edit, update, destroy အားလုံးအလုပ်လုပ်ပါသည်)
    Route::resource('routes', RouteController::class);

    // 4. Hero Banner Management
    Route::get('/hero-banner/edit', [HeroBannerController::class, 'edit'])->name('hero-banner.edit');
    Route::match(['put', 'post'], '/hero-banner', [HeroBannerController::class, 'update'])->name('hero-banner.update');

    // 5. Promotions Management (Resource တစ်ကြောင်းတည်းဖြင့် ရေးသားနိုင်ပါသည်)
    Route::resource('promotions', PromotionController::class);
});
