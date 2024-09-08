<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\DetailsOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;

class CheckoutController extends Controller
{
    public function checkout($address_ship){

        $address = Address::find($address_ship);

        $cart_products = DetailsCart::where('cart_id',Cart::where('user_id',Auth::user()->id)->first()->id)->get();
        
        return view('checkout.index',compact('cart_products','address'));
    }

    public function checkout_store(Request $request){
        
        $request->validate([
            'payment'   => ['required','string'],
            'address'   => ['required','numeric','exists:addresses,id'],
        ]);

        if($request->payment == 'paypal'){

            return redirect()->route('paypal.payment');

        }elseif($request->payment == 'stripe'){

            $cart = Cart::where('user_id',Auth::user()->id)->first();
            $details_cart = DetailsCart::where('cart_id',$cart->id)->get();
            //   calculate the total price of the order
            $price = 0;
            foreach($details_cart as $d_cart){
                $price += $d_cart->quantity * $d_cart->product->price;
            }
            // pay to our stripe account
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
            Stripe\Charge::create ([
                    "amount" => $price * 100,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "Test payment" 
            ]);

            // create the new order 
            $order = Order::create([
                     'user_id'          => Auth::user()->id,
                     'ship_address'     => $request->address,
                     'payment_status'   => 'stripe',
                ]);
            // create the new details order
            foreach($details_cart as $d_cart){
                DetailsOrder::create([
                    'order_id'      => $order->id,
                    'product_id'    => $d_cart->product_id,
                    'product_title' => $d_cart->product->title,
                    'quantity'      => $d_cart->quantity,
                    'price'         => $d_cart->product->price, 
                ]);
                // soustraction the quantity of the products 
                $product = Product::find($d_cart->product_id);
                $product->update([
                    'quantity'  => ($product->quantity - $d_cart->quantity),
                ]);
                // delete the current details_cart 
                $d_cart->delete();
                
            }
            return redirect()->route('orders.index')->with('successMessage','Your Order was been successfull with stripe payment');
        }else{
            return redirect()->back()->with('errorMessage','something was wrong');
        }
        
    }
}
