@extends('layouts.app')
@section('title','eCommerce')

@section('content')
  
  @if ($home)
  <div class="hero_area">
    
    <!-- end header section -->
    <!-- slider section -->

    <section class="slider_section">
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box"> 
                      <h1>
                       {{$home->title}}
                      </h1>
                      <p>
                        {{$home->description}}
                      </p>
                      <a href="{{route('contact')}}">
                        Contact Us
                      </a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img style="width:600px" src="{{asset('storage/'.$home->image)}}" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          
        </div>
      </div>
    </section>

    <!-- end slider section -->
  </div>
  <!-- end hero area -->
  @endif

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Latest Products
        </h2>
      </div>
      @if (session('success_add_product'))
          <div class="alert alert-success">{{session('success_add_product')}}</div>
      @endif
      @if (session('errorAddProduct'))
      <div class="alert alert-danger">{{session('errorAddProduct')}}</div>
      @endif
      <div class="row">
        @if (count($products))
            @foreach ($products as $product)
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box">

                    @php
                        $images = json_decode($product->images);
                    @endphp
                    <div class="img-box">
                      <img src="{{asset('storage/'.$images[0])}}" alt="">
                    </div>
                    <div class="detail-box">
                      <h6>{!!Str::limit($product->title,30)!!}</h6>
                      <h6>
                        <span>${{$product->price}}</span>
                      </h6>
                    </div>
                    <div class="new">
                      <span>
                        New
                      </span>
                    </div>

                    
                    <div class="d-flex justify-content-between align-items-center">
                      
                      <form action="{{route('products.show',$product->slug)}}" method="POST">
                        @csrf
                        @method("GET")
                        <input type="hidden" name="window_width" class="window_width" />
                        <button type="submit" class="btn btn-info btn-sm text-capitalize">show more</button>
                      </form>
                      @if (!$product->quantity)
                        <span class="text-danger text-capitalize">indisponible</span>
                      @endif
                    </div>

                    
                </div>
              </div>
            @endforeach
        @else
            <div class="text-center text-info fw-bold ">There are no product exist</div>
        @endif
        
      </div>
      <div class="btn-box">
        <a href="{{route('shop')}}">
          View All Products
        </a>
      </div>
    </div>
  </section>

  <!-- end shop section -->








   
  @endsection

  @section('js-special')
      <script>
        $(document).ready(function(){

          // set the width of the current windwo (desktop , tablet or mobile)
          var width = window.innerWidth;

          // Set the width in the hidden input field
          $('.window_width').val(width);
        })
      </script>
  @endsection
