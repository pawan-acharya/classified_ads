<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatRoom;
use App\ClassifiedAd;
use Auth;
use DB;

class ChatRoomController extends Controller
{
	public function index(Request $request){
        if($request->ajax()){
            $chat_rooms= ChatRoom::with('feedbacks')
            ->where('advertiser', Auth::id())
            ->orWhere('visitor', Auth::id())
            ->orderByDesc('updated_at')
            ->get();
            return view('chatrooms.partials.chat_room_lists', compact('chat_rooms'));
        }

		return view('chatrooms.index');
	}

    public function create($classified_ad){
    	if(ChatRoom::where('visitor', ClassifiedAd::find($classified_ad)->user->id)->where('advertiser', Auth::id())->exists()){
			$chat_room= ChatRoom::where('visitor', ClassifiedAd::find($classified_ad)->user->id)->where('advertiser', Auth::id())->first();
            $chat_room->update([
                'classified_ad_id'=> $classified_ad,
            ]);
    	}else if(ChatRoom::where('advertiser', ClassifiedAd::find($classified_ad)->user->id)->where('visitor', Auth::id())->exists()){
    		$chat_room= ChatRoom::where('advertiser', ClassifiedAd::find($classified_ad)->user->id)->where('visitor', Auth::id())->first();
    		$chat_room->update([
    			'classified_ad_id'=> $classified_ad,
    		]);
    	}else{
    		$chat_room= ChatRoom::create([
	    		'advertiser'=> ClassifiedAd::find($classified_ad)->user->id,
	    		'visitor'=> Auth::id(), 
	    		'classified_ad_id'=> $classified_ad,
	    	]);
    	}
    	return $chat_room;
    }
}
