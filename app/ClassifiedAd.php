<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\WithFiles;
use App\Traits\Uploader;

class ClassifiedAd extends Model
{
    use WithFiles, Uploader;
    
    protected $fillable = ['form_values', 'user_id', 'title', 'citq', 'price', 'title_image', 'descriptions'];
    
    protected $casts = [
        'form_values' => 'array',
        'descriptions'=> 'array'
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
