<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\CartController;
use App\Models\Display;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $cartController = new CartController();
            $cartCount = $cartController->getCartCount();
            $view->with('cart_count', $cartCount);
        });

        $about = Display::where('section','about')->first();
        $contact = Display::where('section','contact')->get();
        $media = Display::where('section','media')->get();
        View::share('about',$about);
        View::share('contact',$contact);
        View::share('media',$media);
    }
}
