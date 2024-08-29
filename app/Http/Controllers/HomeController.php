<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        $products = Product::latest()->take(8)->get();;
        return view('index',compact('products'));
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
    public function show_product(Request $request,Product $product){
        $related_products = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(4)
        ->get();

        $window_width = $request->window_width?$request->window_width:1000;
        return view('product',compact('product','window_width','related_products'));
    }
}
