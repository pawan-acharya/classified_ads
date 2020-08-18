<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassifiedAd extends Model
{
    protected $fillable = ['form_values', 'user_id'];
    
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
}
