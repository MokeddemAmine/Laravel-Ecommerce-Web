<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\DetailsOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{


    public function payment(){

        $cart = Cart::where('user_id',Auth::user()->id)->first();
        $details_cart = DetailsCart::where('cart_id',$cart->id)->get();
        //   calculate the total price of the order
        $price = 0;
        foreach($details_cart as $d_cart){
            $price += $d_cart->quantity * $d_cart->product->price;
        }

        $data = [];
        $data['items'] = [];
        $price = 0;
        foreach($details_cart as $d_cart){
            $data['items'][] = [
                'name' => $d_cart->product->title,
                'price' => $d_cart->product->price,
                'qty'   => $d_cart->quantity,
            ];
            $price += $d_cart->product->price * $d_cart->quantity;
        }
        $data['invoice_id'] = md5(uniqid(rand(), true));
        $data['invoice_description'] = "Order ".$data['invoice_id'];
        $data['return_url'] = route('paypal.success');
        $data['cancel_url'] = route('paypal.cancel');
        $data['total'] = $price;

        $provider = new ExpressCheckout();
        $response = $provider->setExpressCheckout($data,true);

        return redirect($response['paypal_link']);
    }

    public function success(Request $request){
        $provider = new ExpressCheckout();
        $response = $provider->getExpressCheckoutDetails($request->token);

        $cart = Cart::where('user_id',Auth::user()->id)->first();
        $details_cart = DetailsCart::where('cart_id',$cart->id)->get();

        // create the new order
        $order = Order::create([
            'user_id'          => Auth::user()->id,
            'address_id'     => $request->address,
            'payment_status'   => 'paypal',
            ]);
        // create the new details order
        foreach($details_cart as $d_cart){
            DetailsOrder::create([
                'order_id'      => $order->id,
                'product_id'    => $d_cart->product_id,
                'product_title' => $d_cart->product->title,
                'attribute'     => $d_cart->attribute?$d_cart->attribute:null,
                'quantity'      => $d_cart->quantity,
                'price'         => $d_cart->product->price, 
            ]);
            // delete the current details_cart 
            $d_cart->delete();
        }
        
        return redirect()->route('orders.index')->with('successMessage','payment was success with paypal');
    }

    public function cancel(){
        return redirect()->route('orders.create')->with('errorMessage','payment was failed');
    }

}
