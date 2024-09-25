@extends('admin.layouts.app')

@section('title','Admin Dashboard Attributes')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Show All Attributes</h2>
          </div>
        </div>
        @if (session('successMessage'))
            <div class="fw-bold text-success m-5">{{session('successMessage')}}</div>
        @endif
        <a href="{{route('admin.dashboard.attributes.create')}}" class="btn btn-primary my-3 mx-5">Add New Attribute</a>
        <div class="container">
            @if (count($attributes))
            <div class="row attributes text-center" style="display: none">
                <div class="col-1">#num</div>
                <div class="col-2">Name</div>
                <div class="col-6">Values</div>
                <div class="col-3">Actions</div>
            </div>
          
            @foreach ($attributes as $attribute)
                <div class="row align-items-center attribute my-3 text-md-center">
                <div class="col-md-1">{{$attribute->id}}</div>
                <div class="col-md-2">{{$attribute->name}}</div>
                <div class="col-md-6">
                    @foreach ($attribute->values as $value)
                        <span class="me-2 mb-2 mb-md-0 mx-md-2">{{$value->value}}</span>
                    @endforeach
                </div>
                <div class="col-md-3">
                    <a href="" class="btn btn-success btn-sm text-capitalize">edit</a>
                    <a href="" class="btn btn-danger btn-sm text-capitalize">delete</a>
                </div>
                </div>
            @endforeach
          
        @else
            <div class="alert alert-info mx-5">There are no attributes now</div>
        @endif
        </div>
        
        
        

@endsection

@section('js-special')
<script>
    $(document).ready(function(){
        $('.delete-attribute').click(function(){
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

        // set the width of the current windwo (desktop , tablet or mobile)
        var window_width = window.innerWidth;

        if(window_width > 767){
            $('.attributes').show();
        }
    })
    
</script>
@endsection  