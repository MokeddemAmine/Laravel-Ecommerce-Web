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

            // edit the quantity of each product edit: 
            $details_order = DetailsOrder::where('order_id',$order->id)->get();
            foreach($details_order as $d_order){
                $product = Product::find($d_order->product_id);
                $product->update([
                    'quantity'  => ($product->quantity + $d_order->quantity),
                ]);
            }
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
    
}
