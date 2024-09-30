<?php

use App\Http\Controllers\admin\AdminAttributesController;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use App\Http\Controllers\admin\display\AboutController;
use App\Http\Controllers\admin\display\ContactController;
use App\Http\Controllers\admin\display\HomeController;
use App\Http\Controllers\admin\display\MediaController;
use App\Http\Controllers\admin\DisplayController;
use App\Http\Controllers\admin\MessageController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/admin')->name('admin.')->group(function(){

    Route::controller(AdminLoginController::class)->group(function(){
        Route::get('login','login')->name('login');
        Route::post('login','checkLogin')->name('checkLogin');
        Route::post('logout','logout')->name('logout')->middleware('auth:admin');
    });

    Route::controller(AdminRegisterController::class)->group(function(){
        Route::get('register','register')->name('register');
        Route::post('register','store')->name('store');
    });

    Route::prefix('/dashboard')->name('dashboard.')->group(function(){


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

    Route::controller(AdminAttributesController::class)->group(function(){
        Route::get('/attributes','index')->name('attributes.index');
        Route::get('/attributes/create','create')->name('attributes.create');
        Route::post('/attributes','store')->name('attributes.store');
        Route::delete('/attributes/{attribute}','destroy')->name('attributes.destroy');
        Route::get('/attributres/get_values','get_values')->name('attributes.get.values');
    });

    Route::controller(AdminOrderController::class)->group(function(){
        Route::get('orders','index')->name('orders.index');
        Route::get('orders/{order}','show')->name('orders.show');
        Route::get('orders/canceled/{order}','cancelOrder')->name('orders.cancel');
        Route::get('orders/processing/{order}','processOrder')->name('orders.processing');
        Route::get('orders/shipping/{order}','shipOrder')->name('orders.shipping');
        Route::get('orders/delivering/{order}','deliverOrder')->name('orders.delivered');
        Route::get('orders/print/{order}','print')->name('orders.print');
    });

    Route::controller(MessageController::class)->group(function(){
        Route::get('/messages','index')->name('messages.index');
        Route::get('/messages/{message}','show')->name('messages.show');
        Route::delete('/messages/{message}','destroy')->name('messages.destroy');
        Route::post('/unread_messages','unread_messages')->name('messages.unread_messages');
    });

    
    Route::prefix('/displays')->name('displays.')->group(function(){
        Route::controller(DisplayController::class)->group(function(){
            Route::get('/','index')->name('index');
        });

        Route::controller(HomeController::class)->group(function(){
            Route::prefix('/home')->name('home.')->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/','update')->name('update');
            });
        });
        Route::controller(AboutController::class)->group(function(){
            Route::prefix('/about')->name('about.')->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/','update')->name('update');
            });
        });
        Route::controller(ContactController::class)->group(function(){
            Route::prefix('/contact')->name('contact.')->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/','update')->name('update');
            });
        });
        Route::controller(MediaController::class)->group(function(){
            Route::prefix('/media')->name('media.')->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/','update')->name('update');
            });
        });
    });

    Route::controller(AdminAuthController::class)->group(function(){
        Route::prefix('/key')->name('key.')->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/create','create')->name('create');
            Route::post('/','store')->name('store');
            Route::delete('/{key}','destroy')->name('destroy');
        });
    });

    });
});



