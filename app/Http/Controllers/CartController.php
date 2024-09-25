<?php

namespace App\Http\Controllers;

use App\Models\Attribute as ModelsAttribute;
use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use WooCommerce\PayPalCommerce\AdminNotices\Repository\RepositoryInterface;
use WpOrg\Requests\Response;

class CartController extends Controller
{

    public function __construct(){
        
        $this->middleware('auth');
    }

    public function store(Request $request,Product $product){
        
        // verify if there are carts exist for the current user
        if($product->quantity){
            $attributes = [];
            if($product->attributes){
                // get the existing attributes of the current product
                $get_exist_attr = json_decode($product->attributes)[0];
                $validate_attr = [];
                foreach($get_exist_attr as $attr){
                    $validate_attr[$attr] = ['required','string','exists:details_attributes,value'];
                }
                
                // validate the attributes values
                $request->validate($validate_attr);
                // get values of attributes exists
                foreach($get_exist_attr as $attr){
                    $attributes[] = $request->input($attr);
                }
            }
            $cart_exist = Cart::where('user_id',Auth::user()->id)->first();
        
            if(!$cart_exist){
                return $this->create_new_cart($product,$attributes);
            }else{
                return $this->create_new_product($product,$cart_exist->id,$attributes);
            }
        }else{
            return redirect()->back()->with('errorMessage','indisponible product');
        }
        
    }

    public function create_new_cart(Product $product,$attributes){
        // create the new cart

        $new_cart = Cart::create([
            'user_id'   => Auth::user()->id,
        ]);

        // add the product in details_carts 
        return $this->create_new_product($product,$new_cart->id,$attributes);

    }

    public function create_new_product(Product $product,$cart_id,$attributes){

        if(count($attributes)){
            $product_exist = DetailsCart::where('cart_id',$cart_id)
                        ->where('product_id',$product->id)
                        ->where('attribute',json_encode($attributes))
                        ->first();
        }else{
            $product_exist = DetailsCart::where('cart_id',$cart_id)
                        ->where('product_id',$product->id)
                        ->first();
        }
        
        
        if(!$product_exist){
            DetailsCart::create([
                'cart_id'   => $cart_id,
                'product_id'=> $product->id,
                'attribute'=> count($attributes) ? json_encode($attributes):null,
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

    public function show(User $user){

        $cart = Cart::where('user_id',$user->id)->first();

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
            if(intval($request->quantity) <= $cart->product->quantity){// verify a valide quantity
                if(intval($request->quantity) > 0){// verify quantity if positive
                    $cart->update([
                        'quantity'  => intval($request->quantity),
                    ]);
                }else{
                    $cart->update([
                        'quantity'  => 1,
                    ]);
                }
                
                // calculate the total price of the whole cart
                $carts_related = DetailsCart::where('cart_id',$cart->cart_id)->get();
                $total_price = 0;
                foreach($carts_related as $carts){
                    $total_price += $carts->quantity * $carts->product->price;
                }
                return response()->json([
                    'status'        => true,
                    'total_price'   => $total_price,
                ]);
            }
        }     
        
    }

    public function destroy(DetailsCart $cart){
        $cart->delete();
        return redirect()->back()->with('successMessage','Product '.$cart->product->title.' deleted with success');
    }

    // function to return the attributes related with another attribute : json
    public function checkAttribute(Request $request){
        $product = Product::find($request->product_id);
        $attributes = json_decode($product->attributes);
        
        $indexes = [];

        for($k = 0; $k < count($request->attribute) ; $k++){
            for($j = 0; $j < count($attributes[0]) ; $j++){
                if($request->attribute[$k] ==  $attributes[0][$j]){
                    array_push($indexes,$j);
                }
            }
        }

        $get_values = [$request->attribute];
        for($j=1 ; $j < count($attributes) ; $j++){
            $k = 0;
            for($i = 0 ; $i < count($indexes) ; $i++){
                if($attributes[$j][$indexes[$i]] != $request->value[$k]){
                    $i = count($indexes);
                }else if($attributes[$j][$indexes[$i]] == $request->value[$k] && $i == (count($indexes) -1)){
                    
                    $array = $attributes[$j];
                    // return response()->json([$request->attribute[$i]]);
                    array_pop($array);
                    for($x = 0;$x < count($indexes) ; $x++){
                        unset($array[$indexes[$x]]);
                    }
                    
                    $array = array_values($array);
                    $get_values[] = $array;
                }
                $k++;
            }
        }

        return response()->json($get_values);
    }
}
