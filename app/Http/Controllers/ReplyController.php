<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Chat;
use Auth;

class ReplyController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_reply(Request $request, $id)
    {
        if(Auth::user()->checkAllowedToReply($id)){
            // if($request->ajax()){
                $chat= Chat::find($id);

                $reply= new Reply;
                $reply->message= $request->message;

                $reply->reply_by= ($chat->classified_ad->user->id != Auth::id())?'visitor':'advertiser';
               
                $chat->replies()->save($reply);
            // }
            return redirect()->back();
        }
    }

    public function show($id){
        $chat= Chat::find($id)->replies;
        return $chat;
    }

    public function index($id){
        if(Auth::user()->checkIfOwner($id, 'chat')){
            $replies= Chat::find($id)->replies;
            return view('chats.owners.show', compact('replies'));
        }
    }
    
    public function add_owner_reply(Request $request, $id)
    {
        if(Auth::user()->checkIfOwner($id, 'chat')){
            // if($request->ajax()){
                $chat= Chat::find($id);

                $reply= new Reply;
                $reply->message= $request->message;
                $reply->reply_by= 'advertiser';
               
                $chat->replies()->save($reply);
            // }
            return redirect()->back();
        }
    }

    
}
