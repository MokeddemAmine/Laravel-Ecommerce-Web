<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');   
    }

    public function register(){
        return view('admin.auth.register');
    }
    public function store(Request $request){
        
        $admin_key = 'admin';
        if($admin_key == $request->admin_key){

            $request->validate([
                'name'                  => ['required','string'],
                'email'                 => ['required','string','email','unique:admins'],
                'password'              => ['required','min:8','string','confirmed'],
                'password_confirmation' => ['required','min:8','string'],
                'profile_picture'       => ['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
            ]);

            // get the image
            $image = $request->file('profile_picture');
            $imageName = $image->store('uploads/images/profile','public');

            Admin::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'profile_picture'   => $imageName,
            ]);

            return redirect()->route('admin.dashboard.login')->with('registerSuccess','Admin account created successfully');
        }else{
            return redirect()->back()->with('errorResponse','admin key was wrong');
        }
    }
}
