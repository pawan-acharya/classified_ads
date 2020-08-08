<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $dates = ['ends_at'];

    protected $fillable = [
        'name',
        'slug',
        'stripe_plan',
        'cost',
        'description',
        'user_id',
        'ad_id',
        'ends_at',
        'is_active'
    ];

}
