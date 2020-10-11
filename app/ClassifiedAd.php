<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\WithFiles;
use App\Traits\Uploader;
use Auth;

class ClassifiedAd extends Model
{
    use WithFiles, Uploader;
    
    protected $fillable = [
        'form_values', 'user_id', 'title', 'citq', 'price', 'title_image', 'descriptions', 'price_for', 'location', 'is_featured', 'feature_type', 'validated_date', 'url', 'sub_category'
    ];
    
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

    public function getCost(){
        if ( Auth::user()->checkIfAdmin() ) {
            return 0;
        }
        elseif(Auth::user()->ifLeftAds()){
            return 0;
        }
        else{
            if($this->category->type != 'none'){
                return 20;
            }
            else{
                $amount= 0;
                if ($this->url) {
                   $amount++;
                }
                if($this->files()->count()>6){
                    $amount+= 5;
                }
                if($this->is_featured){
                    switch ($this->feature_type) {
                        case 'month':
                            $amount+= 20;
                            break;
                        
                        case 'week':
                            $amount+= 8;
                            break;
                        
                        default:
                            $amount+= 5;
                            break;
                    }
                }
                return $amount;
            }
        }

        return $this->category->type;
    }
}
