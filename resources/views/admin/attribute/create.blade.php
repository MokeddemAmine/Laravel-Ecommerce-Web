@extends('admin.layouts.app')

@section('title','Admin Dashboard Attribute Create')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid d-flex align-items-center">
            <a href="{{route('admin.dashboard.attributes.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">Attributes</a>
            <span class="mx-3">/</span>
            <h2 class="h5 no-margin-bottom">Create Attribute</h2>
          </div>
        </div>
            <form action="{{route('admin.dashboard.attributes.store')}}" method="POST">
                @csrf
                <div class="ms-2 ms-md-5" style="max-width:800px">
                    <div class="form-group row align-items-center mb-4">
                        <label for="name" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">name</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <input type="text" name="name" placeholder="Enter the name of attribute" id="name" class="form-control">
                        </div> 
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="values" class="col-md-4 text-capitalize fs-4 mb-3 mb-md-0">values</label>
                        <div class="col-md-8 me-5 me-md-0 flex-shrink-1">
                            <input name="values" id="values" class="form-control" title="we accept all characters" placeholder="values of attribute separate one spaces"/>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="d-grid gap-2 me-5 me-md-0 mb-4 flex-shrink-1">
                            <input type="submit" value="Add Attribute" class="btn btn-primary">
                        </div>
                        
                    </div>
                    @if ($errors->any())
                        <ul class="list-unstyled my-3">
                            @foreach ($errors->all() as $error)
                                <li class="fw-bold text-danger ms-3">{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if (session('successMessage'))
                            <div class="alert alert-success">{{session('successMessage')}}</div>
                    @endif
                    @if (session('errorMessage'))
                        <span class="fw-bold text-danger ms-3 my-3">{{session('errorMessage')}}</span>
                    @endif
                </div>
                
            </form>

@endsection


