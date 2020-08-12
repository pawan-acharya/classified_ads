<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	protected $fillable = ['message', 'user_id'];

    public function chat_room()
    {
        return $this->belongsTo('App\ChatRoom');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
