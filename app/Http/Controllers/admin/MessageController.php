<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){
        $messages = Message::all();
        return view('admin.message.index',compact('messages'));
    }
    public function show(Message $message){
        if(!$message->read){
            $message->update([
                'read'  => 1,
            ]);
        }
        return view('admin.message.show',compact('message'));
    }
    public function destroy(Message $message){
        $message->delete();
        return redirect()->route('admin.dashboard.messages.index')->with('successMessage','Message deleted with success');
    }
}
