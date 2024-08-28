@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid d-flex align-items-center">
            <a href="{{route('admin.dashboard.products.store')}}" class="text-capitalize fw-bold text-decoration-none fs-5">products</a>
            <span class="mx-3">/</span>
            <h2 class="h5 no-margin-bottom">Create Product</h2>
          </div>
        </div>
            <form action="{{route('admin.dashboard.products.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="ms-5" style="max-width:800px">
                    @if (session('successMessage'))
                        <div class="alert alert-success">{{session('successMessage')}}</div>
                    @endif
                    <div class="form-group row align-items-center mb-3">
                        <label for="category" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">category</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <select name="category" id="category" class="form-select">
                                <option value="hidden">Chose a category</option>
                                @if (count($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="title" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">title</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <input type="text" name="title" placeholder="Enter the title of product" id="title" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="description" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">description</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <textarea name="description" id="description" class="form-control" placeholder="Enter a description for the product"></textarea>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="price" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">price</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <input type="text" name="price" placeholder="Enter the price of product" id="price" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="quantity" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">quantity</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <input type="number" name="quantity" placeholder="Enter the quantity of product" id="quantity" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form-group row mb-4">
                        <label for="images" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">images</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <input class="form-control" type="file" name="images[]" id="formFileMultiple" accept=".jpeg,.jpg,.png,.gif" multiple>
                        </div>
                        
                    </div>
                    <div class="form-group row mb-4">
                        <div class="d-grid gap-2 me-5 me-md-0 mb-4 flex-shrink-1">
                            <input type="submit" value="Add Produtct" class="btn btn-primary">
                        </div>
                        
                    </div>
                
                </div>
                @if ($errors->any())
                    <ul class="list-unstyled my-3">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold text-danger ms-3">{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                @if (session('errorMessage'))
                    <span class="fw-bold text-danger ms-3 my-3">{{session('errorMessage')}}</span>
                @endif
            </form>

            

       

        
        

@endsection

@section('js-special')
    <script>
        $(document).ready(function(){
            $i = 0;
            $('.custom-file-input').on('change', function() {
            var files = $(this)[0].files;
            var fileNames = [];
            for (var i = 0; i < files.length; i++) {
                fileNames.push(files[i].name);
            }
            $(this).next('.custom-file-label').html(fileNames.join(' /  '));
        });
        })
    </script>
@endsection

