<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{

    protected $redirectTo = RouteServiceProvider::AdminHome;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');    
    }

    public function login(){
        return view('admin.auth.login');
    }
    
    public function checkLogin(Request $request){
        
        $request->validate([
            'email'     => ['required','email'],
            'password'  => ['required','string'],
        ]);
        $data = $request->only('email','password');

        if(Auth::guard('admin')->attempt($data,$request->get('remember'))){
            return redirect()->intended($this->redirectTo);
        }

        return redirect()->back()->withInput(['email' => $request->email])->with('errorResponse' , 'These Credentials do not much our records');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // if ($response = $this->loggedOut($request)) {
        //     return $response;
        // }
        
        return redirect()->route('admin.login');
    }
}
