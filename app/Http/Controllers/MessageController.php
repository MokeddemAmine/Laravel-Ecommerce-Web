<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(){

    }
    public function store(Request $request){

        
        $request->validate([
            'name'      => ['required','string'],
            'email'     => ['required','email'],
            'phone'     => ['required'],
            'subject'   => ['required','string'],
            'message'   => ['required','string'],
        ]);
        
        $user_id = null;
        if(Auth::check()){
            $user_id = Auth::user()->id;
        }

        Message::create([
            'user_id'   => $user_id,
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'subject'   => $request->subject,
            'message'   => $request->message,
        ]);

        return redirect()->back()->with('successMessage','Message was send successfully');
    }
    public function destroy(Message $message){

    }
}
