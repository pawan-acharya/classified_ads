<?php

namespace App;

class Constants
{
    const PAYMENT_PLANS = [
        'standard' => [
             'title' => 'Standard',
             'slug' => 'standard',
             'cost' => 99.00,
             'stripe_cost' => 9900,
             'validity_months' => 3,
             'featured_weeks' => 0
        ],
        'best' => [
             'title' => 'The best',
             'slug' => 'best',
             'cost' => 149.00,
             'stripe_cost' => 14900,
             'validity_months' => 4,
             'featured_weeks' => 2
        ],
        'exceptional' => [
             'title' => 'The exceptional',
             'slug' => 'exceptional',
             'cost' => 199.00,
             'stripe_cost' => 19900,
             'validity_months' => 6,
             'featured_weeks' => 4
         ]
    ];

    const VOUCHER_TYPES = [
         'VALUE' => 'value',
         'PERCENT' => 'percent',
    ];

    const PROMOCODE_MAX_USAGE = 1000000;
    const TAX_RATE = 0.14975;
    
}