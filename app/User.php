<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Gabievi\Promocodes\Traits\Rewardable;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable, Billable, Rewardable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'name', 
        'home_phone',
        'mobile_phone',
        'city',
        'province',
        'postal_code',
        'correspondence_language',
        'heard_about',
        'security_question',
        'security_answer',
        'email', 
        'password',
        'is_admin',
        'referred_by',
        'provider', 
        'provider_id', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ads()
    {
        return $this->hasMany('App\Ad');
    }

    public function partner()
    {
        return $this->hasOne('App\Partner');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['name'];
    }

    public function sendPasswordResetNotification($token)
    {
    $this->notify(new ResetPassword($token));
    }
}
