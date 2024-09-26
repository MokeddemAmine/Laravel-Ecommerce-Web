<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\DetailsOrder;
use App\Models\Display;
use App\Models\Product;
use Avifinfo\Prop;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('shop',compact('products','categories','attributes'));
    }
    public function why(){
        return view('why');
    }

    public function search_products(Request $request){

        $categories = Category::all();
        $attributes = Attribute::all();
        $products = Product::all();

        $request->validate([
            'sort_by'       => ['nullable','in:price_low,newest,top_sellers,price_high'],
            'min_price'     => ['nullable','numeric'],
            'max_price'     => ['nullable','numeric'],
            'categories.*'  => ['nullable','exists:categories,id'],
        ]);

        $attrs = $request->except('_token','sort_by','min_price','max_price','categories');
        $valide_attrs = [];
        foreach($attrs as $key => $value){
            $valide_attrs[$key.'.*'] = ['nullable','exists:details_attributes,value'];
        }
        // valide attributes
        $request->validate($valide_attrs);
        
        
        if($request->sort_by){
            if($request->sort_by == 'price_low'){
                $new_products = Product::orderBy('price','asc')->get();
            }elseif($request->sort_by == 'price_high'){
                $new_products = Product::orderBy('price','desc')->get();
            }elseif($request->sort_by == 'newest'){
                $new_products = Product::latest()->get();
            }else{
                $ids_products = DetailsOrder::distinct()->pluck('product_id')->toArray();
                $new_products = Product::whereIn('id',$ids_products)->get();
            }
            $products = $new_products;
        }
        if($request->min_price){
            if($products){
                $new_products = Product::where('price','>=',$request->min_price)->get();
                $products = $products->intersect($new_products);
            }else{
                $products = Product::where('price','>=',$request->min_price)->get();
            }
            
        }
        if($request->max_price){
            if($products){
                $new_products = Product::where('price','<=',$request->max_price)->get();
                $products = $products->intersect($new_products);
            }else{
                $products = Product::where('price','<=',$request->max_price)->get();
            }
            
        }

        if($request->categories && count($request->categories)){
            
            if($products){
                $new_products = Product::whereIn('category_id',$request->categories)->get();
                $products = $products->intersect($new_products);
            }else{
                $products = Product::whereIn('category_id',$request->categories)->get();
            }
        }
        
        if($attrs && count($attrs)){
            foreach($attrs as $key => $values){
                $name = str_replace('_',' ',$key);
                $new_products = Product::where('attributes','LIKE','%'.$name.'%')->get();
                $new_products2 = null;
                foreach($values as $value){
                    if($new_products2){
                        $new_products3 = Product::where('attributes','LIKE','%'.$value.'%')->get();
                        $new_products2 = $new_products2->union($new_products3);
                    }else{
                        $new_products2 = Product::where('attributes','LIKE','%'.$value.'%')->get();
                    } 
                }
                if($new_products2){
                    $new_products = $new_products->intersect($new_products2);
                }
                if($products){
                    $products = $products->intersect($new_products);
                }else{
                    $products = $new_products;
                }
            }
        }
        
        if($products){
            $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get current page number
            $perPage = 12; // Define how many items you want per page
            $currentPageItems = $products->slice(($currentPage - 1) * $perPage, $perPage)->values(); // Slice the collection to get the items for the current page

            // Create LengthAwarePaginator instance for paginated results
            $products = new LengthAwarePaginator(
                $currentPageItems, // Items for the current page
                $products->count(), // Total items after intersection
                $perPage, // Items per page
                $currentPage, // Current page
                ['path' => LengthAwarePaginator::resolveCurrentPath()] // Path for pagination links
            );
        }
        
        return view('shop',compact('products','categories','attributes'));
    }
}
