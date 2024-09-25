@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">
                <a href="{{route('admin.dashboard.messages.index')}}" class="text-primary">Messages</a>
                /
                <span>Message</span>
            </h2>
          </div>
        </div>

        <div class="messages-content m-3 m-md-5">
            @if ($message)
                <div class="ms-3 my-3" style="max-width: 800px">
                    @if ($message->user_id)
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 text-capitalize fw-bold">user</label>
                        <div class="col-md-8">{{$message->user->name}}</div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 text-capitalize fw-bold">name</label>
                        <div class="col-md-8">{{$message->name}}</div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 text-capitalize fw-bold">email</label>
                        <div class="col-md-8">{{$message->email}}</div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 text-capitalize fw-bold">phone</label>
                        <div class="col-md-8">{{$message->phone}}</div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 text-capitalize fw-bold">subject</label>
                        <div class="col-md-8">{{$message->subject}}</div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 text-capitalize fw-bold">message</label>
                        <div class="col-md-8">{{$message->message}}</div>
                    </div>
                    <form action="{{route('admin.dashboard.messages.destroy',$message->id)}}" method="POST" class="text-end">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                    </form>
                </div>
                
                
            @endif
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