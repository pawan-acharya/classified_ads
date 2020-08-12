<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatRoom;
use App\Feedback;
use Auth;

class FeedbackController extends Controller
{
    public function create(Request $request, $classified_ad){
    	$chat_room= app()->call('App\Http\Controllers\ChatRoomController@create', ['classified_ad'=>$classified_ad] );

    	$feedback= $chat_room->feedbacks()->create([
    		'message'=> $request->message,
    		'user_id'=> Auth::id()
    	]);

    	dd($feedback);
    }

    public function show($chat_room_id){
    	$feedbacks= ChatRoom::find($chat_room_id)->feedbacks;
    	return view('feedbacks.show', compact('feedbacks'));
    }

    public function reply(Request $request, $chat_room_id){
    	$chat_room= ChatRoom::findOrFail($chat_room_id);
    	$feedback= $chat_room->feedbacks()->create([
    		'message'=> $request->message,
    		'user_id'=> Auth::id()
    	]);
    	return redirect()->back();
    }
}
