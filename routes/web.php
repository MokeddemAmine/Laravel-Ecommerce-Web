<?php

use App\Http\Controllers\HomeController;
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
Route::get('products/{product}',[HomeController::class,'show_product'])->name('products.show');

Route::controller(ProfileController::class)->group(function(){
    Route::get('/user/profile','profilePage')->name('user.profile');
});



