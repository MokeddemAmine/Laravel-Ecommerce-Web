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
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>#Num</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->address}}</td>
                            <td>{{$order->phone}}</td>
                            <td>
                                <span class="@if($order->status == 'pending' || $order->status == 'processing') text-warning @elseif($order->status == 'shipping' || $order->status == 'delivered') text-info @elseif($order->status == 'confirmed') text-success @elseif($order->status == 'canceled') text-danger @endif">{{$order->status}}</span>
                            </td>
                            <td><a href="{{route('admin.dashboard.orders.show',$order->id)}}" class="text-capitalize">show</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                
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