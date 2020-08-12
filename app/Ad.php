<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\WithFiles;
use App\Traits\Uploader;
use App\Plan;
use Carbon\Carbon;
use Constants;
use Auth;

class Ad extends Model
{

    use WithFiles, Uploader;

    protected $fillable = [
        'category',
        'vehicle_year', 
        'brand',
        'model',
        'exterior_color',
        'interior_color',
        'exterior_color_fr',
        'interior_color_fr',
        'number_of_places',
        'engine',
        'cylinder',
        'transmission', 
        'motor_skills',
        'current_mileage',
        'user_id',
        'interior_options',
        'inclusion_options',
        'title',
        'description',
        'title_fr',
        'description_fr'
    ];

    protected $appends = [
        'is_active', 
        'has_expired',
        'is_featured',
        'is_special',
        'payment',
        'remaining_kms'
    ];

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

    public function getInteriorOptionsAttribute($value)
    {
        return explode(',', $value);
    }

    public function getInclusionOptionsAttribute($value)
    {
        return explode(',', $value);
    }

    public function getIsActiveAttribute()
    {
        $plan = Plan::find($this->attributes['plan_id']);
        if($plan) {
            return ($plan->is_active && (Carbon::now() < $plan->ends_at)) ? true : false;
        }
        return false;
    }

    public function getHasExpiredAttribute()
    {
        $plan = Plan::find($this->attributes['plan_id']);
        if($plan) {
            return Carbon::now() > $plan->ends_at ;
        }
        return false;
    }

    public function getIsFeaturedAttribute()
    {
        $plan = Plan::find($this->attributes['plan_id']);
        $createdAt = Carbon::create($this->attributes['created_at']);
        if($plan) {
            if($plan->slug === 'best'  && Carbon::now() <= $createdAt->addWeeks(Constants::PAYMENT_PLANS[$plan->slug]['featured_weeks'])) {
                return true;
            } elseif($plan->slug === 'exceptional'  && Carbon::now() <= $createdAt->addWeeks(Constants::PAYMENT_PLANS[$plan->slug]['featured_weeks'])) {
                return true;
            }
        }
        return false;
    }

    public function getIsSpecialAttribute()
    {
        $plan = Plan::find($this->attributes['plan_id']);
        $createdAt = Carbon::create($this->attributes['created_at']);
        if($plan) {
            if($plan->slug === 'exceptional'  && Carbon::now() <= $createdAt->addWeeks(Constants::PAYMENT_PLANS[$plan->slug]['featured_weeks'])) {
                return true;
            }
        }
        return false;
    }
    
    public function getPaymentAttribute()
    {
        $lease = Lease::find($this->attributes['lease_id']);
        $payment = $lease->monthly_payments_before_taxes + ( $lease->initial_down_payment / (float)$lease->contract_duration);
        return $payment;
    }

    public function getFormattedPaymentAttribute()
    {
        $lease = Lease::find($this->attributes['lease_id']);
        $payment = $lease->monthly_payments_before_taxes + ( $lease->initial_down_payment / (float)$lease->contract_duration);
        // return money_format('$%i', $payment);
        return  $payment;
    }

    public function getRemainingMonthlyKmsAttribute()
    {
        $lease = Lease::find($this->attributes['lease_id']);
        $remainingKms = ($lease->contract_kilometers - $this->attributes['current_mileage']) / (float)$lease->contract_duration; 
        return number_format($remainingKms, 0);
    }

    public function getDescriptionAttribute()
    {
        if(app()->getLocale()=='fr') {
            return $this->attributes['description_fr'];
        }
       return $this->attributes['description'];
    }

    public function getTitleAttribute()
    {
        if(app()->getLocale()=='fr') {
            return $this->attributes['title_fr'];
        }
       return $this->attributes['title'];
    }

    public function getExteriorColorAttribute()
    {
        if(app()->getLocale()=='fr') {
            return $this->attributes['exterior_color_fr'];
        }
       return $this->attributes['exterior_color'];
    }

    public function getInteriorColorAttribute()
    {
        if(app()->getLocale()=='fr') {
            return $this->attributes['interior_color_fr'];
        }
       return $this->attributes['interior_color'];
    }

    public function getIsWishlistedAttribute()
    {
        if (Auth::guard()->check()) {
            $wishlist = Wishlist::where('user_id', Auth::user()->id)
                            ->where('ad_id' ,$this->attributes['id'])
                            ->first();
            if($wishlist) {
                return true;
            }
        }
       return false;
    }


  
}
