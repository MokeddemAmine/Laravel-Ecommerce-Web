@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Orders</h2>
          </div>
        </div>

        <div class="orders-content m-3 m-md-5">
            @if (count($orders))
            <div class="row my-3">
                <div class="col-1">#Num</div>
                <div class="col-3">Customer</div>
                <div class="col-3">Address</div>
                <div class="col-2">Phone</div>
                <div class="col-1">Status</div>
                <div class="col-2">Action</div>
            </div>
            
                    @foreach ($orders as $order)
                        <div class="row my-1 align-items-center">
                            <div class="col-md-1">
                                {{$order->id}}
                            </div>
                            <div class="col-md-3">
                                {{$order->user->name}}
                            </div>
                            <div class="col-md-3">
                                @if ($order->address_id)
                                    {{$order->address->address}}
                                @else
                                    <span class="fw-bold text-danger">NONE</span>
                                @endif
                                
                            </div>
                            <div class="col-md-2">
                                @if ($order->address_id)
                                {{$order->address->phone}}
                            @else
                                <span class="fw-bold text-danger">NONE</span>
                            @endif
                            </div>
                            <div class="col-md-1">
                                <span class="@if($order->status == 'pending' || $order->status == 'processing') text-warning @elseif($order->status == 'shipping' || $order->status == 'delivered') text-info @elseif($order->status == 'confirmed') text-success @elseif($order->status == 'canceled') text-danger @endif">{{$order->status}}</span>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin.dashboard.orders.show',$order->id)}}" class="text-capitalize btn btn-danger btn-sm">show</a>
                                <a href="{{route('admin.dashboard.orders.print',$order->id)}}" class="text-capitalize btn btn-secondary btn-sm" target="_blank">print</a>
                            </div>
                        </div>
                    @endforeach
                
            @else
                <div class="alert alert-info m-3 fw-bold">There are no order</div>
            @endif
        </div>

        <div class="text-center">
            @if (session('successMessage'))
            <span class="fw-bold text-success my-4">{{session('successMessage')}}</span>
            @endif

            @if (session('errorMessage'))
                <span class="fw-bold text-danger my-4">{{session('errorMessage')}}</span>
            @endif
        </div>
        

@endsection