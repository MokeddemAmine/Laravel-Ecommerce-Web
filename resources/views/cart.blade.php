@extends('layouts.app')

@section('content')
<div class="container">
    <div class="cart-page">
        <h2 class="my-3 text-primary text-capitalize">shoppint cart</h2>
        @if (session('successMessage'))
            <div class="my-3 text-success fw-bold">{{session('successMessage')}}</div>
        @endif
        @if (session('errorMessage'))
            <div class="my-3 text-danger fw-bold">{{session('errorMessage')}}</div>
        @endif
        @if ($cart_products && count($cart_products))
        <div class="row" id="table-titles" style="display: none">
            <div class="col-md-3 fw-bold text-center">Product</div>
            <div class="col-md-3 fw-bold">Title</div>
            <div class="col-md-3 fw-bold text-center">Price</div>
            <div class="col-md-3 fw-bold text-center" style="width:120px;">Quantity</div>
        </div>
            @php
                $total = 0;
            @endphp
            @foreach ($cart_products as $cart)
                        @php
                            $images = json_decode($cart->product->images);
                        @endphp
                        <div class="row my-3 align-items-center bg-light p-3 rounded">
                            <div class="col-5 col-md-3 text-md-center"><img src="{{asset('storage/'.$images[0])}}"  width="100" alt="{{$cart->product->title}} image" /></div>
                            <div class="col-7 col-md-9">
                                <div class="row">
                                    <div class="col-md-4 my-1 text-primary fw-bold">{{$cart->product->title}}</div>
                                    <div class="col-md-4 my-1 text-md-center text-danger fw-bold">${{$cart->product->price}}</div>
                                    <div class="col-md-4 my-1">
                                        <div class="row justify-content-between align-items-center">

                                        
                                            <div class="col-6"> 
                                                <div class="form-group row ms-1">
                                                    <div class="col-8 p-0">
                                                        <input type="hidden" class="cart_id" name="cart_id" value="{{$cart->id}}">
                                                        <input type="number" min="1" max="{{$cart->product->quantity}}" name="quantity"  value="{{$cart->quantity}}" class="form-control quantity-product">
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{route('carts.destroy',$cart->id)}}" method="POST" class="form-delete-cart" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <div class="col-6 text-end">
                                                <button type="submit" class="border-0 text-danger fw-bold delete-cart" title="delete product"><span class="close">&times;</span></button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        @php
                            $total += $cart->product->price * $cart->quantity;
                        @endphp
                    @endforeach
                    <div class="my-3 p-3 text-end fw-bold" ><span class="me-3">Total: </span> $<span id="total-price">{{$total}}</span> </div>
                    <div class="my-3 text-end">
                        <a href="{{route('orders.create')}}" class="btn btn-warning btn-sm text-capitalize fw-bold">go to order <i class="fa-solid fa-chevron-right"></i></a>
                    </div>
        @else
            <div class="text-center my-5 alert alert-info fw-bold">There are no product in your cart</div>
        @endif

    </div>
</div>
@endsection

@section('js-special')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            
            var window_width = window.innerWidth;
            if(window_width >= 768){
                $('#table-titles').show();
            }

            // script for change the quantity of each product and return the total price with AJAX

            $('.quantity-product').on('change',function(){
                changeCart(this);
                
            })
            $('.quantity-product').on('keyup',function(){
                changeCart(this);
                if($(this).val() > parseInt($(this).attr('max')) ){
                    $(this).val(1)
                }
            })
            function changeCart(that){
                let id_cart = $(that).siblings('.cart_id').val();
                 $.ajax({
                     method:'POST',
                     url:'{{route("carts.update")}}',
                     headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                     data:{
                            cart_id:id_cart,
                            quantity:$(that).val(),
                     },
                     success:function(data,status,xhr){
                        $('#total-price').text(data.total_price)
                     },
                     error:function(xhr,status,err){

                     }
                 })
            }

            // event to delete product from carts
            $('.delete-cart').click(function(){
                swal.fire({
                    title:'Are You Sure want to delete this',
                    text:'this delete will be parmanent',
                    icon:'warning',
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if(result.isConfirmed){
                        $(this).parent().siblings('.form-delete-cart').submit();
                    }
                });
            })
        })
    </script>
@endsection
