<?php

namespace App\Http\Controllers\admin\display;

use App\Http\Controllers\Controller;
use App\Models\Display;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        $about = Display::where('section','about')->first();
        return view('admin.display.about.index',compact('about'));
    }

    public function update(Request $request){
        $request->validate([
            'description'       => ['required','string']
        ]);
        Display::UpdateOrCreate(
            ['section'  => 'about'],
            [
                'description'   => $request->description,
            ],
        );
        return redirect()->back()->with('successMessage','about section updated with success');
    }
}
