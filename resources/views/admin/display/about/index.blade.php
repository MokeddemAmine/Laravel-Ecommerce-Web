@extends('admin.layouts.app')

@section('title','Admin Dashboard displays')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">
                <a href="{{route('admin.dashboard.displays.index')}}">Website</a>
                /
                About
            </h2>
          </div>
        </div>

        <div class="page-content ms-3" style="max-width: 800px">
          <form action="{{route('admin.dashboard.displays.about.index')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row align-items-center my-3">
              <label for="description" class="col-md-4 text-capitalize fw-bold">description</label>
              <div class="col-md-8">
                <textarea type="text" name="description" placeholder="Set a description" id="description" class="form-control @error('description') is-invalid @enderror">@if($about && $about->description) {{$about->description}} @endif</textarea>
              </div>
              @if ($errors->has('description'))
                  <strong class="my-2 text-danger">{{$errors->first('description')}}</strong>
              @endif
            </div>
            <div class="d-grid gap-2">
              <input type="submit" value="Update" class="btn btn-primary">
            </div>
          </form>
          
         </div>

        <div class="text-center">
            @if (session('successMessage'))
            <span class="fw-bold text-success my-4">{{session('successMessage')}}</span>
            @endif

            @if (session('errorMessage'))
                <span class="fw-bold text-danger my-4">{{session('errorMessage')}}</span>
            @endif
        </div>
        

@endsection