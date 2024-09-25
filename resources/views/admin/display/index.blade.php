@extends('admin.layouts.app')

@section('title','Admin Dashboard displays')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Website</h2>
          </div>
        </div>

        <div class="orders-content m-3 m-md-5">
            <ul class="list-unstyled">
                <li>
                    <a href="{{route('admin.dashboard.displays.home.index')}}" class="text-uppercase">home</a>
                </li>
                <li class="my-3">
                    <a href="{{route('admin.dashboard.displays.about.index')}}" class="text-uppercase">about</a>
                </li>
                <li class="my-3">
                    <a href="{{route('admin.dashboard.displays.contact.index')}}" class="text-uppercase">contact</a>
                </li>
                <li>
                    <a href="{{route('admin.dashboard.displays.media.index')}}" class="text-uppercase">Social Media</a>
                </li>
            </ul>
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