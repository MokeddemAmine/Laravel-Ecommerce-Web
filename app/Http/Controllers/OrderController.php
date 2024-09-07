<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\DetailsOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


use Stripe;
use Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $orders = Order::where('user_id',Auth::user()->id)->get();
        return view('order.index',compact('orders'));

    }

    public function show(Order $order){

        if($order->user_id == Auth::user()->id){
            return view('order.show',compact('order'));
        }else{
            return view('index');
        }
         
    }

    public function cancelOrder(Order $order){

        if($order->user_id == Auth::user()->id){
            $order->update([
                'status'    => 'canceled'
            ]);
            return redirect()->back()->with('successMessage','Order cancelled with success');
        }else{
            return redirect()->route('orders.index');
        }
          
    }


    public function confirmOrder(Order $order){
        if($order->user_id == Auth::user()->id){
            $order->update([
                'status'    => 'confirmed'
            ]);
            return redirect()->back()->with('successMessage','Order was confirmed successfully');
        }else{
            return redirect()->back()->with('errorMessage','Something was wrong');
        }
    }

    public function edit(Order $order){

        $order_of_current_user = $order->user_id == Auth::user()->id;

        if($order_of_current_user){
            return view('order.edit',compact('order'));
        }
        return redirect()->route('orders.index');
        
    }
    public function update(Request $request){

        
        $item = DetailsOrder::find($request->item_id);

        if(intval($request->quantity) <= $item->product->quantity){
            if(intval($request->quantity) > 0){// verify quantity if positive
                $item->update([
                    'quantity'  => intval($request->quantity),
                ]);
            }else{
                $item->update([
                    'quantity'  => 1,
                ]);
            }
            
            // calculate the total price of the whole order
            $orders_related = DetailsOrder::where('order_id',$item->order_id)->get();
            $total_price = 0;
            foreach($orders_related as $orders){
                $total_price += $orders->quantity * $orders->product->price;
            }
            return response()->json([
                'status'        => true,
                'total_price'   => $total_price,
            ]);
        }

    }
    public function destroyItem(DetailsOrder $item){
        $order_of_item = Order::where('id',$item->order_id)->first();
        $user = Auth::user()->id == $order_of_item->user_id;
        if($user){

            $item->delete();
            // count if there are any item related with the order
            $count_items_of_order = DetailsOrder::where('order_id',$order_of_item->id)->get()->count();
            if(!$count_items_of_order){// check if the order has no item
                $order_of_item->update([
                    'status'    => 'canceled',
                ]);
                return redirect()->back()->with('successMessage','Order was cancelled');
            }
            return redirect()->back()->with('successMessage','product deleted with success');
        }
    }


    public function create(){
        
        // get the address of the current user if exist
        $addresses = Auth::user()->ship_address;

        $cart = Cart::where('user_id',Auth::user()->id)->first();

        $cart_products = NULL;

        if($cart){
            $cart_products = DetailsCart::where('cart_id',$cart->id)->get();   
        }
        return view('order.create',compact('cart_products','addresses'));
    }

    public function store(Request $request){

        
        $address_ship = null;

        if(is_numeric($request->address_ship)){
            $request->validate([
                'address_ship'      => ['required','numeric','exists:addresses,id'],
                'terms_conditions'  => ['required','string','accepted'],
            ]);

            $address_ship = intval($request->address_ship);
               
        }else{
            $request->validate([
                'country'           => ['required','string','not_in:Chose your country'],
                'state'             => ['required','string','not_in:Chose your state'],
                'address'           => ['required','string'],
                'code_phone'        => ['required','string','not_in:code'],
                'phone'             => ['required','Numeric'],
                'terms_conditions'  => ['required','string','accepted'],
            ]);

            $address = Address::create([
                'user_id'   => Auth::user()->id,
                'address'   => $request->country.' '.$request->state.' '.$request->address,
                'phone'     => $request->code_phone.$request->phone,
            ]);

            $address_ship = $address->id;

        }

        return redirect('checkout/'.$address_ship);

    }

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
                // delete the current details_cart 
                $d_cart->delete();
            }
            return redirect()->route('orders.index')->with('successMessage','Your Order was been successfull with stripe payment');
        }else{
            return redirect()->back()->with('errorMessage','something was wrong');
        }
        
    }
    
}
