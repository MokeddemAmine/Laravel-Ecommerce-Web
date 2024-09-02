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
        $this->middleware('auth')->except('index','show','cancelOrder','processOrder');
        $this->middleware('auth:admin')->only('index','show','cancelOrder','processOrder');
    }

    public function index(){

        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.order.index',compact('orders'));

    }

    public function show(Order $order){
        return view('admin.order.show',compact('order'));
    }

    public function cancelOrder(Order $order){
        $order->update([
            'status'    => 'canceled'
        ]);
        return redirect()->back()->with('successMessage','Order cancelled with success');
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
