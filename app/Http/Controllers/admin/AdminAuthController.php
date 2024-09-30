<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuth;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function index(){
        $keys = AdminAuth::all();
        return view('admin.adminKey.index',compact('keys'));
    }

    public function create(){
        return view('admin.adminKey.create');
    }

    public function store(Request $request){

        $request->validate([
            'key'   => ['required','string','min:5','unique:admin_auths,key'],
        ]);

        AdminAuth::create([
            'key'       => $request->key,
        ]);
        
        return redirect()->back()->with('successMessage','key added with success');
    }

    public function destroy(AdminAuth $key){
        $key->delete();
        return redirect()->back()->with('successMessage','Key deleted with success');
    }
}
