<?php

use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use ParagonIE\Sodium\Core\Curve25519\Ge\P2;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/admin/dashboard')->name('admin.dashboard.')->group(function(){

    Route::controller(AdminHomeController::class)->group(function(){
        Route::get('/','index')->name('index');
        Route::get('/profile','profile')->name('profile');
        Route::put('/profile/{admin}','update')->name('update');
        Route::put('/profile/updatePass/{admin}','updatePassword')->name('updatePassword');
    });

    Route::controller(AdminCategoryController::class)->group(function(){

        Route::get('/categories','index')->name('categories.index');
        Route::get('/categorries/create','create')->name('categories.create');
        Route::post('/categorries','store')->name('categories.store');
        Route::get('/categories/{category}','show')->name('categories.show');
        Route::get('/categories/{category}/edit','edit')->name('categories.edit');
        Route::put('/categories/{category}','update')->name('categories.update');
        Route::delete('/categories/{category}','destroy')->name('categories.destroy');

    });

    Route::controller(AdminProductController::class)->group(function(){
        Route::get('/products','index')->name('products.index');
        Route::get('/products/create','create')->name('products.create');
        Route::post('/products','store')->name('products.store');
        Route::post('/products/{product}','show')->name('products.show');
        Route::get('/products/{product}/edit','edit')->name('products.edit');
        Route::put('/products/{product}','update')->name('products.update');
        Route::delete('/products/{product}','destroy')->name('products.destroy');

        Route::get('/products/search','search')->name('products.search');
    });

    Route::controller(AdminLoginController::class)->group(function(){
        Route::get('login','login')->name('login');
        Route::post('login','checkLogin')->name('checkLogin');
        Route::post('logout','logout')->name('logout')->middleware('auth:admin');
    });

    Route::controller(AdminRegisterController::class)->group(function(){
        Route::get('register','register')->name('register');
        Route::post('register','store')->name('store');
    });
});



