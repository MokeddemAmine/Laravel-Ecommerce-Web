<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }
    public function index(){

        return view('admin.index');
    }
    public function charts(){
        return view('admin.charts');
    }
    public function forms(){
        return view('admin.forms');
    }
    public function tables(){
        return view('admin.tables');
    }
}
