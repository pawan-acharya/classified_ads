<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
	protected $fillable = ['advertiser', 'visitor', 'classified_ad_id'];

    public function advertiser_user(){
    	return $this->belongsTo('App\User', 'advertiser', 'id');
    }

    public function visitor_user(){
    	return $this->belongsTo('App\User', 'visitor', 'id');
    }

    public function classified_ad()
    {
        return $this->belongsTo('App\ClassifiedAd');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }

}
