<div class="detail-wrapper">
    <div class="row">
        <div class="col-12 details">
            <h5 class="col-12">{{ __('ads.vehicle_description') }}</h5>
            @php( $category = 'ads.category_options.'.$ad->category)
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.category') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ __($category) }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.vehicle_year') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->vehicle_year }}</p>
            </div>
            @php( $brand = 'ads.brand_options.'.$ad->brand)
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.brand') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ __($brand) }}</p>
            </div>
            @php( $model = 'ads.model_options.'.$ad->brand.'.'.$ad->model)
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.model') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ __($model) }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.exterior_color') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->exterior_color }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.interior_color') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->interior_color }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.number_of_places') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->number_of_places }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.engine') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->engine }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.cylinder') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->cylinder }}</p>
            </div>
            @php( $transmission = 'ads.transmission_options.'.$ad->transmission)
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.transmission') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ __($transmission) }}</p>
            </div>
            @php( $motor_skills = 'ads.motor_skills_options.'.$ad->motor_skills)
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.motor_skills') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ __($motor_skills) }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.current_mileage') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->current_mileage }}</p>
            </div>
            <hr class="solid">
        </div>
    </div>

    <div class="row">
        <div class="col-12 details">
            <h5 class="col-12">{{ __('ads.vehicle_options') }}</h5>
            <div class= "row container">
                @if(!count($ad->interior_options) == 0 && $ad->interior_options[0]!='')
                <ul class="col-7 property-list">
                    @foreach($ad->interior_options as $option)
                    @php( $lang_key = 'ads.interior_options.'.$option)
                    <li>{{ __( $lang_key) }}</li>
                    @endforeach
                </ul>
                @endif
                @if(!count($ad->inclusion_options) == 0 && $ad->inclusion_options[0]!='')
                <ul class="col-5 property-list"><strong>{{ __('ads.inclusion_option') }}</strong>
                    @foreach($ad->inclusion_options as $option)
                        @if(!empty($option))
                        @php( $lang_key = 'ads.inclusion_options.'.$option)
                        <li>{{ __( $lang_key) }}</li>
                        @endif
                    @endforeach
                </ul>
                @endif
            </div>
            <hr class="solid">
        </div>
    </div>

    <div class="row">
        <div class="col-12 details">
            <h5 class="col-12">{{ __('ads.lease_information') }}</h5>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.monthly_payments_before_taxes') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->monthly_payments_before_taxes }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.monthly_payments_after_taxes') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->monthly_payments_after_taxes }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.initial_down_payment') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->initial_down_payment }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.security_deposit') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->security_deposit }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.purchase_option') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->purchase_option }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.contract_kilometers') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->contract_kilometers }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.excess_mileage_fee') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->excess_mileage_fee }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.contract_start_date') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->contract_start_date->format('d/m/Y') }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.contract_duration') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->contract_duration }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.contract_end_date') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->contract_end_date->format('d/m/Y') }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.incentive_amount') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->incentive_amount }}</p>
            </div>
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.deposit_amount') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ $ad->lease->deposit_amount }}</p>
            </div>
            @php($transfer_fees_langkey = 'ads.lease.transfer_fees_options.'.$ad->lease->transfer_fees)
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{ __('ads.lease.transfer_fees') }}</hp>
                <p class="detail-item-value mb-0 col-5">{{ __($transfer_fees_langkey) }}</p>
            </div>
        </div>
    </div>
</div>