@extends('admin.layouts.app')

@section('title','Admin Dashboard Categories')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid d-flex align-items-center">
            <a href="{{route('admin.dashboard.categories.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">categories</a>
            <span class="mx-3">/</span>
            <h2 class="h5 no-margin-bottom">Create Category</h2>
          </div>
        </div>
        
        <form action="{{route('admin.dashboard.categories.store')}}" method="post">
            @csrf
            <div class="mx-auto" style="max-width:400px">
                @if (session('successResponse'))
                    <div class="alert alert-success">{{session('successResponse')}}</div>
                 @endif
                <input type="text" name="name" class="form-control mb-3" placeholder="Set the name of the category">
                @if ($errors->any())
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold text-danger">{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <input type="submit" value="Add Category" class="btn btn-primary btn-block">
            </div>
        </form>

@endsection
        