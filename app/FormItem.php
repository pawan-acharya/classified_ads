<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormItem extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_items';
    
    protected $fillable = ['name', 'type', 'required', 'parent', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function children(){
        return $this->hasMany('App\FormItem', 'parent', 'id');
    }
}
