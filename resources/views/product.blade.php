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
                
              <h2 class="my-3 fw-bold fs-2 text-danger">{{$product->title}}</h2>
              <form method="post" action="{{route('carts.store',$product->id)}}" class="box rounded bg-dark text-white p-3">
                @csrf
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
                <h6 class="text-danger fw-bold">{{$product->title}}</h6>
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
            <div class="detail-attributes">
                @if ($product->attributes)
                    <?php 
                        $attributes = json_decode($product->attributes);
                        if(count($attributes) > 1){
                        $attributes_name = json_decode($product->attributes)[0];
                        $attributes_value = [];
                        $quantity = 0;
                        for($j = 0 ; $j < count($attributes_name) ; $j ++){
                            echo '<div class="attributes-values" data-attribute="'.$attributes_name[$j].'">';
                            echo '<h6 class="text-capitalize text-info fw-bold" data-attribute="'.$attributes_name[$j].'">'.$attributes_name[$j].'</h6>';
                            for($i = 1 ; $i < count($attributes) ; $i++){
                                if(!in_array($attributes[$i][$j],$attributes_value)){
                                    $attributes_value[] = $attributes[$i][$j];
                    ?>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="{{$attributes_name[$j]}}" id="{{$attributes_name[$j].'-'.$attributes[$i][$j]}}" value="{{$attributes[$i][$j]}}">
                                        <label class="form-check-label attribute-value check-attribute text-dark" data-value="{{$attributes[$i][$j]}}" for="{{$attributes_name[$j].'-'.$attributes[$i][$j]}}">{{$attributes[$i][$j]}}</label>
                                    </div>
                    <?php 

                                    
                                }
                                
                            }
                            echo '</div>';
                        }
                    }
                        
                    ?>
                @endif
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                @if ($product->quantity)
                    <button type="submit" class="btn btn-outline-danger btn-sm text-capitalize">add to cart</button>
                @else
                    <span class="text-danger text-capitalize">indisponible</span>
                @endif
            </div>
        </form >
        @if ($errors->any)
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold text-danger">{{$error}}</li>
                        @endforeach
                        
                    </ul>
                @endif
        @if (count($related_products))
            <h2 class="my-4 text-secondary text-capitalize">related products</h2>
            <div class="row">
                    @foreach ($related_products as $product_related)
                      <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box bg-dark text-white rounded">
                            @php
                                $images = json_decode($product_related->images);
                            @endphp
                            <div class="img-box">
                              <img src="{{asset('storage/'.$images[0])}}" alt="">
                            </div>
                            <div class="detail-box">
                              <h6>{!!Str::limit($product_related->title,30)!!}</h6>
                              <h6>
                                <span>${{$product_related->price}}</span>
                              </h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                
                                <a href="{{route('products.show',$product_related->slug)}}" class="btn btn-outline-info btn-sm text-light text-capitalize">show more</a>
                                @if (!$product_related->quantity)
                                  <span class="text-danger text-capitalize">indisponible</span>
                                @endif
                            </div>
                            
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
        
      
            var check_attribute = $('.check-attribute');
            check_attribute.click(function(){
                if($(this).hasClass('check-attribute')){
                    $(this).parent().siblings().children('.check-attribute').removeClass('active');
                    $(this).addClass('active');
                    var attributes = [];
                    var values = [];
                    $.each($('input[type="radio"]:checked'),function(index,value){
                        attributes.push($(this).attr('name'));
                        values.push($(this).val())
                    })
                    if(!attributes.includes($(this).parent().siblings('h6').data('attribute'))){
                        attributes.push($(this).parent().siblings('h6').data('attribute'))
                        values.push($(this).data('value'))
                    }else{
                        let get_index = attributes.indexOf($(this).parent().siblings('h6').data('attribute'));
                        values[get_index] = $(this).data('value');
                    }
                    console.log(attributes);
                    console.log(values);
                    
                    $.ajax({
                        type:'POST',
                        url:"{{route('carts.checkAttribute')}}",
                        dataType:'json',
                        cache:false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            attribute:attributes,
                            value:values,
                            product_id:"{{$product->id}}",
                        },
                        success:function(data){
                            console.log(data)
                            let array = [];
                            let keys = data[0];
                            let j = data[1].length;
                            
                                for(let k = 0 ; k < j ; k++){
                                    for(let i = 1 ; i < data.length ; i++){  
                                        if(!array.includes(data[i][k])){
                                            array.push(data[i][k]);
                                        }
                                    }
                                }
                            
                                
                                
                                $.each($('.attributes-values'),function(index,value){
                                    if(!keys.includes($(this).data('attribute'))){
                                        
                                        let inputs = $(this).find('.form-check-input');
                                        let labels = $(this).find('.form-check-label');
                                        $.each(inputs,function(index,value){
                                            $(this).removeAttr('disabled');
                                            if(!$(this).next('.from-check-label').hasClass('check-attribute')){
                                                $(this).next('.form-check-label').addClass('check-attribute');
                                            }
                                            
                                            if (array.indexOf($(this).val()) == -1) {
                                                $(this).attr('disabled','disabled');
                                                $(this).next('.form-check-label').removeClass('check-attribute');
                                            }
                                        })
                                    }
                                })
                                
                            
                            

                        },
                        error:function(xhr,error){
                            console.log(xhr,error);
                        }
                    })
                }
            })
        })
    </script>
  @endsection
  
