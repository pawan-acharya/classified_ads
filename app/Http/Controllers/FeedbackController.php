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

    	return redirect()->back();
    }

    public function show(Request $request, $chat_room_id){
        $feedbacks= ChatRoom::find($chat_room_id)
        ->feedbacks()
        ->where('user_id', '!=', Auth::id())
        ->where('read', '=', 0)
        ->update([
            'read'=> 1,
        ]);

        if($request->ajax()){
            $feedbacks= ChatRoom::find($chat_room_id)->feedbacks()->where('id', '>', session('chat_room_id_'.$chat_room_id))->get();
            session([
                $chat_room_id => $feedbacks->max('id')
            ]);

            $html= '';
            foreach ($feedbacks as $feedback) {
                $html.= '<tr>';
                        if($feedback->user->id== Auth::id()){
                            $html.='<td></td>
                                <td class="badge badge-primary text-wrap" style="width: 10rem;" data-feeback-id="'.$feedback->id.'">'.$feedback->message.'</td>';   
                        }else{
                            $html.='<td class="badge badge-light text-wrap" style="width: 10rem;" data-feeback-id="'.$feedback->id.'">'.$feedback->message.'</td>
                                    <td></td>';
                        }
                            $html.='</tr>';
            }
            return $html;
        }

        $feedbacks= ChatRoom::find($chat_room_id)->feedbacks; 
        session([
            'chat_room_id_'.$chat_room_id => $feedbacks->max('id')
        ]);

    	return view('feedbacks.show', compact('feedbacks'));
    }

    public function reply(Request $request, $chat_room_id){
    	$chat_room= ChatRoom::findOrFail($chat_room_id);
    	$feedback= $chat_room->feedbacks()->create([
    		'message'=> $request->message,
    		'user_id'=> Auth::id()
    	]);

         $feedbacks= ChatRoom::find($chat_room_id)
        ->feedbacks()
        ->where('user_id', '!=', Auth::id())
        ->where('read', '=', 0)
        ->update([
            'read'=> 1,
        ]);
        
        $feedbacks= $chat_room->feedbacks()->where('id', '>', session('chat_room_id_'.$chat_room_id))->get();
        session([
             'chat_room_id_'.$chat_room_id => $feedbacks->max('id')
        ]);

        $html= '';
        foreach ($feedbacks as $feedback) {
            $html.= '<tr>';
                    if($feedback->user->id== Auth::id()){
                        $html.='<td></td>
                            <td class="badge badge-primary text-wrap" style="width: 10rem;" data-feeback-id="'.$feedback->id.'">'.$feedback->message.'</td>';   
                    }else{
                        $html.='<td class="badge badge-light text-wrap" style="width: 10rem;" data-feeback-id="'.$feedback->id.'">'.$feedback->message.'</td>
                                <td></td>';
                    }
                        $html.='</tr>';
        }
        return $html;
    }


}
