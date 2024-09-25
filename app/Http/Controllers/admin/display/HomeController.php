<?php

namespace App\Http\Controllers\admin\display;

use App\Http\Controllers\Controller;
use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(){
        $home = Display::where('section','home')->first();
        return view('admin.display.home.index',compact('home'));
    }

    public function update(Request $request){
        $request->validate([
            'title'         => ['required','string'],
            'description'   => ['required','string'],
            'picture'       => ['nullable','image','mimes:jpeg,pjg,png','max:2048'],
        ]);

        $home = Display::where('section','home')->first();
        if(!($home && $home->image)){
            $request->validate([
                'picture'   => ['required'],
            ]);
        }

        if($request->hasFile('picture')){

            if($home && $home->image){
                if(Storage::disk('public')->exists($home->image)){
                    Storage::disk('public')->delete($home->image);
                }
            }
            
            $filename = $request->file('picture')->store('uploads/images','public');

            Display::updateOrCreate(
                ['section'=>'home'],
                [
                    'image'         => $filename,
                    'title'         => $request->title,
                    'description'   => $request->description
                ]
            );
               
        }else{
            Display::updateOrCreate(
                ['section'=>'home'],
                [
                    'title'         => $request->title,
                    'description'   => $request->description
                ]
            );
        }

        return redirect()->back()->with('successMessage','Data Updated with success');
    }
}
