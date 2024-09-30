@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Profile</h2>
          </div>
        </div>

        <div class="profile-content ms-3 ms-md-5">
            <div class="profile-header row align-items-center me-3 me-md-5">
                <div class="profile_picture rounded-circle col-md-4 mb-3">
                    @if (Auth::guard('admin')->user()->profile_picture)
                        <img src="{{asset('storage/'.Auth::guard('admin')->user()->profile_picture)}}" alt="profile picture of {{Auth::guard('admin')->user()->name}}"  class="rounded-circle img-responsive img-profile">
                    @else
                        <img src="{{asset('admin/img/profile.jpg')}}" alt="profile picture of {{Auth::guard('admin')->user()->name}}"  class="rounded-circle img-responsive img-profile">
                    @endif
                </div>
                <div class="profile-title col-md-8">
                    <h2 class="text-white">{{Auth::guard('admin')->user()->name}}</h2>
                    <h6>Admin</h6>
                </div>
            </div>
            <div class="profile-setting mt-5 row me-3 me-md-5">
                <div class="col-lg-8 mb-3">
                <h2 class="text-white mb-3">Settings</h2>
                <form action="{{route('admin.dashboard.update',Auth::guard('admin')->user()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
 
                        <div class="form-group row me-3 mb-4 align-items-center">
                            <label for="name" class="col-md-4 text-capitalize fs-3 mb-3 mb-md-0">{{__('name')}}</label>
                            <div class="col-md-8 flex-shrink-1">
                                <input type="text" name="name" id="name" value="{{Auth::guard('admin')->user()->name}}" class="form-control">
                            </div>
                            
                        </div>
                        <div class="form-group row me-3 mb-4 align-items-center">
                            <label for="email" class="col-md-4 text-capitalize fs-3 mb-3 mb-md-0">{{__('email')}}</label>
                            <div class="col-md-8 flex-shrink-1">
                                <input type="text" name="email" id="email" value="{{Auth::guard('admin')->user()->email}}" class="form-control">
                            </div>
                            
                        </div>
                        <div class="form-group row me-3 mb-4 align-items-center">
                            <label for="profile_picture" class="col-md-4 text-capitalize fs-3 mb-3 mb-md-0">{{__('profile picture')}}</label>
                            <div class="col-md-8 flex-shrink-1">
                                <input id="profile_picture" type="file" value="{{old('profile_picture')}}" accept=".png,.jpg,.jpeg,.gif" class="form-control" name="profile_picture">

                                @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>
                        <div class="form-group row me-3 mb-4">
                            <div class="d-grid flex-shrink-1">
                                <input type="submit" value="Update" class="btn btn-primary">
                            </div>
                        </div>
                        
                </form>
                </div>
                <div class="col-lg-4 mb-3">
                    <h2 class="text-white mb-3">Reset Password</h2>
                    <form action="{{route('admin.dashboard.updatePassword',Auth::guard('admin')->user()->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group  me-3 mb-4 ">
                            <input type="password" name="current_password" id="current_password"  class="form-control" placeholder="Enter the current password" />  
                        </div>
                        <div class="form-group me-3 mb-4 ">
                            <input type="password" name="password" id="password"  class="form-control" placeholder="Enter the new password" />    
                        </div>
                        <div class="form-group me-3 mb-4">
                            <input type="password" name="password_confirmation" id="confirm_new_password"  class="form-control" placeholder="Confirm the new password" autocomplete="new-password"/>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-grid gap-2 me-3 me-md-3 mb-4 flex-shrink-1">
                                <input type="submit" value="Reset Password" class="btn btn-primary">
                            </div>   
                        </div>
                    </form>
                </div>
            </div>
            <a href="{{route('admin.dashboard.key.index')}}" class="d-block my-3 text-danger text-capitalize"><i class="fa-solid fa-key"></i> admin keys</a>
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