@extends('layouts.app')
@section('title','My orders')
@section('content')
<div class="container">
    <div class="order-page">
        <div class="d-flex">
            <a href="{{route('orders.index')}}" class="text-primary fw-bold">My Orders</a>
            <span class="mx-2">/</span>
            <span>Orders N {{$order->id}}</span>
        </div>
        
        @if (session('successMessage'))
            <div class="my-3 alert alert-success fw-bold">{{session('successMessage')}}</div>
        @endif
        @if (session('errorMessage'))
            <div class="my-3 alert alert-danger fw-bold">{{session('errorMessage')}}</div>
        @endif

            <row class="row fw-bold text-center mt-5 mb-3" id="order-header-table" style="display: none">
                <div class="col">#N</div>
                <div class="col">Image</div>
                <div class="col">Title</div>
                <div class="col">Quantity</div>
                <div class="col">Unit Price</div>
            </row>
                @php
                    $total = 0;
                @endphp
                @foreach ($order->details_order as $item)
                @php
                    if($item->product_id)
                        $image = json_decode($item->product->images)[0];
                @endphp
                <div class="row align-items-center text-md-center my-3 border-top pt-2">
                    <div class="col-md">{{$item->id}}</div>
                    <div class="col-md">
                        @if ($item->product_id)
                            <img src="{{asset('storage/'.$image)}}" alt="{{$item->product_title}} image" width="100" />
                        @else
                            <div class="my-2 text-danger text-capitalize">product deleted</div>
                        @endif
                        
                    </div>
                    <div class="col-md">{{$item->product_title}}</div>
                    <div class="col-md">{{$item->quantity}}</div>
                    <div class="col-md text-danger">${{$item->price}}</div>
                </div>
                @php
                    $total += $item->price * $item->quantity;
                @endphp
                @endforeach
                <div class="text-end fw-bold my-5">
                    Total : <span class="text-danger">${{$total}}</span>
                </div>
                <div class="text-end">
                    @if ($order->status == 'pending' || $order->status == 'processing')
                        <span class="text-warning">The order is in pending or processing</span>
                        <a href="{{route('orders.destroy',$order->id)}}" class="btn btn-danger btn-sm text-capitalize delete-order">cancel Order</a>
                    @elseif($order->status == 'delivered')
                        <span class="text-info">The order was delivered</span>
                        <a href="{{route('orders.confirm',$order->id)}}" class="btn btn-success btn-sm text-capitalize confirm-order">confirm the delivered</a>
                    @elseif($order->status == 'shipping')
                        <span class="text-info">The order was shipped</span>
                    @elseif($order->status == 'confirmed')
                        <span class="text-success">The order was confirmed from yourself</span>
                    @elseif($order->status == 'canceled')
                        <span class="text-danger">The order was canceled</span>
                    @endif
                </div>

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
