<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/o-kompanii', [MainController::class, 'o_kompanii']);

Route::get('/dostavka-i-oplata', [MainController::class, 'dostavka_i_oplata']);

Route::get('/otzyvy', [MainController::class, 'otzyvy']);

Route::get('/kontakty', [MainController::class, 'kontakty']);

Route::get('/catalog', [MainController::class, 'catalog']);

Route::get('/cart', [MainController::class, 'cart']);

Route::get('/politika-konfidencialnosti', [MainController::class, 'politika_konfidencialnosti']);

Route::get('/polzovatelskoe-soglashenie-s-publichnoj-ofertoj', [MainController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj']);

Route::get('/garantiya-vozvrata-denezhnyh-sredstv', [MainController::class, 'garantiya_vozvrata_denezhnyh_sredstv']);



Route::get('/sdek', [DeliveryController::class, 'sdek']);

Route::get('/russian-post', [DeliveryController::class, 'russian_post']);

Route::post('/otzyvy-store', [MainController::class, 'otzyvy_store']);



Route::post('/ajax/callback', MailerController::class)->name('callback');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Админ панель
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');



    Route::get('/dashboard/polzovatelskoe-soglashenie-s-publichnoj-ofertoj', [AdminController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj']);

    Route::post('/dashboard/polzovatelskoe-soglashenie-s-publichnoj-ofertoj/update', [AdminController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj_update']);

    Route::get('/dashboard/politika-konfidencialnosti', [AdminController::class, 'politika_konfidencialnosti']);

    Route::post('/dashboard/politika-konfidencialnosti/update', [AdminController::class, 'politika_konfidencialnosti_update']);

    Route::get('/dashboard/garantiya-vozvrata-denezhnyh-sredstv', [AdminController::class, 'garantiya_vozvrata_denezhnyh_sredstv']);

    Route::post('/dashboard/garantiya-vozvrata-denezhnyh-sredstv/update', [AdminController::class, 'garantiya_vozvrata_denezhnyh_sredstv_update']);


    

});