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
    
    protected $fillable = ['name', 'type', 'required'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
