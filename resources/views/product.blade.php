@extends('layouts.app')
@section('title','shop')
    
@section('content')
    

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
              <h2 class="my-3 fw-bold fs-2 text-primary">{{$product->title}}</h2>
              <div class="box rounded">
                @php
                    $images = json_decode($product->images);
                @endphp

                <div class="img-fluid" >
                <div id="carouselProduct{{$product->id}}" class="carousel slide w-100 h-100">
                    <div class="carousel-inner w-100 h-100">
                        @if ($window_width > 767)
                            
                        
                            @for ($i = 0; $i < count($images); $i+=3)
                                <div class="carousel-item w-100 h-100
                                @if ($i == 0 )
                                    <?php echo 'active'; ?>
                                @endif
                                ">
                                <div class="row w-100 h-100">
                                    <div class="col-md-4 h-100 image-clicked" data-image="{{$i}}" data-bs-toggle="modal" data-bs-target="#imagesModal" style="cursor: pointer">
                                    <img src="{{asset('storage/'.$images[$i])}}" alt="{{$product->title}}" class="w-100 h-100">
                                    </div>
                                    @if ($i+1 < count($images))
                                    <div class="col-md-4 h-100 image-clicked" data-image="{{$i+1}}" data-bs-toggle="modal" data-bs-target="#imagesModal" style="cursor: pointer">
                                        <img src="{{asset('storage/'.$images[$i+1])}}" alt="{{$product->title}}" class="w-100 h-100">
                                    </div>
                                    @endif
                                    @if ($i+2 < count($images))
                                    <div class="col-md-4 h-100 image-clicked" data-image="{{$i+2}}" data-bs-toggle="modal" data-bs-target="#imagesModal" style="cursor: pointer">
                                        <img src="{{asset('storage/'.$images[$i+2])}}" alt="{{$product->title}}" class="w-100 h-100">
                                    </div>
                                    @endif
                                </div>

                                </div>
                            @endfor
                        @else
                                @php
                                    $i=0;
                                @endphp
                            @foreach ($images as $image)
                            <div class="image-clicked carousel-item w-100 h-100
                            @if ($images[0] == $image )
                                <?php echo 'active'; ?>
                            @endif
                            " data-image="{{$i}}">
                                <img src="{{asset('storage/'.$image)}}" alt="{{$product->title}}" style="object-fit:contain !important" class="w-100 h-100">
                            </div>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        @endif
                    </div>
                    @if (count($images) > 3 || ($window_width < 768 && count($images) > 1))

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
            <div class="modal fade" id="imagesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">{{$product->title}}</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselProduct" class="carousel slide w-100 h-100">
                            <div class="carousel-inner w-100 h-100">
                                    @php $i=0; @endphp

                                    @foreach ($images as $image)
                                    <div class="image-click-<?=$i;?> image-clicked-send carousel-item w-100 h-100">
                                        <img src="{{asset('storage/'.$image)}}" alt="{{$product->title}}" style="object-fit:contain !important" class="w-100 h-100">
                                    </div>

                                    @php $i++; @endphp

                                    @endforeach
                            </div>
        
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
        
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            <div class="detail-box mt-4">
                <h6 class="text-primary fw-bold">{{$product->title}}</h6>
                <h6>
                  <span>${{$product->price}}</span>
                </h6>
            </div>
            <div class="detail-box">
                <h6>Category: {{$product->category->name}}</h6>
            </div>
            <div class="detail-box">
                <p class="ms-3">{{$product->description}}</p>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-warning">To Cart</button>
                <buttn class="btn btn-danger ms-3">Buy</buttn>
            </div>
        </div>
        @if (count($related_products))
            <h2 class="my-4 text-secondary text-capitalize">related products</h2>
            <div class="row">
                    @foreach ($related_products as $product)
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
                            <form action="{{route('products.show',$product->id)}}" method="POST">
                              @csrf
                              @method("GET")
                              <input type="hidden" name="window_width" id="window_width" />
                              <input type="submit" value="Show More" class="border-0 text-primary">
                            </form>
                        </div>
                      </div>
                    @endforeach
                
              </div>
        @endif
    </div>
  </section>

  @endsection
  <!-- end shop section -->

  @section('js-special')
      <script>
        $(document).ready(function(){
            $('.image-clicked').click(function(){
                console.log('click');
                $image = $(this).data('image');
                console.log($image);
                $('.image-click-'+$image).addClass('active');
            })

            $('#imagesModal').on('hide.bs.modal',function(){
                $('.image-clicked-send').removeClass('active');
            })
        })
      </script>
  @endsection
