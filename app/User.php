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
        return $this->hasMany('App\ClassifiedAd');
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

    public function lease()
    {
        return $this->belongsTo('App\Lease')->latest();
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan')->latest();
    }

    public function checkIfAdmin(){
        return ($this->plan_id && $this->plan->type== 'membership' && $this->plan->ends_at>= date('Y-m-d'));
    }

    public function checkForPlan(){
        return ($this->plan_id && ($this->plan->type== 'one' || $this->plan->type== 'five' || $this->plan->type== 'ten') && $this->plan->ends_at>= date('Y-m-d'));
    }

    public function getLeftAds(){
        if($this->checkForPlan()){
            $ad_counts= $this->ads()->where('plan_id', $this->plan_id)->count();
            
            switch ($this->plan->type) {
                case 'ten':
                    $avaiilable_ads= 10;
                    break;
                case 'five':
                    $avaiilable_ads= 5;
                    break;
                default:
                    $avaiilable_ads= 1;
                    break;
            }

            return $avaiilable_ads- $ad_counts;
        }
    }

    public function ifLeftAds(){
        return ($this->getLeftAds()>0)? true: false;
    }
}
