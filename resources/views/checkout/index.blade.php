@extends('layouts.app')

@section('content')
<div class="container">
    <div class="order-page">
        <h2 class="text-danger my-3">Checkout</h2>
        
        @if (session('successMessage'))
            <div class="my-3 alert alert-success fw-bold">{{session('successMessage')}}</div>
        @endif
        @if (session('errorMessage'))
            <div class="my-3 alert alert-danger fw-bold">{{session('errorMessage')}}</div>
        @endif
        @if ($address)
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3 bg-dark text-white">
                        <div class="card-body">
                            <h6 class="text-secondary text-capitalize">shipping address</h6>
                            <div class="my-3 ms-3">
                                <p>{{$address->address}}</p>
                                <p>{{$address->phone}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="my-3">
                        <div class="card bg-dark text-white my-3">
                            <h6 class="card-header d-flex justify-content-between align-items-center">
                                <span class="text-info">Stripe Payment</span>
                                <i class="fa-solid fa-chevron-right icon"></i>
                            </h6>
                            <div class="card-body" style="display: none">
                                <form role="form" 
                                action="{{ route('checkout.store') }}" 
                                method="post" 
                                class="require-validation"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                id="payment-form">
                                    @csrf
                                    <input type="hidden" name="address" value="{{$address->id}}" />
                                    <input type="hidden" name="payment" value="stripe" />
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Name on Card</label> 
                                            <input class='form-control bg-dark text-white' size='4' type='text'>
                                        </div>
                                    </div>
                
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Card Number</label> <input
                                                autocomplete='off' class='form-control card-number  bg-dark text-white' size='20'
                                                type='text'>
                                        </div>
                                    </div>
                
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC</label> <input autocomplete='off'
                                                class='form-control card-cvc  bg-dark text-white' placeholder='ex. 311' size='4'
                                                type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Expiration Month</label> <input
                                                class='form-control card-expiry-month  bg-dark text-white' placeholder='MM' size='2'
                                                type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Expiration Year</label> <input
                                                class='form-control card-expiry-year  bg-dark text-white' placeholder='YYYY' size='4'
                                                type='text'>
                                        </div>
                                    </div>
                
                                    <div class='form-row row my-3'>
                                        <div class='col-md-12 error form-group hide'>
                                            <div class='alert-danger alert'>Please correct the errors and try
                                                again.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <input type="submit" value="checkout" class="btn btn-danger text-capitalize">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card my-3 bg-dark text-white">
                            <h6 class="card-header d-flex justify-content-between align-items-center">
                                <span style="color:#0070BA !important">PayPal</span>
                                <i class="fa-solid fa-chevron-right icon"></i>
                            </h6>
                            <div class="card-body" style="display: none">
                                <form action="{{route('checkout.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="address" value="{{$address->id}}" />
                                    <input type="hidden" name="payment" value="paypal" />
                                    <div class="d-grid gap-2">
                                        <input type="text" name="email" placeholder="Enter your paypal email" class="form-control  bg-dark text-white">
                                        <input type="submit" value="PayPal" class="btn btn-primary" style="background-color: #0070BA !important;color:white">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                    <div class="row align-items-center bg-dark text-white mb-2 pb-2 rounded">
                        <div class="col-5  text-md-center"><img src="{{asset('storage/'.$images[0])}}"  width="50" alt="{{$cart->product->title}} image" /></div>
                        <div class="col-7 ">
                            <div class="row">
                                <div class="col-12 text-white fw-bold">{{$cart->product->title}}</div>
                                @if ($cart->attribute)
                                        @php
                                            $attribute = json_decode($cart->attribute);
                                        @endphp
                                        <div class="col-12 text-white text-capitalize ">
                                            @foreach ($attribute as $attr)
                                                {{$attr}} 
                                            @endforeach
                                        </div>
                                    @endif
                                <div class="col-12 text-danger fw-bold">${{$cart->product->price}}</div>
                                <div class="col-12">
                                    * {{$cart->quantity}} = ${{$cart->product->price * $cart->quantity}}
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
                        <span class="fs-4 text-danger">$<span id="total-price">{{$total}}</span></span> 
                    </div>
                    </div>
                </div>
                
                
                       
                
                    @if ($errors->any)
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li class="fw-bold text-danger">{{$error}}</li>
                            @endforeach
                            
                        </ul>
                    @endif            
                
                
            </div>
        @else
            <div class="text-center my-5 alert alert-info fw-bold">Cant Checkout</div>
        @endif

    </div>
</div>
@endsection

@section('js-special')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){

            // show and hide methods of payment
            $('.card-header').click(function(){
                let chevron = $(this).find('.icon');
                if(chevron.hasClass('fa-chevron-right')){
                    chevron.removeClass('fa-chevron-right');
                    chevron.addClass('fa-chevron-up');
                    $(this).siblings('.card-body').slideDown(200);
                }else{
                    chevron.removeClass('fa-chevron-up');
                    chevron.addClass('fa-chevron-right');
                    $(this).siblings('.card-body').slideUp(200);
                }
            })
        })
    </script>
    {{-- script for stripe payment --}}
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
    <script type="text/javascript">
      
        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/
        
        var $form = $(".require-validation");
        console.log($form.find('div.error'));
        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                             'input[type=text]', 'input[type=file]',
                             'textarea'].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
            $errorMessage.addClass('hide');
            
        
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
              }
            });
         
            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
            }
        
        });
          
        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];
                     
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    </script>
@endsection
