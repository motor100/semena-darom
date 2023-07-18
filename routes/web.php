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

Route::post('create-order-handler', [MainController::class, 'create_order_handler']);

Route::get('/thankyou', [MainController::class, 'thankyou'])->name('thankyou');

Route::get('/politika-konfidencialnosti', [MainController::class, 'politika_konfidencialnosti']);

Route::get('/polzovatelskoe-soglashenie-s-publichnoj-ofertoj', [MainController::class, 'polzovatelskoe_soglashenie_s_publichnoj_ofertoj']);

Route::get('/garantiya-vozvrata-denezhnyh-sredstv', [MainController::class, 'garantiya_vozvrata_denezhnyh_sredstv']);

Route::get('/kak-oformit-zakaz', [MainController::class, 'kak_oformit_zakaz']);

Route::get('/poisk', [MainController::class, 'poisk']);

Route::post('/set-city', [MainController::class, 'set_city']);

// temp
Route::get('/weight', [DeliveryController::class, 'get_weight']);


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

Route::post('/ajax/sdek', [DeliveryController::class, 'sdek']);

Route::post('/ajax/russian-post', [DeliveryController::class, 'russian_post']);


// Личный кабинет
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/lk/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/lk/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/lk/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lk', [LkController::class, 'home'])->name('lk.index');
    Route::get('/lk/{id}', [LkController::class, 'order'])->name('lk.order');
});

require __DIR__.'/auth.php';

// Fallback route
Route::fallback([MainController::class, 'page_404']);