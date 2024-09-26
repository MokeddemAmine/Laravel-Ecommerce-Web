<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function profilePage(){
        $addresses = Address::where('user_id',Auth::user()->id)->get();
        return view('user.profile',compact('addresses'));
    }
}
