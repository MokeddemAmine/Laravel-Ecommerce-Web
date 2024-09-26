@extends('layouts.app')

@section('content')
<div class="container">

        <h1 class="my-3 text-danger">Profile</h1>
        <div class="row">
            <div class="col-lg-6">
                <h2 class="my-3 fs-4 text-capitalize">account</h2>
                <form action="" method="POST" style="max-width: 600px;">
                    <div class="form-group mb-3">
                        <input type="text" name="name" value="{{Auth::user()->name}}" placeholder="Set your name" class="bg-dark text-white form-control">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" name="email" value="{{Auth::user()->email}}" placeholder="Set your email" class="bg-dark text-white form-control">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="Set your phone" class="bg-dark text-white form-control">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" name="address" value="{{Auth::user()->address}}" placeholder="Set your address" class="bg-dark text-white form-control">
                    </div>
                    <div class="d-grid">
                        <input type="submit" value="Update" class="btn btn-danger">
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <h2 class="my-3 fs-4 text-capitalize">shipped addresses</h2>
                @if ($addresses && count($addresses))
                    <div class="row">
                        @foreach ($addresses as $address)
                        <div class=" col-lg-6 p-1">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <div>{{$address->address}}</div>
                                        <div>{{$address->phone}}</div>
                                        <form action="{{route('user.profile.address.destroy',$address->id)}}" method="POST" style="display: none" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <div class="text-end">
                                            <button class="btn btn-danger btn-sm text-capitalize btn-delete">delete</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                            
                        @endforeach
                    </div>
                @else 
                    <span class="text-danger text-capitalize">no address</span>
                @endif
                <a href="{{route('user.profile.address')}}" class="btn btn-outline-secondary text-capitalize">add address</a>
            </div>
        </div>
        <div class="ms-3">
           
            
            
            <h2 class="text-capitalize my-3 fs-4"><a href="{{route('orders.index')}}" class="text-danger d-flex align-items-center gap-2">orders <i class="fa-solid fa-right-long"></i></a></h2>
            @if (session('successMessage'))
                <strong class="text-success d-block my-3">{{session('successMessage')}}</strong>
            @endif
        </div>
        


</div>
@endsection
