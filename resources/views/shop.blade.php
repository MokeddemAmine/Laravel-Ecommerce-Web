@extends('layouts.app')
@section('title','shop')
    
@section('content')
    

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
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
                <form action="{{route('products.show',$product->id)}}" method="POST">
                  @csrf
                  @method("GET")
                  <input type="hidden" name="window_width" id="window_width" />
                  <input type="submit" value="Show More" class="border-0 text-primary">
                </form>
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
