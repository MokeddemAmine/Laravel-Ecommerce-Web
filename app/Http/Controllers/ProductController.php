<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Request $request,$slug){
        $product = Product::where('slug',$slug)->first();
        $related_products = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(4)
        ->get();

        $window_width = $request->window_width?$request->window_width:1000;
        return view('product',compact('product','window_width','related_products'));
    }

}
