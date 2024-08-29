@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2 class="my-3">User Profile Page</h2>
        <div class="text-center">Welcome {{Auth::user()->name}}</div>

    </div>
</div>
@endsection
