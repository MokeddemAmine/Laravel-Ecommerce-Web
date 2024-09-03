<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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

}
