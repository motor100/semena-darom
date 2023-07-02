<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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
    Route::middleware(['auth:admin', 'verified'])->group(static function () {
        // Confirm password routes
        Route::get('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'show'])->name('admin.password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'store']);
        // Logout route
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
        // General routes
        Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.index');
        Route::get('profile', [\App\Http\Controllers\Admin\HomeController::class, 'profile'])->middleware('password.confirm.admin')->name('admin.profile');

        // Админ панель
        Route::get('/', [AdminController::class, 'home'])->name('admin.index');
        // Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');

        Route::get('/dashboard/main-slider', [MainSliderController::class, 'index']);

        Route::get('/dashboard/main-slider/create', [MainSliderController::class, 'create'])->name('main-slider-create');

        Route::post('/dashboard/main-slider/store', [MainSliderController::class, 'store'])->name('main-slider-store');

        Route::get('/dashboard/main-slider/{id}', [MainSliderController::class, 'show'])->name('main-slider-show');

        Route::get('/dashboard/main-slider/{id}/edit', [MainSliderController::class, 'edit'])->name('main-slider-edit');

        Route::post('/dashboard/main-slider/update', [MainSliderController::class, 'update'])->name('main-slider-update');

        Route::get('/dashboard/main-slider/{id}/destroy', [MainSliderController::class, 'destroy'])->name('main-slider-destroy');

        Route::get('/dashboard/promos', [PromoController::class, 'index']);

        Route::get('/dashboard/promos/create', [PromoController::class, 'create'])->name('promos-create');

        Route::post('/dashboard/promos/store', [PromoController::class, 'store'])->name('promos-store');

        Route::get('/dashboard/promos/{id}', [PromoController::class, 'show'])->name('promos-show');

        Route::get('/dashboard/promos/{id}/edit', [PromoController::class, 'edit'])->name('promos-edit');

        Route::post('/dashboard/promos/{id}/update', [PromoController::class, 'update'])->name('promos-update');

        Route::get('/dashboard/promos/{id}/destroy', [PromoController::class, 'destroy'])->name('promos-destroy');

        Route::get('/dashboard/testimonials', [AdminController::class, 'testimonials']);

        Route::post('/dashboard/testimonials-update', [AdminController::class, 'testimonials_update']);

        Route::post('/dashboard/testimonials-destroy', [AdminController::class, 'testimonials_destroy']);

    });
});

