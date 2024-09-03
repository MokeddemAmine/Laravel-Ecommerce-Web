@extends('layouts.app')

@section('content')
<div class="container">
    <div class="cart-page">
        <div class="d-flex my-3">
            <a href="{{route('orders.index')}}" class="text-primary fw-bold">Orders</a>
            <span class="mx-2">/</span>
            <span>Order {{$order->id}} (edit)</span>
        </div>
        @if (session('successMessage'))
            <div class="my-3 text-success fw-bold">{{session('successMessage')}}</div>
        @endif
        @if (session('errorMessage'))
            <div class="my-3 text-danger fw-bold">{{session('errorMessage')}}</div>
        @endif

        <div class="row" id="table-titles" style="display: none">
            <div class="col-md-3 fw-bold text-center">Product</div>
            <div class="col-md-3 fw-bold">Title</div>
            <div class="col-md-3 fw-bold text-center">Price</div>
            <div class="col-md-3 fw-bold text-center" style="width:120px;">Quantity</div>
        </div>
            @php
                $total = 0;
            @endphp
            @foreach ($order->details_order as $item)
                        @php
                            $image = json_decode($item->product->images)[0];
                        @endphp
                        <div class="row my-3 align-items-center bg-light p-3 rounded">
                            <div class="col-5 col-md-3 text-md-center"><img src="{{asset('storage/'.$image)}}"  width="100" alt="{{$item->product_title}} image" /></div>
                            <div class="col-7 col-md-9">
                                <div class="row">
                                    <div class="col-md-4 my-1 text-primary fw-bold">{{$item->product_title}}</div>
                                    <div class="col-md-4 my-1 text-md-center text-danger fw-bold">${{$item->price}}</div>
                                    <div class="col-md-4 my-1">
                                        <div class="row justify-content-between align-items-center">

                                        
                                            <div class="col-6"> 
                                                <div class="form-group row ms-1">
                                                    <div class="col-8 p-0">
                                                        <input type="hidden" class="item_id" name="item_id" value="{{$item->id}}">
                                                        <input type="number" min="1" max="{{$item->product->quantity}}" name="quantity"  value="{{$item->quantity}}" class="form-control quantity-product">
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{route('orders.destroy.item',$item->id)}}" method="POST" class="form-delete-item" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <div class="col-6 text-end">
                                                <button type="submit" class="border-0 text-danger fw-bold delete-item" title="delete product"><span class="close">&times;</span></button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        @php
                            $total += $item->price * $item->quantity;
                        @endphp
                    @endforeach
                    <div class="my-3 p-3 text-end fw-bold" ><span class="me-3">Total: </span> $<span id="total-price">{{$total}}</span> </div>

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
                changeitem(this);
                
            })
            $('.quantity-product').on('keyup',function(){
                changeitem(this);
                if($(this).val() > parseInt($(this).attr('max')) ){
                    $(this).val(1)
                }
            })
            function changeitem(that){
                let id_item = $(that).siblings('.item_id').val();
                 $.ajax({
                     method:'POST',
                    url:"{{route('orders.update')}}",
                     headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                     data:{
                            item_id:id_item,
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
            $('.delete-item').click(function(){
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
                        $(this).parent().siblings('.form-delete-item').submit();
                    }
                });
            })
        })
    </script>
@endsection
