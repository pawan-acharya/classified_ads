<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\WithFiles;
use App\Traits\Uploader;

class ClassifiedAd extends Model
{
    use WithFiles, Uploader;
    
    protected $fillable = ['form_values', 'user_id', 'title', 'citq', 'price', 'title_image', 'descriptions', 'price_for', 'location', 'is_featured', 'feature_type', 'validated_date', 'url'];
    
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

    public function lease()
    {
        return $this->belongsTo('App\Lease')->latest();
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan')->latest();
    }
}
