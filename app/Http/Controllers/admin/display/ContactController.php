<?php

namespace App\Http\Controllers\admin\display;

use App\Http\Controllers\Controller;
use App\Models\Display;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $map = Display::where('section','contact')->where('title','map')->first();
        $phone = Display::where('section','contact')->where('title','phone')->first();
        $mail = Display::where('section','contact')->where('title','mail')->first();
        return view('admin.display.contact.index',compact('map','phone','mail'));
    }
    public function update(Request $request){

        $request->validate([
            'map'       => ['nullable','string'],
            'phone'     => ['nullable','integer'],
            'mail'      => ['nullable','email'],
        ]);

        if($request->map){
            Display::UpdateOrCreate(
                ['section'=>'contact','title'=>'map'],
                [
                    'description'   => $request->map,
                ],
            );
        }
        if($request->phone){
            Display::UpdateOrCreate(
                ['section'=>'contact','title'=>'phone'],
                [
                    'description'   => $request->phone,
                ],
            );
        }
        if($request->mail){
            Display::UpdateOrCreate(
                ['section'=>'contact','title'=>'mail'],
                [
                    'description'   => $request->mail,
                ],
            );
        }
        if($request->map || $request->phone || $request->mail){
            return redirect()->back()->with('successMessage','Data updated with success');
        }else{
            return redirect()->back()->with('errorMessage','Insert data first');
        }
        
    }
}
