@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Messages</h2>
          </div>
        </div>

        <div class="messages-content m-3 m-md-5">
            @if (count($messages))
            <div class="row my-3">
                <div class="col-1">#Num</div>
                <div class="col-2">name</div>
                <div class="col-3">email</div>
                <div class="col-2">phone</div>
                <div class="col-2">subject</div>
                <div class="col-2">actions</div>
            </div>
            
                    @foreach ($messages as $message)
                        <div class="row my-1 align-items-center">
                            <div class="col-md-1">
                                {{$message->id}}
                            </div>
                            <div class="col-md-2">
                                {{$message->name}}
                                
                            </div>
                            <div class="col-md-3">
                                {{$message->email}}
                            </div>
                            <div class="col-md-2">
                                {{$message->phone}}
                            </div>
                            <div class="col-md-2">
                                {{$message->subject}}
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin.dashboard.messages.show',$message->id)}}" class="text-capitalize btn btn-success btn-sm">show</a>
                                <form action="{{route('admin.dashboard.messages.destroy',$message->id)}}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                </form>
                            </div>
                        </div>
                    @endforeach
                
            @else
                <div class="alert alert-info m-3 fw-bold">There are no message</div>
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