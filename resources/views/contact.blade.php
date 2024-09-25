@extends('layouts.app')

@section('title','contact us')

@section('content')


  <!-- contact section -->

  <section class="contact_section layout_padding">
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
         
          <form action="{{route('messages.store')}}" method="POST" class="mb-3">
            @csrf
            <div>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" />
            </div>
            @if ($errors->has('name'))
                <strong class="my-2 text-danger">{{$errors->first('name')}}</strong>
            @endif
            <div>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" />
            </div>
            @if ($errors->has('email'))
              <strong class="my-2 text-danger">{{$errors->first('email')}}</strong>
          @endif
            <div>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" />
            </div>
            @if ($errors->has('phone'))
                <strong class="my-2 text-danger">{{$errors->first('phone')}}</strong>
            @endif
            <div>
              <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" />
            </div>
            @if ($errors->has('subject'))
                <strong class="my-2 text-danger">{{$errors->first('subject')}}</strong>
            @endif
            <div>
              <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Message"></textarea>
            </div>
            @if ($errors->has('message'))
                <strong class="my-2 text-danger">{{$errors->first('message')}}</strong>
            @endif
            <div class="d-grid gap-2 my-3">
              <input type="submit" value="send" class="btn btn-warning text-uppercase">
            </div>
            @if (session('successMessage'))
                <strong class="text-success ms-3 d-inline-block">{{session('successMessage')}}</strong>
            @endif
          </form>
         
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->

  @endsection