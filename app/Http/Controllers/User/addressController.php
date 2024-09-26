<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class addressController extends Controller
{
    public function create(){
        return view('user.address');
    }
    public function store(Request $request){

        $request->validate([
            'country'       => ['required','string'],
            'state'         => ['required','string'],
            'address'       => ['required','string'],
            'code_phone'    => ['required','string'],
            'phone'         => ['required','string'],
        ]);

        $address = $request->country.' '.$request->state.' '.$request->address;
        $phone = $request->code_phone.$request->phone;

        Address::create([
            'user_id'   => Auth::user()->id,
            'address'   => $address,
            'phone'     => $phone,
        ]);

        return redirect()->back()->with('successMessage','address added with success');
    }

    public function destroy(Address $address){
        if($address->user_id == Auth::user()->id){
            $address->delete();
        }   
        
        return redirect()->back()->with('successMessage','Address Deleted with success');
    }
}
