<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use WooCommerce\PayPalCommerce\AdminNotices\Repository\RepositoryInterface;
use WpOrg\Requests\Response;

class CartController extends Controller
{

    public function __construct(){
        
        $this->middleware('auth');
    }

    public function store(Product $product){

        // verify if there are carts exist for the current user

        $cart_exist = Cart::where('user_id',Auth::user()->id)->first();
        
        if(!$cart_exist){
            return $this->create_new_cart($product);
        }else{
            return $this->create_new_product($product,$cart_exist->id);
        }
        
    }

    public function create_new_cart(Product $product){
        // create the new cart

        $new_cart = Cart::create([
            'user_id'   => Auth::user()->id,
        ]);

        // add the product in details_carts 
        return $this->create_new_product($product,$new_cart->id);

    }

    public function create_new_product(Product $product,$cart_id){

        $product_exist = DetailsCart::where('cart_id',$cart_id)
                        ->where('product_id',$product->id)
                        ->first();
        
        if(!$product_exist){
            
            DetailsCart::create([
                'cart_id'   => $cart_id,
                'product_id'=> $product->id,
            ]);
            return redirect()->back()->with('success_add_product','Product '.$product->title.' added successfully');
        }else{
            return redirect()->back()->with('errorAddProduct','Product '.$product->title.' already exist in the cart');
        }

    }

    public function getCartCount(){

        if(Auth::check()){

            $cart = Cart::latest()->where('user_id',Auth::user()->id)->first();

            $cart_count = 0;
            
            if($cart){
                
                $cart_count = DetailsCart::where('cart_id',$cart->id)->count();

            }
            return $cart_count;
        }

        return 0; 
    }

    public function index(){

        $cart = Cart::where('user_id',Auth::user()->id)->first();

        $cart_products = NULL;

        if($cart){
            $cart_products = DetailsCart::where('cart_id',$cart->id)->get();
        }

        return view('cart',compact('cart_products'));
    }

    // this update use in API 
    public function update(Request $request){

        $cart = DetailsCart::find($request->cart_id);

        if($cart){
            if(intval($request->quantity) <= $cart->product->quantity){
                if(intval($request->quantity) > 0){
                    $cart->update([
                        'quantity'  => intval($request->quantity),
                    ]);
                }else{
                    $cart->update([
                        'quantity'  => 1,
                    ]);
                }
                
                $carts_related = DetailsCart::where('cart_id',$cart->cart_id)->get();
                $total_price = 0;
                foreach($carts_related as $carts){
                    $total_price += $carts->quantity * $carts->product->price;
                }
                return response()->json([
                    'status'        => true,
                    'total_price'   => $total_price,
                ]);
                // return redirect()->back()->with('successMessage','quantity updated for '.$cart->product->title);
            }else{
                return response()->json(['msg' => 'false quantity']);
                // return redirect()->back()->with('errorMessage','you was enter a quantity indisponible');
            }
        }

        return Response()->json(['msg'  => 'error']);
        
        
    }

    public function destroy(DetailsCart $cart){
        $cart->delete();
        return redirect()->back()->with('successMessage','Product '.$cart->product->title.' deleted with success');
    }
}