@extends('admin.layouts.app')

@section('title','Admin Dashboard Categories')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid d-flex align-items-center">
            <a href="{{route('admin.dashboard.categories.index')}}" class="text-capitalize fw-bold text-decoration-none fs-5">categories</a>
            <span class="mx-3">/</span>
            <h2 class="h5 no-margin-bottom text-capitalize">{{$category->name}}</h2>
          </div>
        </div>


@endsection