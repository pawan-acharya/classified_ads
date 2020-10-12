@extends('layouts.app')

@section('content')
<section id="plan-intro">
    <div class="container">
        <h1 class="mb-1 mt-3">{{ __('payments.payment_title') }}</h1>
        <h4 class="mb-3">{{ __('payments.payment_subtitle') }}</h4>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row plan-selection">
            <div class="col-md-3 plan-item featured">
                <div class="pt-3">
                    <h3>{{ __('payments.payment_plans.rental.title') }}</h3>
                    <h6>{{ __('payments.payment_plans.rental.subtitle') }}</h6>
                </div>
                <div class="pt-3">
                    <ul>
                        <li class="mb-0"><i class="far fa-image"></i>{{ __('payments.payment_plans.rental.pictures') }}</li>
                        <li class="mb-0"><i class="fas fa-external-link-alt"></i>{{ __('payments.payment_plans.rental.url') }}</li>
                        <li><i class="fas fa-star"></i>{{ __('payments.payment_plans.rental.featured') }}</li>
                    </ul>
                </div>
                <div class="price-box">
                    <div class="w-50 text-left">
                        <select class="form-control" name="package-month-rental" id="rental-month">
                            <option value="20">1 AD's</option>
                            <option value="50">5 AD's</option>
                            <option value="75" selected>10 AD's</option>
                        </select>
                    </div>
                    <div class="w-50 text-right">
                        <p class="plan-price" id="rental-month-price">$ 75</p>
                    </div>
                </div>
                <div class="valid-month">
                    <span>{{ __('payments.valid_month') }}</span>
                </div>
                <a href="/payment-form/3" class="btn btn-main w-100">{{ __('payments.payment_link') }}</a>
            </div>
            <div class="col-md-3 plan-item featured">
                <div class="pt-3">
                    <h3>{{ __('payments.payment_plans.sales.title') }}</h3>
                    <h6>{{ __('payments.payment_plans.sales.subtitle') }}</h6>
                </div>
                <div class="pt-3">
                    <ul>
                        <li class="mb-0"><i class="far fa-image"></i>{{ __('payments.payment_plans.sales.pictures') }}</li>
                        <li class="mb-0"><i class="fas fa-external-link-alt"></i>{{ __('payments.payment_plans.sales.url') }}</li>
                        <li><i class="fas fa-star"></i>{{ __('payments.payment_plans.sales.featured') }}</li>
                    </ul>
                </div>
                <div class="price-box">
                    <div class="w-50 text-left">
                        <select class="form-control" name="package-month-sales" id="sales-month">
                            <option value="20">1 AD's</option>
                            <option value="50">5 AD's</option>
                            <option value="75" selected>10 AD's</option>
                        </select>
                    </div>
                    <div class="w-50 text-right">
                        <p class="plan-price" id="sales-month-price">$ 75</p>
                    </div>
                </div>
                <div class="valid-month">
                    <span>{{ __('payments.valid_month') }}</span>
                </div>
                <a href="/payment-form/3" class="btn btn-main w-100">{{ __('payments.payment_link') }}</a>
            </div>
            <div class="col-md-3 plan-item premium">
                <div class="pt-3">
                    <img src="{{ asset('/images/premium.png') }}">
                    <h3>{{ __('payments.payment_plans.premium.title') }}</h3>
                    <h6>{{ __('payments.payment_plans.premium.subtitle') }}</h6>
                </div>
                <div class="pt-3">
                    <ul>
                        <li class="mb-0"><i class="far fa-image"></i>{{ __('payments.payment_plans.sales.pictures') }}</li>
                        <li class="mb-0"><i class="fas fa-external-link-alt"></i>{{ __('payments.payment_plans.sales.url') }}</li>
                        <li><i class="fas fa-star"></i>{{ __('payments.payment_plans.sales.featured') }}</li>
                    </ul>
                </div>
                <div class="price-box">
                    <p class="plan-price">150$ / Paid Monthly</p>
                </div>
                <div class="valid-month">
                    <span>{{ __('payments.valid_month') }}</span>
                </div>
                <a href="/payment-form/3" class="btn btn-main w-100">{{ __('payments.payment_link_premium') }}</a>
            </div>
        </div>
    </div>
</section>

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        $('#sales-month').on("change",function () {
            new_price = $(this).val();
            $('#sales-month-price').html('$ ' + new_price);
        });
        $('#rental-month').on("change",function () {
            new_price_rental = $(this).val();
            $('#rental-month-price').html('$ ' + new_price_rental);
        });
    })(jQuery);
});
</script>
@endpush
@endsection
