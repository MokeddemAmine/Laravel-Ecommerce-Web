@extends('admin.layouts.app')

@section('title','Admin Dashboard Categories')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid d-flex align-items-center">
            <a href="{{route('admin.dashboard.categories.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">categories</a>
            <span class="mx-3">/</span>
            <h2 class="h5 no-margin-bottom text-capitalize">{{$category->name}}</h2>
          </div>
        </div>
        <div class="products">
          @if (count($products))
          <div class="row products mx-3">
            @foreach ($products as $product)
              <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="card p-2">
                    @php
                        $images = json_decode($product->images);
                    @endphp
                    <div class="img-fluid">
                      <div id="carouselProduct{{$product->id}}" class="carousel slide w-100 h-100">
                        <div class="carousel-inner w-100 h-100">
                          @foreach ($images as $image)
                            <div class="carousel-item w-100 h-100
                             <?php if($image == $images[0]) echo 'active'; ?>
                            ">
                              <img src="{{asset('storage/'.$image)}}" alt="{{$product->title}}"  class="w-100 h-100">
                            </div>
                          @endforeach
                        </div>
                        @if (count($images) > 1)
                          <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct{{$product->id}}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                          </button>
                          <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct{{$product->id}}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                          </button>
                        @endif
                      </div>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title text-white">{{$product->title}}</h5>
                      <p class="card-text text-white fs-6">{!!Str::limit($product->description,60)!!}</p>
                      <h4 class="cart-title text-primary d-flex justify-content-between align-items-center">
                        <form action="{{route('admin.dashboard.products.show',$product->id)}}" method="POST" class="d-inline-block">
                          @csrf
                          <input type="submit" value="Show More" class="btn btn-primary">
                          <input type="hidden" name="window_width" class="window_width">
                        </form>
                        
                        <span >${{$product->price}}</span>
                      </h4>
                       <div class="text-center product-action">
                        <a href="{{route('admin.dashboard.products.edit',$product->id)}}" class="fw-bold text-success d-inline-block me-3">Edit</a>
                        <form action="{{route('admin.dashboard.products.destroy',$product->id)}}" method="post" class="form-delete-product d-none">
                          @csrf
                          @method('DELETE')
                        </form>
                        <span class="fw-bold text-danger delete-product" style="cursor: pointer">Delete</span>
                       </div>
                      
                    </div>
                </div>
              </div> 
            @endforeach
          </div>
          <div class="d-flex justify-content-center align-items-center">
            {{$products->onEachSide(1)->links()}}
          </div>
        @else
            <div class="alert alert-info mx-5">There are no product now</div>
        @endif
          
        </div>


@endsection