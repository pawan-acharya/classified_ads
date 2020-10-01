<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'classified_ad_id'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function ad()
    {
        return $this->hasMany('App\ClassifiedAd');
    }
}
