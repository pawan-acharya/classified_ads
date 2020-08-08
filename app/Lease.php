<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{

    protected $dateFormat = 'yy-m-d';

    protected $fillable = [
        'monthly_payments_before_taxes',
        'monthly_payments_after_taxes',
        'initial_down_payment',
        'security_deposit',
        'purchase_option',
        'contract_kilometers',
        'excess_mileage_fee',
        'contract_start_date',
        'contract_duration',
        'contract_end_date',
        'incentive_amount',
        'deposit_amount',
        'transfer_fees',
        'transfer_fess_options'
    ];

    protected $dates = [
        'contract_start_date',
        'contract_end_date'
    ];

    
    protected $casts = [
        'contract_start_date'  => 'date:d-m-Y',
        'contract_end_date' => 'date:Y-m-d',
    ];

    public function getFormattedIncentiveAmountAttribute()
    {
        return $this->attributes['incentive_amount'];
        // return money_format('$%i', $this->attributes['incentive_amount']);
    }
}
