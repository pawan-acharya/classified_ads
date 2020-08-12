<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatRoom;
use App\ClassifiedAd;
use Auth;

class ChatRoomController extends Controller
{
	public function index(){
		$chat_rooms= ChatRoom::with('feedbacks')->where('advertiser', Auth::id())->orWhere('visitor', Auth::id())->get();
		return view('chatrooms.index', compact('chat_rooms'));
	}

    public function create($classified_ad){
    	if(ChatRoom::where('classified_ad_id', $classified_ad)->where('visitor', Auth::id())->exists()){
			$chat_room= ChatRoom::where('classified_ad_id', $classified_ad)->where('visitor', Auth::id())->first();
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
