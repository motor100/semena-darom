<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LkController;
use App\Http\Controllers\AjaxController;

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

Route::get('/catalog', [MainController::class, 'catalog'])->name('catalog');

Route::get('/akcii', [MainController::class, 'akcii']);

Route::get('/novinki', [MainController::class, 'novinki']);

Route::get('/catalog/{slug}', [MainController::class, 'single_product']);

Route::get('/favourites', [MainController::class, 'favourites']);

Route::get('/clear-favourites', [MainController::class, 'clear_favourites']);

Route::post('/rmfromfavourites', [MainController::class, 'rm_from_favourites']);

Route::get('/cart', [MainController::class, 'cart']);

Route::get('/clear-cart', [MainController::class, 'clear_cart']);

Route::post('/rmfromcart', [MainController::class, 'rm_from_cart']);

Route::get('/create-order', [MainController::class, 'create_order']);

Route::get('/politika-konfidencialnosti', [MainController::class, 'politika_konfidencialnosti']);

Route::get('/polzovatelskoe-soglashenie-s-publichnoj-ofertoj', [MainController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj']);

Route::get('/garantiya-vozvrata-denezhnyh-sredstv', [MainController::class, 'garantiya_vozvrata_denezhnyh_sredstv']);

Route::get('/kak-oformit-zakaz', [MainController::class, 'kak_oformit_zakaz']);

Route::get('/poisk', [MainController::class, 'poisk']);

Route::post('/set-city', [MainController::class, 'set_city']);


// temp
Route::get('/sdek', [DeliveryController::class, 'sdek']);

Route::get('/russian-post', [DeliveryController::class, 'russian_post']);


// ajax
Route::post('/ajax/callback', MailerController::class)->name('callback');

Route::post('/ajax/product-search', [AjaxController::class, 'ajax_product_search']);

Route::post('/ajax/city', [AjaxController::class, 'ajax_city']);

Route::post('/ajax/city-select', [AjaxController::class, 'ajax_city_select']);

Route::post('/ajax/addtocart', [AjaxController::class, 'ajax_add_to_cart']);

Route::post('/ajax/pluscart', [AjaxController::class, 'ajax_plus_cart']);

Route::post('/ajax/minuscart', [AjaxController::class, 'ajax_minus_cart']);

Route::post('/ajax/addtofavourites', [AjaxController::class, 'ajax_add_to_favourites']);

Route::post('/ajax/testimonial', [AjaxController::class, 'ajax_testimonial']);

Route::post('/ajax/we-use-cookie', [AjaxController::class, 'ajax_we_use_cookie']);



// Личный кабинет
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Личный кабинет
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('lk', [LkController::class, 'home'])->name('lk.index');

    Route::get('profile', [ProfileController::class, 'home'])->name('profile');

});

// Fallback route
Route::fallback([MainController::class, 'page_404']);