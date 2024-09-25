@extends('layouts.app')

@section('content')
<div class="container">
    <div class="order-page">
        <h2 class="text-primary my-3">Order</h2>
        @if (session('successMessage'))
            <div class="my-3 alert alert-success fw-bold">{{session('successMessage')}}</div>
        @endif
        @if (session('errorMessage'))
            <div class="my-3 alert alert-danger fw-bold">{{session('errorMessage')}}</div>
        @endif
        @if (count($cart_products))
        
            <div class="row">
                <div class="col-md-8">
                    <form role="form" 
                    action="{{ route('orders.store') }}" 
                    method="post" >
                        @csrf
                        @if (count($addresses))
                            @foreach ($addresses as $address)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        
                                            <div class="input-group">
                                                <div class="input-group-text me-3">
                                                <input class="form-check-input mt-0" type="radio" name="address_ship" value="{{$address->id}}" aria-label="Radio button for following text input">
                                                </div>
                                            </div>
                                            <div class="mt-3 ms-3">
                                                <p>{{$address->address}}</p>
                                                <p>{{$address->phone}}</p>
                                            </div>

                                    </div>
                                </div>
                            @endforeach
                        
                        @endif
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                
                                    @if (count($addresses))
                                        
                                        <div class="input-group align-items-center">
                                            <div class="input-group-text me-3">
                                            <input class="form-check-input mt-0" type="radio" name="address_ship" value="new_address" aria-label="Radio button for following text input" checked>
                                            </div>
                                            <h6 class="text-capitalize text-info m-0">new address</h6>
                                        </div>

                                    @endif
                                    <div class="mt-3 ms-3">
                                        <div class="row align-items center mb-5">
                                            <label for="name" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">name</label>
                                            <p class="col-md-8">{{Auth::user()->name}}</p>
                                        </div>
                                        <div class="form-group mb-5 row align-items-center">
                                            <label for="country" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">country</label>
                                            <div class="col-md-8">
                                                <select name="country" id="country" class="form-select">
                                                    <option hidden>Chose your country</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-5">
                                            <label for="state" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">state</label>
                                            <div class="col-md-8">
                                                <select name="state" id="state" class="form-select">
                                                    <option hidden>Chose your state</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-5">
                                            <label for="address" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">address</label>
                                            <div class="col-md-8">
                                                <input type="text" name="address" value="{{old('address')}}" id="address" placeholder="Enter your address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-5">
                                            <label for="phone" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">phone</label>
                                            <div class="col-md-8">
                                                <div class="input-group mb-3">
                                                    <div class="col-3">
                                                        <select name="code_phone" id="code_phone" class="form-select">
                                                            <option hidden>code</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <input type="text" name="phone" value="{{old('phone')}}" class="form-control" id="phone" aria-label="Text input with dropdown button" placeholder="Your phone number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                        
                        <div class="form-check form-switch mb-5">
                            <input class="form-check-input" name="terms_conditions" type="checkbox" value="yes" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">use Terms and conditions</label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">Proceed to Checkout <i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </form>   
                
                    @if ($errors->any)
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li class="fw-bold text-danger">{{$error}}</li>
                            @endforeach
                            
                        </ul>
                    @endif            
                </div>
                <div class="col-md-4">

                        @php
                            $total = 0;
                        @endphp
                        <div class="border rounded p-3">
                        @foreach ($cart_products as $cart)
                        @php
                            $images = json_decode($cart->product->images);
                        @endphp
                        <div class="row align-items-center bg-light pb-2 rounded">
                            <div class="col-5  text-md-center"><img src="{{asset('storage/'.$images[0])}}"  width="50" alt="{{$cart->product->title}} image" /></div>
                            <div class="col-7 ">
                                <div class="row">
                                    <div class="col-12 text-primary fw-bold">{{$cart->product->title}}</div>
                                    @if ($cart->attribute)
                                        @php
                                            $attribute = json_decode($cart->attribute);
                                        @endphp
                                        <div class="col-12 text-dark text-capitalize ">
                                            @foreach ($attribute as $attr)
                                                {{$attr}} 
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-12 text-danger fw-bold">${{$cart->product->price}}</div>
                                    <div class="col-12">
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
                    <div class="my-3 p-3 d-flex justify-content-between fw-bold" >
                        <h4>Total: </h4>
                        <span class="fs-4">$<span id="total-price">{{$total}}</span></span> 
                    </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center my-5 alert alert-info fw-bold">There are no product to order</div>
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

            // get all countrie
            $.ajax({
                type:'GET',
                url:'{{asset('json/countries.json')}}',
                dataType:'json',
                cache:false,
                success:function(data,status){
                    data.map(country=>{      
                        $('#country').append('<option value="'+country.name+'">'+country.name+'</option>');
                    })
                },
                error:function(xhr,textStatus,err){
                    console.log(err);
                }
            });
            // get all states of country when change the country field
            $('#country').on('change',function(){
                $.ajax({
                    type:'GET',
                    url:'{{asset('json/countries.json')}}',
                    dataType:'json',
                    cache:false,
                    success:function(data,status){
                        $('#state').html('<option hidden>Chose your state</option>');
                        let country_name = $('#country').val();
                        let states = data.find(country => country.name == country_name).states.map(state => {
                            $('#state').append('<option value="'+state.name+'">'+state.name+'</option>')
                        });
                        
                    },
                    error:function(xhr,textStatus,err){

                    }
                })      

            });
            // get code phone 
            $.ajax({
                type:'GET',
                url:'{{asset('json/countryPhoneCodes.json')}}',
                dataType:'json',
                cache:false,
                success:function(data,status){
                    data.map(country=>{    
                        $('#code_phone').append('<option class="phone_code" value="'+country.code+'">'+country.iso+'-'+country.code+'</option>')  
                    })
                },
                error:function(xhr,textStatus,err){
                    console.log(err);
                }
            });
        })
    </script>
@endsection
