@extends('admin.layouts.app')

@section('title','Admin Dashboard displays')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">
                <a href="{{route('admin.dashboard.displays.index')}}">Website</a>
                /
                Contact
            </h2>
          </div>
        </div>

        <div class="page-content ms-3" style="max-width: 800px">
          <form action="{{route('admin.dashboard.displays.contact.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center my-3">
              <label for="map" class="col-md-4 text-capitalize fw-bold">map</label>
              <div class="col-md-8">
                <input type="text" name="map" placeholder="Set a map" value="@if($map && $map->description) {{$map->description}} @endif" id="map" class="form-control @error('map') is-invalid @enderror" />
              </div>
              @if ($errors->has('map'))
                  <strong class="my-2 text-danger">{{$errors->first('map')}}</strong>
              @endif
            </div>
            <div class="row align-items-center my-3">
              <label for="phone" class="col-md-4 text-capitalize fw-bold">phone</label>
              <div class="col-md-8">
                <input type="text" name="phone" placeholder="Set a phone" value="@if($phone && $phone->description) {{$phone->description}} @endif" id="phone" class="form-control @error('phone') is-invalid @enderror" />
              </div>
              @if ($errors->has('phone'))
                  <strong class="my-2 text-danger">{{$errors->first('phone')}}</strong>
              @endif
            </div>
            <div class="row align-items-center my-3">
              <label for="mail" class="col-md-4 text-capitalize fw-bold">mail</label>
              <div class="col-md-8">
                <input type="text" name="mail" placeholder="Set a mail" value="@if($mail && $mail->description) {{$mail->description}} @endif" id="mail" class="form-control @error('mail') is-invalid @enderror" />
              </div>
              @if ($errors->has('mail'))
                  <strong class="my-2 text-danger">{{$errors->first('mail')}}</strong>
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