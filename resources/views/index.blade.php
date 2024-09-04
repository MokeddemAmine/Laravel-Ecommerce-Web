@extends('layouts.app')
@section('title','eCommerce')

@section('content')
  
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
                        Welcome To Our Shop
                      </h1>
                      <p>
                        Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit. Nostrum fugit doloribus consequatur distinctio esse, possimus maiores aliquid repellat beatae cum, perspiciatis enim, accusantium perferendis.
                      </p>
                      <a href="{{route('contact')}}">
                        Contact Us
                      </a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img style="width:600px" src="{{asset('images/image3.jpeg')}}" alt="" />
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
                      <a href="{{route('carts.store',$product->id)}}" class="btn btn-warning btn-sm text-capitalize">add to cart</a>
                      <form action="{{route('products.show',$product->slug)}}" method="POST">
                        @csrf
                        @method("GET")
                        <input type="hidden" name="window_width" class="window_width" />
                        <input type="submit" value="Show More" class="border-0 text-primary">
                      </form>
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







  <!-- contact section -->

  <section class="contact_section ">
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          <form action="#">
            <div>
              <input type="text" placeholder="Name" />
            </div>
            <div>
              <input type="email" placeholder="Email" />
            </div>
            <div>
              <input type="text" placeholder="Phone" />
            </div>
            <div>
              <input type="text" class="message-box" placeholder="Message" />
            </div>
            <div class="d-flex ">
              <button>
                SEND
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <br><br><br>

  <!-- end contact section -->

   
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
