<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CdekController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MainSliderController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\OrderController;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(static function () {

    // Guest routes
    Route::middleware('guest:admin')->group(static function () {
        // Auth routes
        Route::get('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'create'])->name('admin.login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'store']);
        // Forgot password
        Route::get('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'create'])->name('admin.password.request');
        Route::post('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'store'])->name('admin.password.email');
        // Reset password
        Route::get('reset-password/{token}', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'create'])->name('admin.password.reset');
        Route::post('reset-password', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'store'])->name('admin.password.update');
    });

    // Verify email routes
    Route::middleware(['auth:admin'])->group(static function () {
        Route::get('verify-email', [\App\Http\Controllers\Admin\Auth\EmailVerificationPromptController::class, '__invoke'])->name('admin.verification.notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\Admin\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('admin.verification.verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('admin.verification.send');
    });

    // Authenticated routes
    Route::middleware(['auth:admin'])->group(static function () {
        // Confirm password routes
        Route::get('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'show'])->name('admin.password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'store']);

        // Logout route
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('admin.logout');

        // Админ панель
        Route::get('/', [AdminController::class, 'home'])->name('admin.index');

        Route::get('/profile', [ProfileController::class, 'edit'])
                    ->middleware('password.confirm.admin')
                    ->name('admin.profile');

        Route::put('password', [ProfileController::class, 'new_password'])->name('admin.newpassword');

        Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

        // Products
        Route::get('products', [ProductController::class, 'index']);

        Route::get('products/create', [ProductController::class, 'create'])->name('products-create');

        Route::post('products/store', [ProductController::class, 'store'])->name('products-store');

        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products-edit');

        Route::post('products/update', [ProductController::class, 'update'])->name('products-update');

        Route::get('products/{id}/destroy', [ProductController::class, 'destroy'])->name('products-destroy');



        Route::get('/main-slider', [MainSliderController::class, 'index']);

        Route::get('/main-slider/create', [MainSliderController::class, 'create'])->name('main-slider-create');

        Route::post('/main-slider/store', [MainSliderController::class, 'store'])->name('main-slider-store');

        Route::get('/main-slider/{id}', [MainSliderController::class, 'show'])->name('main-slider-show');

        Route::get('/main-slider/{id}/edit', [MainSliderController::class, 'edit'])->name('main-slider-edit');

        Route::post('/main-slider/update', [MainSliderController::class, 'update'])->name('main-slider-update');

        Route::get('/main-slider/{id}/destroy', [MainSliderController::class, 'destroy'])->name('main-slider-destroy');

        Route::get('/promos', [PromoController::class, 'index']);

        Route::get('/promos/create', [PromoController::class, 'create'])->name('promos-create');

        Route::post('/promos/store', [PromoController::class, 'store'])->name('promos-store');

        Route::get('/promos/{id}', [PromoController::class, 'show'])->name('promos-show');

        Route::get('/promos/{id}/edit', [PromoController::class, 'edit'])->name('promos-edit');

        Route::post('/promos/{id}/update', [PromoController::class, 'update'])->name('promos-update');

        Route::get('/promos/{id}/destroy', [PromoController::class, 'destroy'])->name('promos-destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');

        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders-show');

        Route::post('/orders/{id}/update', [OrderController::class, 'update'])->name('admin.order-update');

        Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('admin.order-print');

        Route::get('/orders/{id}/check', [OrderController::class, 'check'])->name('admin.order-check');

        Route::get('/orders/{id}/sdek-create-order', [CdekController::class, 'cdek_create_order'])->name('admin.cdek-create-order');

        Route::get('/order/{id}/sdek-download-waybill', [CdekController::class, 'cdek_download_waybill'])->name('admin.cdek-download-waybill');

        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials');

        Route::post('/testimonials-update', [TestimonialController::class, 'update']);

        Route::post('/testimonials-destroy', [TestimonialController::class, 'destroy']);

        Route::get('/polzovatelskoe-soglashenie-s-publichnoj-ofertoj', [AdminController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj']);

        Route::post('/polzovatelskoe-soglashenie-s-publichnoj-ofertoj/update', [AdminController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj_update']);

        Route::get('/politika-konfidencialnosti', [AdminController::class, 'politika_konfidencialnosti']);

        Route::post('/politika-konfidencialnosti/update', [AdminController::class, 'politika_konfidencialnosti_update']);

        Route::get('/garantiya-vozvrata-denezhnyh-sredstv', [AdminController::class, 'garantiya_vozvrata_denezhnyh_sredstv']);

        Route::post('/garantiya-vozvrata-denezhnyh-sredstv/update', [AdminController::class, 'garantiya_vozvrata_denezhnyh_sredstv_update']);

        Route::get('/page-404', [AdminController::class, 'page_404']);
    });
});

