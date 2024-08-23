<?php

use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('/admin/dashboard/')->name('admin.dashboard.')->group(function(){
    Route::get('home',[AdminHomeController::class,'home'])->name('home');
    Route::controller(AdminLoginController::class)->group(function(){
        Route::get('login','login')->name('login');
        Route::post('login','checkLogin')->name('checkLogin');
        Route::post('logout','logout')->name('logout');
    });
    Route::controller(AdminRegisterController::class)->group(function(){
        Route::get('register','register')->name('register');
        Route::post('register','store')->name('store');
    });
});



