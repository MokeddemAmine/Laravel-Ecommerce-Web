@extends('layouts.app')
@section('title','shop')
    
@section('content')
    

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
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
                    <img src="{{asset('storage/'.$images[0])}}" alt="{{$product->title}} image">
                  </div>
                  <div class="detail-box">
                    <h6>{!!Str::limit($product->title,30)!!}</h6>
                    <h6>
                      <span>${{$product->price}}</span>
                    </h6>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    @if ($product->quantity)
                      <a href="{{route('carts.store',$product->id)}}" class="btn btn-warning btn-sm text-capitalize">add to cart</a>
                    @else
                      <span class="text-danger text-capitalize">indisponible</span>
                    @endif
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
          <div class="fw-bold  text-info my-3">There are no product</div>
        @endif
        
      </div>
      <div class="d-flex justify-content-center my-4">{{$products->onEachSide(1)->links()}}</div>
    </div>
  </section>

  @endsection
  <!-- end shop section -->
