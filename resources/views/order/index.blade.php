@extends('layouts.app')
@section('title','My orders')
@section('content')
<div class="container">
    <div class="order-page">
        <h2 class="text-primary my-3">My Orders</h2>
        @if (session('successMessage'))
            <div class="my-3 alert alert-success fw-bold">{{session('successMessage')}}</div>
        @endif
        @if (session('errorMessage'))
            <div class="my-3 alert alert-danger fw-bold">{{session('errorMessage')}}</div>
        @endif
        @if (count($orders))
        
            <row class="row fw-bold text-center mt-5 mb-3" id="order-header-table" style="display: none">
                <div class="col">#N Order</div>
                <div class="col">Address</div>
                <div class="col">Phone</div>
                <div class="col">Status</div>
                <div class="col">Actions</div>
            </row>
            
                @foreach ($orders as $order)
                <div class="row align-items-center text-center my-3 border-top pt-2">
                    <div class="col-md">{{$order->id}}</div>
                    <div class="col-md">
                        @if ($order->address_id)
                            {{$order->address->address}}
                        @else
                            <span class="fw-bold text-danger">NONE</span>
                        @endif 
                    </div>
                    <div class="col-md">
                        @if ($order->address_id)
                            {{$order->address->phone}}
                        @else
                            <span class="fw-bold text-danger">NONE</span>
                        @endif
                    </div>
                    <div class="col-md">
                        @if($order->status == 'pending' || $order->status == 'processing')
                            <span class="text-warning text-capitalize">{{$order->status}}</span>
                        @elseif($order->status == 'shipping' || $order->status == 'delivered')
                            <span class="text-info text-capitalize">{{$order->status}}</span>
                        @elseif($order->status == 'canceled')
                            <span class="text-danger text-capitalize">{{$order->status}}</span>
                        @elseif($order->status == 'confirmed')
                            <span class="text-success fw-bold text-capitalize">{{$order->status}}</span>
                        @endif
                    </div>
                    <div class="col-md">
                        @if($order->status == 'delivered')
                            <a href="{{route('orders.confirm',$order->id)}}" class="btn btn-success btn-sm text-capitalize mb-1 mb-lg-0 me-2 confirm-order">confirm</a>
                        @elseif($order->status == 'pending')
                            <a href="{{route('orders.destroy',$order->id)}}" class="btn btn-danger btn-sm text-capitalize mb-1 mb-lg-0 me-2 delete-order">cancel</a>
                        @endif
                        <a href="{{route('orders.show',$order->id)}}" class="btn btn-info btn-sm text-capitalize">show</a>
                    </div>
                </div>
                @endforeach
            
        @else
            <div class="text-center my-5 alert alert-info fw-bold">There are no order</div>
        @endif

    </div>
</div>
@endsection

@section('js-special')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            var window_with = window.innerWidth;
            if(window_with >= 768){
                $('#order-header-table').show();
            }
            
            $('.delete-order').click(function(e){
                e.preventDefault();
                swal.fire({
                    title:'Are You Sure want to delete this',
                    text:'the cancel can cost you up to 10% of your money. because of service of transform the money in banks.',
                    icon:'warning',
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if(result.isConfirmed){
                        window.location.href = $(this).attr('href');
                    }
                });
            })
            $('.confirm-order').click(function(e){
                e.preventDefault();
                swal.fire({
                    title:'Are You Sure want to confirm this',
                    text:'this confirmation set for confirm that the order was delivered successfully',
                    icon:'success',
                    showDenyButton: true,
                    confirmButtonText: "Confirm",
                    confirmButtonColor: "#30d685",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if(result.isConfirmed){
                        window.location.href = $(this).attr('href');
                    }
                });
            })
        })
    </script>
@endsection
