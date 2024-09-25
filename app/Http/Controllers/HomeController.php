<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\Display;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::latest()->take(8)->get();
        $home = Display::where('section','home')->first();
        return view('index',compact('products','home'));
    }
    public function contact(){
        return view('contact');
    }
    public function shop(){
        $products = Product::latest()->paginate(12);
        return view('shop',compact('products'));
    }
    public function testimonial(){
        return view('testimonial');
    }
    public function why(){
        return view('why');
    }
}
