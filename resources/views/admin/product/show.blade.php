@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
            <div class="container-fluid d-flex align-items-center">
                <a href="{{route('admin.dashboard.products.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">products</a>
                <span class="mx-3">/</span>
                <h2 class="h5 no-margin-bottom">{{$product->title}}</h2>
            </div>
        </div>
        @if (session('successMessage'))
            <div class="fw-bold text-success m-5">{{session('successMessage')}}</div>
        @endif
          <div class="products mx-3">
            
                <div class="card p-2">
                    @php
                        $images = json_decode($product->images);
                    @endphp
                    <div class="img-fluid">
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
                                        <div class="col-md-4 h-100">
                                          <img src="{{asset('storage/'.$images[$i])}}" alt="{{$product->title}}" class="w-100 h-100">
                                        </div>
                                        @if ($i+1 < count($images))
                                          <div class="col-md-4 h-100">
                                            <img src="{{asset('storage/'.$images[$i+1])}}" alt="{{$product->title}}" class="w-100 h-100">
                                          </div>
                                        @endif
                                        @if ($i+2 < count($images))
                                          <div class="col-md-4 h-100">
                                            <img src="{{asset('storage/'.$images[$i+2])}}" alt="{{$product->title}}" class="w-100 h-100">
                                          </div>
                                        @endif
                                      </div>

                                    </div>
                                @endfor
                            @else
                                @foreach ($images as $image)
                                  <div class="carousel-item w-100 h-100
                                  @if ($images[0] == $image )
                                      <?php echo 'active'; ?>
                                  @endif
                                  ">
                                    <img src="{{asset('storage/'.$image)}}" alt="{{$product->title}}" style="object-fit:contain !important" class="w-100 h-100">
                                  </div>
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
                    <div class="card-body">
                      <h5 class="card-title text-white">{{$product->title}}</h5>
                      <p class="card-text text-white fs-6">{{$product->description}}</p>
                      <h4 class="cart-title text-primary d-flex justify-content-between align-items-center">
                        <span >${{$product->price}}</span>
                      </h4>
                       <div class="text-end">
                        <a href="{{route('admin.dashboard.products.edit',$product->id)}}" class="btn btn-success">Edit</a>
                        <form action="{{route('admin.dashboard.products.destroy',$product->id)}}" method="post" class="form-delete-product d-none">
                          @csrf
                          @method('DELETE')
                        </form>
                        <button class="btn btn-danger delete-single-product">Delete</button>
                       </div>
                      
                    </div>
                </div>
            
          </div>
        
        

@endsection

@section('js-special')
<script>
    $(document).ready(function(){
        $('.delete-single-product').click(function(){
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
                    $(this).siblings('.form-delete-product').submit();
                }
            });
        })

        var widthWindow = window.innerWidth;

    })
    
</script>
@endsection  