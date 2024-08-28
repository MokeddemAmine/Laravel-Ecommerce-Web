@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid d-flex align-items-center">
            <a href="{{route('admin.dashboard.products.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">products</a>
            <span class="mx-3">/</span>
            <h2 class="h5 no-margin-bottom text-capitalize">{{$product->title}} (edit)</h2>
          </div>
        </div>
            @if (session('successMessage'))
            <div class="fw-bold ms-5 text-success">{{session('successMessage')}}</div>
            @endif
            <form action="{{route('admin.dashboard.products.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="ms-3" style="max-width:800px">
                    <div class="form-group me-3 row align-items-center mb-3">
                        <label for="category" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">category</label>
                        <div class="col-md-8  me-md-0 flex-shrink-1">
                            <select name="category" id="category" class="form-select">
                                <option value="hidden">Chose a category</option>
                                @if (count($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" @if ($category->id == $product->category_id)
                                            selected
                                        @endif>{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group me-3 row align-items-center mb-4">
                        <label for="title" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">title</label>
                        <div class="col-md-8  me-md-0 flex-shrink-1">
                            <input type="text" name="title" value="{{$product->title}}" placeholder="Enter the title of product" id="title" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form-group me-3 row align-items-center mb-4">
                        <label for="description" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">description</label>
                        <div class="col-md-8  me-md-0 flex-shrink-1">
                            <textarea name="description" id="description" class="form-control" placeholder="Enter a description for the product">{{$product->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group me-3 row align-items-center mb-4">
                        <label for="price" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">price</label>
                        <div class="col-md-8  me-md-0 flex-shrink-1">
                            <input type="text" value="{{$product->price}}" name="price" placeholder="Enter the price of product" id="price" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form-group me-3 row align-items-center mb-4">
                        <label for="quantity" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">quantity</label>
                        <div class="col-md-8  me-md-0 flex-shrink-1">
                            <input type="number" value="{{$product->quantity}}" name="quantity" placeholder="Enter the quantity of product" id="quantity" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form-group me-3 row mb-4">
                        <label for="images" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">New images</label>
                        <div class="col-md-8 me-md-0 flex-shrink-1">
                            <input class="form-control" type="file" name="images[]" id="formFileMultiple" accept=".jpeg,.jpg,.png,.gif" multiple>
                        </div>
                        
                    </div>
                    
                    
                
                </div>
                <div class="ms-3">
                    <div class="row w-100 mb-4">
                        <label for="images-exist" class="col-md-2 text-capitalize fs-4 mb-3 mb-md-0">exists Images</label>
                        <div class="col-md-10" id="images-exist">
                            <div class="row">
                                @php
                                    $images = json_decode($product->images);
                                @endphp
                                @foreach ($images as $image)
                                    <div class="col-sm-6 col-md-3 col-lg-2  mb-3 image" style="position: relative;">
                                        <span class="close fs-4 text-danger fw-bold" style="position: absolute;top:0;right:20px;cursor:pointer">&times;</span>
                                        <div class="mx-5 mx-sm-0">
                                            <img src="{{asset('storage/'.$image)}}" class="w-100 img-thumbnail" alt="" style="height:150px;object-fit:contain">
                                        </div>
                                        <span class="d-none image-name">{{$image}}</span>
                                    </div>
                                @endforeach
                                <input type="hidden" id="images-exist-name" name="images_exist_name" value="{{$product->images}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms-3 mb-4" style="max-width:800px">
                    <div class="row me-3">
                        <div class="d-grid gap-2 me-3 me-md-0 mb-4 flex-shrink-1">
                            <input type="submit" value="Update Produtct" class="btn btn-primary">
                        </div>
                        
                    </div>
                </div>
                @if ($errors->any())
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold text-danger ms-3">{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                @if (session('errorMessage'))
                    <span class="fw-bold text-danger m-5">{{session('errorMessage')}}</span>
                @endif
            </form>

            

       

        
        

@endsection

@section('js-special')
    <script>
        $(document).ready(function(){
            // script for adding images into images field

            $i = 0;
            $('.custom-file-input').on('change', function() {
                var files = $(this)[0].files;
                var fileNames = [];
                for (var i = 0; i < files.length; i++) {
                    fileNames.push(files[i].name);
                }
                $(this).next('.custom-file-label').html(fileNames.join(' /  '));
            });
            // script for delete images from images exists field when delete them

            $('#images-exist .image .close').click(function(){
                let image_name_deleted = $(this).siblings('.image-name').text();
                let get_images = JSON.parse($('#images-exist-name').val());
                console.log(image_name_deleted)
                console.log(get_images)
                let new_images = JSON.stringify(get_images.filter(function(image){
                    return image != image_name_deleted;
                }));
                console.log(new_images);
                $('#images-exist-name').val(new_images);
                $(this).parents('.image').remove();
            })
        })
    </script>
@endsection

