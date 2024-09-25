@extends('admin.layouts.app')

@section('title','Admin Dashboard displays')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">
                <a href="{{route('admin.dashboard.displays.index')}}">Website</a>
                /
                Social Media 
            </h2>
          </div>
        </div>

        <div class="page-content ms-3" style="max-width: 800px">
          <form action="{{route('admin.dashboard.displays.media.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center my-3">
              <label for="facebook" class="col-md-4 text-capitalize fw-bold">facebook</label>
              <div class="col-md-8">
                <input type="text" name="facebook" placeholder="Set your facebook link" value="@if($facebook && $facebook->description) {{$facebook->description}} @endif" id="facebook" class="form-control @error('facebook') is-invalid @enderror" />
              </div>
              @if ($errors->has('facebook'))
                  <strong class="my-2 text-danger">{{$errors->first('facebook')}}</strong>
              @endif
            </div>
            <div class="row align-items-center my-3">
              <label for="x-twitter" class="col-md-4 text-capitalize fw-bold">x twitter</label>
              <div class="col-md-8">
                <input type="text" name="x_twitter" placeholder="Set your x-twitter link" value="@if($x_twitter && $x_twitter->description) {{$x_twitter->description}} @endif" id="x-twitter" class="form-control @error('x_twitter') is-invalid @enderror" />
              </div>
              @if ($errors->has('x_twitter'))
                  <strong class="my-2 text-danger">{{$errors->first('x_twitter')}}</strong>
              @endif
            </div>
            <div class="row align-items-center my-3">
              <label for="instagram" class="col-md-4 text-capitalize fw-bold">instagram</label>
              <div class="col-md-8">
                <input type="text" name="instagram" placeholder="Set your instagram link" value="@if($instagram && $instagram->description) {{$instagram->description}} @endif" id="instagram" class="form-control @error('instagram') is-invalid @enderror" />
              </div>
              @if ($errors->has('instagram'))
                  <strong class="my-2 text-danger">{{$errors->first('instagram')}}</strong>
              @endif
            </div>
            <div class="row align-items-center my-3">
              <label for="youtube" class="col-md-4 text-capitalize fw-bold">youtube</label>
              <div class="col-md-8">
                <input type="text" name="youtube" placeholder="Set your youtube link" value="@if($youtube && $youtube->description) {{$youtube->description}} @endif" id="youtube" class="form-control @error('youtube') is-invalid @enderror" />
              </div>
              @if ($errors->has('youtube'))
                  <strong class="my-2 text-danger">{{$errors->first('youtube')}}</strong>
              @endif
            </div>
            
            <div class="d-grid gap-2">
              <input type="submit" value="Update" class="btn btn-primary">
            </div>
          </form>
          <div class="text-center">
            @if (session('successMessage'))
            <span class="fw-bold text-success my-4">{{session('successMessage')}}</span>
            @endif

            @if (session('errorMessage'))
                <span class="fw-bold text-danger my-4">{{session('errorMessage')}}</span>
            @endif
          </div>
        </div>


@endsection