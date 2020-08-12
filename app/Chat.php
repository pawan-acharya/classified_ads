<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    // protected $fillable = [];

	public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function classified_ad()
    {
        return $this->belongsTo('App\ClassifiedAd');
    }
}
