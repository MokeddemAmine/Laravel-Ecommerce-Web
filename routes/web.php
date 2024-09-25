<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify'  => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/shop', [App\Http\Controllers\HomeController::class, 'shop'])->name('shop');
Route::get('/testimonial', [App\Http\Controllers\HomeController::class, 'testimonial'])->name('testimonial');
Route::get('/why', [App\Http\Controllers\HomeController::class, 'why'])->name('why');

Route::controller(ProductController::class)->group(function(){
    Route::get('products/{slug}','show')->name('products.show');
});


    Route::controller(CartController::class)->group(function(){
        Route::get('carts/{user}','show')->name('carts.show');
        Route::post('carts/update','update')->name('carts.update');
        Route::post('carts/addToCart/{product}','store')->name('carts.store');
        Route::delete('carts/{cart}','destroy')->name('carts.destroy');
        Route::post('carts/checkAttribute','checkAttribute')->name('carts.checkAttribute');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::get('orders','index')->name('orders.index');
        Route::get('orders/create','create')->name('orders.create');
        Route::post('orders','store')->name('orders.store');
        Route::get('orders/{order}','show')->name('orders.show');
        Route::delete('orders/destroy-item/{item}','destroyItem')->name('orders.destroy.item');
        Route::get('orders/cancelOrder/{order}','cancelOrder')->name('orders.destroy');
        Route::get('orders/confirmOrder/{order}','confirmOrder')->name('orders.confirm');
    });

    Route::controller(CheckoutController::class)->group(function(){
        Route::get('checkout/{address}','checkout')->name('checkout.index');
        Route::post('checkout','checkout_store')->name('checkout.store');
    });

    Route::controller(PayPalController::class)->group(function(){
        Route::get('paypal','payment')->name('paypal.payment');
        Route::get('paypal/success','success')->name('paypal.success');
        Route::get('paypal/cancel','cancel')->name('paypal.cancel');
    });

    Route::controller(ProfileController::class)->group(function(){
        Route::get('/user/profile','profilePage')->name('user.profile');
    });

    Route::controller(MessageController::class)->group(function(){
        Route::get('/messages','index')->name('messages');
        Route::post('/messages','store')->name('messages.store');
        Route::delete('/messages/{message}','destroy')->name('messages.destroy');
    });
