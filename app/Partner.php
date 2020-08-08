<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'business_name',
        'first_name',
        'name', 
        'home_phone',
        'mobile_phone',
        'city',
        'province',
        'postal_code',
        'correspondence_language',
        'heard_about',
        'email', 
        'password',
        'status',
        'user_id',
        'promocode_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function promocode()
    {
        return $this->belongsTo('Gabievi\Promocodes\Models\Promocode');
    }
}
