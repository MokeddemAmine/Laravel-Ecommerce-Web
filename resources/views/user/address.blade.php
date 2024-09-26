@extends('layouts.app')

@section('content')
<div class="container">

        <h1 class="my-3 fs-3 text-capitalize"><a href="{{route('user.profile')}}" class="text-danger">profile</a> / create address</h1>
        <div class="ms-3">
            
            @if (session('successMessage'))
                <strong class="text-success my-3">{{session('successMessage')}}</strong>
            @endif
            <form action="{{route('user.profile.address.store')}}" method="POST" style="max-width: 600px;">
                @csrf
                <div class="mt-3 bg-dark text-white p-3 mb-3 rounded">
                    <div class="row align-items center mb-3">
                        <label for="name" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">name</label>
                        <p class="col-md-8  rounded">{{Auth::user()->name}}</p>
                    </div>
                    <div class="form-group mb-5 row align-items-center">
                        <label for="country" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">country</label>
                        <div class="col-md-8">
                            <select name="country" id="country" class="form-select bg-dark text-white">
                                <option hidden>Chose your country</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-5">
                        <label for="state" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">state</label>
                        <div class="col-md-8">
                            <select name="state" id="state" class="form-select  bg-dark text-white">
                                <option hidden>Chose your state</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-5">
                        <label for="address" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">address</label>
                        <div class="col-md-8">
                            <input type="text" name="address" value="{{old('address')}}" id="address" placeholder="Enter your address" class="form-control  bg-dark text-white">
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-5">
                        <label for="phone" class="col-md-4 mb-3 mb-md-0 text-capitalize fw-bold">phone</label>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <div class="col-3">
                                    <select name="code_phone" id="code_phone" class="form-select  bg-dark text-white">
                                        <option hidden>code</option>
                                    </select>
                                </div>
                                
                                <input type="text" name="phone" value="{{old('phone')}}" class="form-control  bg-dark text-white" id="phone" aria-label="Text input with dropdown button" placeholder="Your phone number">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid">
                    <input type="submit" value="add address" class="btn btn-danger text-capitalize">
                </div>
            </form>
            
        </div>
        


</div>
@endsection
@section('js-special')
    <script>
        $(document).ready(function(){
            // get all countrie
            $.ajax({
                type:'GET',
                url:'{{asset('json/countries.json')}}',
                dataType:'json',
                cache:false,
                success:function(data,status){
                    data.map(country=>{      
                        $('#country').append('<option value="'+country.name+'">'+country.name+'</option>');
                    })
                },
                error:function(xhr,textStatus,err){
                    console.log(err);
                }
            });
            // get all states of country when change the country field
            $('#country').on('change',function(){
                $.ajax({
                    type:'GET',
                    url:'{{asset('json/countries.json')}}',
                    dataType:'json',
                    cache:false,
                    success:function(data,status){
                        $('#state').html('<option hidden>Chose your state</option>');
                        let country_name = $('#country').val();
                        let states = data.find(country => country.name == country_name).states.map(state => {
                            $('#state').append('<option value="'+state.name+'">'+state.name+'</option>')
                        });
                        
                    },
                    error:function(xhr,textStatus,err){

                    }
                })      

            });
            // get code phone 
            $.ajax({
                type:'GET',
                url:'{{asset('json/countryPhoneCodes.json')}}',
                dataType:'json',
                cache:false,
                success:function(data,status){
                    data.map(country=>{    
                        $('#code_phone').append('<option class="phone_code" value="'+country.code+'">'+country.iso+'-'+country.code+'</option>')  
                    })
                },
                error:function(xhr,textStatus,err){
                    console.log(err);
                }
            });
        })
    </script>
@endsection
