<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){

        $clients = User::all()->count();
        $products = Product::all()->count();
        $orders = Order::all()->count();
        $orders_delivered = Order::where('status','delivered')->get()->count();

        return view('admin.index',compact('clients','products','orders','orders_delivered'));
    }

    public function profile(){
        return view('admin.profile');
    }

    public function update(Request $request,Admin $admin){

        $request->validate([
            'name'              => ['required','string','min:3'],
            'email'             => ['required','string','email',Rule::unique('admins')->ignore($admin->id)],
            'profile_picture'   => ['nullable','image','mimes:jpg,jpeg,png,gif','max:2048'],
        ]);

        

        if($request->hasFile('profile_picture')){

            // delete the current profile picture if exist

            if($admin->profile_picture){
                $prev_image = public_path('storage/'.$admin->profile_picture);
                if(file_exists($prev_image)){
                    unlink($prev_image);
                }
            }
            
            // store the new image setting

            $new_image = $request->file('profile_picture');
            $new_image_name = $new_image->store('uploads/images/profile','public');

            // update data with picutre
            $admin->update([
                'name'              => $request->name,
                'email'             => $request->email,
                'profile_picture'   => $new_image_name,
            ]);

        }else{
            // update data without picture
            $admin->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->back()->with('successMessage','Information updated with success');
    }

    public function updatePassword(Request $request,Admin $admin){

        $request->validate([
            'current_password'      => ['required','string',],
            'password'              => ['required','string','min:8','confirmed'],
            'password_confirmation' => ['required','string','min:8'],
        ]);

        if(Hash::check($request->current_password, $admin->password)){

            $admin->update([
                'password'  => Hash::make($request->password),
            ]);

            return redirect()->back()->with('successMessage','The password updated with success');
        }else{
            return redirect()->back()->with('errorMessage','the current password is incorrect');
        }



    }
    
}
