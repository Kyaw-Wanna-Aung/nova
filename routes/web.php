<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RouteManagementController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\Admin\VisionMissionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\User\BlogController as UserBlogController;
use App\Http\Controllers\User\RouteController as UserRouteController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/download-app', [HomeController::class, 'downloadApp'])->name('download-app');
Route::get('/support', [HomeController::class, 'support'])->name('support');
Route::get('/blog', [UserBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [UserBlogController::class, 'show'])->name('blog.show');
Route::get('/our-routes', [UserRouteController::class, 'index'])->name('our-routes');

// Public Guest Views
// Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
// Route::get('/routes/{route}', [RouteController::class, 'show'])->name('routes.show');
Route::get('/hero-banner', [HeroBannerController::class, 'show'])->name('hero-banner.show');
Route::get('/promotions', [HomeController::class, 'promotions'])->name('promotions.index');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])->name('newsletter.subscribe');


/*
|--------------------------------------------------------------------------
| Admin Guest Routes
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

    // 2. Admin Management
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AdminAuthController::class, 'registerAdmin'])->name('register');

    // 3. Routes Management (Resource + export, bulk)
    Route::resource('routes', RouteController::class);
    Route::post('/routes/bulk', [RouteController::class, 'bulk'])->name('routes.bulk');
    Route::get('/routes-export', [RouteController::class, 'export'])->name('routes.export');

    // 4. Route Management Module (route-management)
    Route::resource('route-management', RouteManagementController::class)->except(['create', 'show']);
    Route::patch('/route-management/{routeManagement}/status', [RouteManagementController::class, 'changeStatus'])
        ->name('route-management.status');
    Route::post('/route-management/bulk-action', [RouteManagementController::class, 'bulkAction'])
        ->name('route-management.bulk-action');
    Route::get('/route-management-export', [RouteManagementController::class, 'export'])
        ->name('route-management.export');

    // 5. Hero Banner Management
    Route::get('/hero-banner/edit', [HeroBannerController::class, 'edit'])->name('hero-banner.edit');
    Route::match(['put', 'post'], '/hero-banner', [HeroBannerController::class, 'update'])->name('hero-banner.update');

    // 6. Promotions Management
    Route::resource('promotions', PromotionController::class);

    // 7. Website Testimonials Management
    Route::resource('testimonials', TestimonialController::class)->except(['create', 'show']);
    Route::patch('/testimonials/{testimonial}/status', [TestimonialController::class, 'changeStatus'])
        ->name('testimonials.status');

    // 8. Website FAQ Management
    Route::resource('faqs', FaqController::class)->except(['create', 'show']);
    Route::patch('/faqs/{faq}/status', [FaqController::class, 'changeStatus'])->name('faqs.status');
    Route::post('/faqs/bulk-action', [FaqController::class, 'bulkAction'])->name('faqs.bulk-action');
    Route::get('/faqs-export', [FaqController::class, 'export'])->name('faqs.export');

    // 9. Newsletter Subscription Management
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    Route::post('/subscriptions/bulk-delete', [SubscriptionController::class, 'bulkDelete'])->name('subscriptions.bulk-delete');
    Route::get('/subscriptions/export', [SubscriptionController::class, 'exportCsv'])->name('subscriptions.export');

    // 10. Website Vision & Mission Management
    Route::get('/vision-mission', [VisionMissionController::class, 'index'])->name('vision-mission.index');
    Route::put('/vision-mission', [VisionMissionController::class, 'update'])->name('vision-mission.update');

    // 11. Website Blog Management
    Route::resource('blog', AdminBlogController::class)->except(['create', 'show']);
    Route::patch('/blog/{blog}/status', [AdminBlogController::class, 'changeStatus'])->name('blog.status');
    Route::patch('/blog/{blog}/hero', [AdminBlogController::class, 'toggleHero'])->name('blog.hero');
});
