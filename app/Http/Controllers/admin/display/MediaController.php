<?php

namespace App\Http\Controllers\admin\display;

use App\Http\Controllers\Controller;
use App\Models\Display;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(){

        $facebook = Display::where('section','media')->where('title','facebook')->first();
        $x_twitter = Display::where('section','media')->where('title','x_twitter')->first();
        $instagram = Display::where('section','media')->where('title','instagram')->first();
        $youtube = Display::where('section','media')->where('title','youtube')->first();
        
        return view('admin.display.media.index',compact('facebook','x_twitter','instagram','youtube'));
    }

    public function update(Request $request){

        $request->validate([
            'facebook'      => ['nullable','string'],
            'x_twitter'     => ['nullable','string'],
            'instagram'     => ['nullable','string'],
            'youtube'       => ['nullable','string'],
        ]);

        if($request->facebook){
            Display::updateOrCreate(
                ['section'=>'media','title'=>'facebook'],
                [
                    'description'       => $request->facebook,
                ]
            );
        }

        if($request->x_twitter){
            Display::updateOrCreate(
                ['section'=>'media','title'=>'x_twitter'],
                [
                    'description'       => $request->x_twitter,
                ]
            );
        }

        if($request->instagram){
            Display::updateOrCreate(
                ['section'=>'media','title'=>'instagram'],
                [
                    'description'       => $request->instagram,
                ]
            );
        }

        if($request->youtube){
            Display::updateOrCreate(
                ['section'=>'media','title'=>'youtube'],
                [
                    'description'       => $request->youtube,
                ]
            );
        }

        if($request->facebook || $request->x_twitter || $request->instagram || $request->youtube){
            return redirect()->back()->with('successMessage','Data updated with success');
        }else{
            return redirect()->back()->with('errorMessage','Insert Data');
        }
    }
}
