<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\WithFiles;
use App\Traits\Uploader;

class Category extends Model
{
    use WithFiles, Uploader;
    
    protected $fillable = [
        'category_name', 'description', 'image', 'type', 'sub_category'
    ];

    // adding the appends value will call the accessor in the JSON response
    protected $appends = ['ids'];

    public function form_items()
    {
        return $this->hasMany('App\FormItem');
    }

    public function form_items_delete(){
    	$this->form_items()->delete();
    	return parent::delete();
    }

    public function classified_ads()
    {
        return $this->hasMany('App\ClassifiedAd');
    }

    public function getFormItemsIdsAttribute()
    {
        return $this->form_items->pluck('id');
    }
}
