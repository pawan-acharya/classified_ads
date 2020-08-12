<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Chat;
use App\ClassifiedAd;
use Auth;

class ChatController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(ClassifiedAd::find($id)->user->id == Auth::id()){
            return ;
        }

        $chat=Chat::where('user_id', Auth::id())->where('classified_ad_id', $id)->first();
        if( !$chat ){
            $chat= new Chat;
            $chat->user()->associate(Auth::user())->classified_ad()->associate(ClassifiedAd::find($id));
            $chat->save();

            $reply= new Reply([
                'message'=> 'How may I help you?',
                'reply_by'=> 'advertiser'
            ]);
            $chat->replies()->save($reply);
        }
        
        // app()->call('App\Http\Controllers\ReplyController@show', ['id'=>$chat->id]);
        return;
            
    }


    public function index($id){
        if(Auth::user()->checkIfOwner($id, 'classified_ad')){
            $chats=  ClassifiedAd::find($id)->chats;
            return view('chats.owners.index', compact('chats'));
        }
    }

   
}
