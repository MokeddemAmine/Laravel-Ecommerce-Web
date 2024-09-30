@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom text-capitalize"><a href="{{route('admin.dashboard.key.index')}}" class="text-danger">keys</a> / create</h2>
          </div>
        </div>

        <div class="container-fluid keys">
            <form action="{{route('admin.dashboard.key.store')}}" method="POST" style="max-width: 600px;">
                @csrf
                <input type="text" name="key" placeholder="Set a key" class="form-control rounded my-3">
                <div class="d-grid my-3">
                    <input type="submit" value="add key" class="btn btn-danger text-capitalize">
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

            @if ($errors->any())
                <ul class="list-unstyled text-danger fw-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        

@endsection