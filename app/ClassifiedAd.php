<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassifiedAd extends Model
{
    protected $fillable = ['form_values'];
    
    protected $casts = [
        'form_values' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /* not necessary though */
    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    // public function chat_replies(){
        
    // }
}
