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
}
