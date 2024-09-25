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
            <form action="{{route('admin.dashboard.products.update',$product->id)}}" method="POST" enctype="multipart/form-data" id="form-add-product">
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
                <div class="ms-3" style="max-width:800px">
                    @if ($product->attributes && count(json_decode($product->attributes)[0]))
                        
                    @endif
                    @if (count($attributes))
                        <span class="d-inline-block btn btn-dark border rounded-circle px-3 mb-3" id="add-attribute" title="click to add attribute" style="cursor: pointer">+</span>
                    @endif
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
                <div class="modal fade" id="modal-attributes" tabindex="-1" aria-labelledby="modal-attributes" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Quantities of attributes</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
                        </div>
                      </div>
                    </div>
                </div>
            </form>
            <div class="ms-3" style="max-width:800px">
                <div class="form-group row mb-4">
                    <div class="d-grid gap-2 me-5 me-md-0 mb-4 flex-shrink-1">
                        <button class="btn btn-primary" id="before-add" data-bs-toggle="modal" data-bs-target="#modal-attributes">Add Product</button>
                    </div>
                </div>
            </div>

            

       

        
        

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

            // add attribute
        let attr_id = 1;

        var attribute_select = $('.attribute-select');

        var close_attribute = $('.close-attribute');

        $('#add-attribute').click(function(){
            let get_attributes = $('.attribute-select');
            let add = true;
            if(get_attributes.length){
                $.each(get_attributes, function(index, value) {
                    if(value.value == 'Chose the attribute'){
                        add = false;  
                    }
                });
                
            }
            
            if(add){
                let values_selected = 
                $(this).before(`
                        <div class="attributes_added">
                            <div class="form-group row align-items-center mb-4">
                                <div class="text-end mb-2"><span style="cursor:pointer" class="close-attribute text-danger">&times;</span></div>
                                <label for="quantity" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">attributes</label>
                                <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                                    <select data-attr="${attr_id}" class="attribute-select form-select" name="attribute_${attr_id}">
                                        <option hidden>Chose the attribute</option>
                                        @foreach ($attributes as $attribute)
                                            <option value="{{$attribute->name}}">{{$attribute->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center mb-4" >
                                <label for="quantity" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">attribute values</label>
                                <div class="col-md-8">
                                        <div id="attribute-values-checked-${attr_id}" class="row">

                                        </div>
                                </div> 
                            </div>
                        </div>
                `);
            }else{
                $(this).before('<span class="d-block my-2 text-danger">first select the current attribute</span>');
            }
            attr_id++;

            $('.close-attribute').click(function(){
                $(this).parent().parent().parent().remove();
                attribute_select = $('.attribute-select'); 
                $('#modal-attributes .modal-body .col').remove();
            })
            
            
            // add attribute quantities before submit the form
            attribute_select = $('.attribute-select');
            change_attribute_select();
        })



        let id_attr = 1;
            // change values of each attribute selected
        function change_attribute_select(){
            
            attribute_select.on('change',function(){
                
                let id_select = $(this).data('attr');
                // get the selected name of the select tag
                let attr_name = $(this).val();
                // set the name of the select 
                $(this).attr('name',attr_name);
                $.ajax({
                        type:'GET',
                        url:"{{route('admin.dashboard.attributes.get.values')}}",
                        dataType:'json',
                        cache:false,
                        data:{
                            attribute:$(this).val()
                        },
                        success:function(data,status){
                            
                            $('#attribute-values-checked-'+id_select).html(' ');
                            let k = 1;
                            data.map(attr => {
                                
                                $('#attribute-values-checked-'+id_select).append(`
                                            <div class="form-check col-sm-6 col-md-3 col-xl-2">
                                                <input class="form-check-input" type="checkbox" value="${attr.value}" name="${attr_name}[]" id="flexCheckDefault-${attr.value}-${k}">
                                                <label class="form-check-label text-capitalize" for="flexCheckDefault-${attr.value}-${k}">
                                                ${attr.value}
                                                </label>
                                            </div>
                                `);
                                k++;
                            })
                        },
                        error:function(xhr,textStatus,err){

                        }
                })  
                id_attr++; 
            })
        }

        $('#before-add').click(function(e){
                
                $('#modal-attributes .modal-body .col').remove()
                
                if(attribute_select.length == 0){
                    $('#form-add-product').submit();
                }else{
                    var attribute_select_has_value = [];
                    attribute_select.each(function(index,value){
                        
                        let that = $(this);
                        if($(this).val() != 'Chose the attribute'){
                            let values_checked = $('#attribute-values-checked-'+$(this).data('attr')+' input[type=checkbox]:checked');
                            
                            if(values_checked.length){
                                attribute_select_has_value.push(that);
                                values_checked.each(function(){
                                    attribute_select_has_value.push($(this));
                                })
                            }
                        }else if($(this).val() == 'Chose the attribute' && index == 0){
                            $('#form-add-product').submit();
                        }
                    })
                    attribute_select_has_value = $().add(attribute_select_has_value);
                    let j = 0;
                    var attribute_name_value = {};
                    var attribute_name = null;
                    var attribute_values = [];
                    attribute_select_has_value.each(function(){

                        if($(this).hasClass('attribute-select')){
                            if(attribute_name){
                                attribute_name_value[attribute_name] = attribute_values;
                                attribute_values=[];
                            }
                            attribute_name = $(this).attr('name');
                            j++;
                        }else{
                            if(j){
                                attribute_values.push($(this).attr('value'));
                            }
                        }

                    })
                    attribute_name_value[attribute_name] = attribute_values;
                    let repeat_values = 1;
                    $.each(attribute_name_value,function(key,value){
                        let val = 1;
                        $.each(attribute_name_value,function(key2,value2){
                            if(key2 == key ){
                                val = 1;
                            }else{
                                val *= value2.length;
                            }
                        })
                        
                        
                        
                            $('#modal-attributes .modal-body').append(`
                                <div class="col text-center">
                                    <div class="text-danger text-capitalize fs-4 mb-3">${key}</div>
                                    <div class="${key}_attribute">
                                        
                                    </div>
                                </div>
                                        `);
                        for(let j = 1; j <= repeat_values ; j++){
                            value.forEach(values => {
                                $('.'+key+'_attribute').append('<div class="mb-1 text-capitalize">'+values+'</div>');
                                for(let i = 1 ;i< val ; i++){
                                    $('.'+key+'_attribute').append('<br/><div style="height:.25rem;"></div>');
                                }
                            })
                        }
                        repeat_values*=value.length;
                    })
                    $('#modal-attributes .modal-body').append(`
                                <div class="col text-center">
                                    <div class="text-danger text-capitalize fs-4 mb-3">quantity</div>
                                    <div class="quantity_attributes text-center">
                                        
                                    </div>
                                </div>
                    `);


                    // add input of quantity of each attribute
                    let values_attributes = [];
                    
                    $.each(attribute_name_value,function(key,values){
                        values_attributes.push(values);
                    })

                    if(values_attributes[0].length){
                        $('.quantity_attributes').append('<input type="hidden" name="quantity_attr" value="set" />');
                    }
                    
                    function set_values_attributes(array,i,name){
                        if(i == values_attributes.length -1){
                            array.forEach(function(value,index){
                                name+=value;
                                $('.quantity_attributes').append('<input type="number" name="'+name+'" class="form-control mx-auto input-quantity"/>');
                                name = name.slice(0,-value.length);
                            })
                            
                        }else{
                            array.forEach(function(value,index){
                                name+=value+'-';
                                set_values_attributes(values_attributes[i+1],i+1,name);
                                
                                name = name.slice(0,-value.length-1);
                            })
                            
                        }
                        
                    }
                    
                    set_values_attributes(values_attributes[0],0,'');
                        
                    $('#add-product').click(function(){
                        $('#form-add-product').submit();
                    })
                }

                
                
            })
        })
    </script>
@endsection

