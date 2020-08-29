<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name', 'description', 'image'];

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
