<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailsCart;
use App\Models\DetailsOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function __construct()
    {
        if(Auth::guard('admin')->check()){
            $this->middleware('auth:admin')->except('create','store','confirmOrder');
        }else{
            $this->middleware('auth')->only('index','show','create','store','edit','update','cancelOrder','confirmOrder');
        }
        // $this->middleware('auth:web')->except('show','cancelOrder','processOrder');
        // $this->middleware('auth:admin')->only('index','show','cancelOrder','processOrder');
    }

    public function index(){

        
        if(Auth::guard('admin')->check()){
            $orders = Order::orderBy('id', 'desc')->get();
            return view('admin.order.index',compact('orders'));
        }else{
            $orders = Order::where('user_id',Auth::user()->id)->get();
            return view('order.index',compact('orders'));
        }
        

    }

    public function show(Order $order){
        if(Auth::guard('admin')->check()){
            return view('admin.order.show',compact('order'));
        }else{
            if($order->user_id == Auth::user()->id){
                return view('order.show',compact('order'));
            }else{
                return view('index');
            }
        }  
    }

    public function cancelOrder(Order $order){
        if(Auth::guard('admin')->check()){
            $order->update([
                'status'    => 'canceled'
            ]);
            return redirect()->back()->with('successMessage','Order cancelled with success');
        }else{
            if($order->user_id == Auth::user()->id){
                $order->update([
                    'status'    => 'canceled'
                ]);
                return redirect()->back()->with('successMessage','Order cancelled with success');
            }else{
                return redirect()->route('orders.index');
            }
        }
        
    }

    public function processOrder(Order $order){
        $order->update([
            'status'    => 'processing'
        ]);
        return redirect()->back()->with('successMessage','Order was be processed');
    }
    public function shipOrder(Order $order){
        $order->update([
            'status'    => 'shipping'
        ]);
        return redirect()->back()->with('successMessage','Order was be shipped');
    }

    public function deliverOrder(Order $order){
        $order->update([
            'status'    => 'delivered'
        ]);
        return redirect()->back()->with('successMessage','Order was be delivered');
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

        return view('order.edit',compact('order'));
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

    public function print(Order $order){
        
        
        $pdf = Pdf::loadView('admin.order.invoice',compact('order'));
        
        return $pdf->stream('order-'.$order->id.'.pdf');
        return view('admin.order.invoice',compact('order'));
    }

    public function create(){

        $cart = Cart::where('user_id',Auth::user()->id)->first();

        $cart_products = NULL;

        if($cart){
            $cart_products = DetailsCart::where('cart_id',$cart->id)->get();
            
        }

        return view('order.create',compact('cart_products'));
    }

    public function store(Request $request){

        $request->validate([
            'country'           => ['required','string','not_in:Chose your country'],
            'state'             => ['required','string','not_in:Chose your state'],
            'address'           => ['required','string'],
            'code_phone'        => ['required','string','not_in:code'],
            'phone'             => ['required','Numeric'],
            'pay'               => ['required','string','accepted'],
            'terms_conditions'  => ['required','string','accepted'],
        ]);

        $address    = $request->country.' '.$request->state.' '.$request->address;
        $phone      = $request->code_phone.$request->phone;

        // get the current cart with all products for ordering
        $cart = Cart::where('user_id',Auth::user()->id)->first();
        $details_cart = DetailsCart::where('cart_id',$cart->id)->get();

        // create the new order
        $order = Order::create([
             'user_id'  => Auth::user()->id,
             'address'  => $address,
             'phone'    => $phone,
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
        
        return redirect()->route('carts.show',Auth::user()->id)->with('successMessage','Thank you. Your order has been received');
    }
}
