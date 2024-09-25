@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
            <div class="container-fluid d-flex align-items-center">
                <a href="{{route('admin.dashboard.orders.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">orders</a>
                <span class="mx-3">/</span>
                <h2 class="h5 no-margin-bottom">Order {{$order->id}} from {{$order->user->name}}</h2>
          </div>
        </div>

        <div class="text-center">
            @if (session('successMessage'))
            <span class="fw-bold text-success my-4">{{session('successMessage')}}</span>
            @endif

            @if (session('errorMessage'))
                <span class="fw-bold text-danger my-4">{{session('errorMessage')}}</span>
            @endif
        </div>

        <div class="single-order-content m-3 m-md-5">
            <div class="row text-center fw-bold" id="table-titles">
                <div class="col">Num</div>
                <div class="col">Image</div>
                <div class="col">Title</div>
                <div class="col">Features</div>
                <div class="col">Quantity</div>
                <div class="col text-end">Unit Price</div>
            </div>
            
                    @php
                        $i = 1;
                        $total_price = 0;
                    @endphp
                    @foreach ($order->details_order as $unit_order)
                        <div class="row align-items-center text-center py-3">
                            <div class="col">{{$i}}</div>
                            <div class="col">
                                @if ($unit_order->product)
                                    @php
                                        $image = json_decode($unit_order->product->images)[0];
                                    @endphp
                                    <img src="{{asset('storage/'.$image)}}" alt="{{$unit_order->product_title}} image" width="50" />
                                @else
                                    <div class="my-2 text-danger text-capitalize">product deleted</div>
                                @endif
                            </div>
                            <div class="col">{{$unit_order->product_title}}</div>
                            <div class="col">
                                @if ($unit_order->attribute)
                                    @php
                                        $get_values = json_decode($unit_order->attribute);
                                        if($unit_order->product){
                                            $get_attributes = json_decode($unit_order->product->attributes)[0];
                                            
                                            for ($i=0; $i < count($get_values); $i++) { 
                                                echo '<div class="text-capitalize">';
                                                echo $get_attributes[$i].' : '.$get_values[$i];
                                                echo '</div>';
                                            }
                                        }else{
                                            for ($i=0; $i < count($get_values); $i++) { 
                                                echo '<div class="text-capitalize">';
                                                echo    $get_values[$i];
                                                echo '</div>';
                                            }
                                        }
                                    @endphp
                                @else
                                    <span class="text-danger fw-bold">NONE</span>
                                @endif
                            </div>
                            <div class="col">{{$unit_order->quantity}}</div>
                            <div class="col text-end">${{$unit_order->price}}</div>
                        </div>
                        @php
                            $i++;
                            $total_price += $unit_order->quantity * $unit_order->price;
                        @endphp
                    @endforeach
                
                <div class="d-flex justify-content-end gap-3 fw-bold text-info my-5">
                    Total: 
                    <span>${{$total_price}}</span>
                </div>
                <div class="d-flex justify-content-end gap-3">
                    
                    @if ($order->status == 'canceled')
                        <div class="fw-bold text-danger">Order has been cancelled</div>
                    @elseif($order->status == 'confirmed')
                        <div class="fw-bold text-success">Order Delivered succefully</div>
                    @elseif($order->status == 'delivered')
                        <div class="fw-bold text-info">Order Delivered , we wait confirm from customer</div>
                    @else
                        <a href="{{route('admin.dashboard.orders.cancel',$order->id)}}" class="btn btn-danger">Cancel</a>
                        @if ($order->status == 'pending')
                            <a href="{{route('admin.dashboard.orders.processing',$order->id)}}" class="btn btn-warning">Go to Processing <i class="fa-solid fa-chevron-right"></i></a>
                        @elseif($order->status == 'processing')
                            <a href="{{route('admin.dashboard.orders.shipping',$order->id)}}" class="btn btn-info">Got to Shipped <i class="fa-solid fa-chevron-right"></i></a>
                        @elseif($order->status == 'shipping')
                            <a href="{{route('admin.dashboard.orders.delivered',$order->id)}}" class="btn btn-success">Got to Dilivered <i class="fa-solid fa-chevron-right"></i></a>
                        @endif
                    @endif
                    
                </div>
                
        </div>
        

@endsection