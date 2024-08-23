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
                'name'      => ['required','string'],
                'email'     => ['required','email'],
                'password'  => ['required','min:8','string','confirmed'],
                'password_confirmation' => ['required','min:8','string'],
            ]);
            $data = $request->except('_token','password_confirmatin','admin_key');
            $data['password'] = Hash::make($request->password);
            Admin::create($data);
            return redirect()->route('admin.dashboard.login')->with('registerSuccess','Admin account created successfully');
        }else{
            return redirect()->back()->with('errorResponse','admin key was wrong');
        }
    }
}
