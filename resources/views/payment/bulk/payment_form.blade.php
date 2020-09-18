@extends('layouts.app')

@section('content')
<section id="plan-intro">
    <div class="container">
        
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form id="payment-form" role="form" method="POST" action="{{ route('bulk_payment.charge', ['type'=> $type]) }}">
            @csrf
            <h1 class="section-head mb-3">{{ __('payments.payment_details') }}</h1>
            <div class="row info-block p-0">
                <div class="card col-md-6">
                    <div class="card-body p-md-5 ">
                        <h4 class="mb-3">{{ __('payments.billing_details') }}</h4>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="city">{{ __('auth.city') }}</label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="province">{{ __('auth.province') }}</label>
                                <select class="custom-select form-control @error('province') is-invalid @enderror" id="province" name="province" required autofocus>
                                @foreach (__('auth.province_options') as $key => $province)
                                <option value="" selected disabled required></option>
                                    <option value="{{$key}}" @if (old('province') === $key) selected @endif> {{$province}}</option>
                                @endforeach
                                </select>
                                @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">{{ __('payments.full_name') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input id="card-holder-name" type="text" class="form-control" name="card-holder-name" placeholder="" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">{{ __('payments.card_details') }}</label>
                                <div class="input-group">
                                    <div id="card-element" class="form-control" style="height: 2.4em; padding-top: .7em;"></div>
                                </div>
                            </div>
                        </div>

                        <input id="payment-method" type="hidden" name="payment-method">


                        <h4 class="mb-3 mt-5">{{ __('payments.voucher_details') }}</h4>
                        <div class="row voucher-container">
                            <div class="input-group control-group after-add-more col-md-12">
                            <input type="text" id="voucher" name="voucher" class="form-control" placeholder="{{ __('payments.enter_voucher') }}" required>
                                <div class="input-group-btn"> 
                                  <button id="apply-voucher" class="btn btn-primary" type="button">{{ __('payments.apply') }}</button>
                                </div>
                              </div>   
                        </div>
                    </div>
                </div>

                <div class="card col-md-6">
                    <div id="alert" class="alert d-none" role="alert"></div>
                    <div class="card-body p-md-5 ">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('payments.subscription') }}</th>
                                    <th class="text-center">{{ __('payments.price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="checkout-subscription">
                                    <td class="col-md-9"><em>{{ __('payments.payment_plans.'.$payment_plan['slug'].'.title')}}</em></td>
                                    <td id="subscription-cost" class="col-md-1 text-center" data-cost="{{ $payment_plan['cost'] }}">{{ $checkout_data['cost_formatted'] }}</td>
                                </tr>
                                <tr id="checkout-voucher" class="d-none">
                                    <td class="col-md-9"><em>{{ __('payments.promocode') }}</em></td>
                                    <td id="promocode-value" class="col-md-1 text-center">$0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                    <p>
                                        <strong>{{ __('payments.subtotal') }}:&nbsp;</strong>
                                    </p>
                                    <p>
                                        <strong>{{ __('payments.taxes') }}:&nbsp;</strong>
                                    </p></td>
                                    <td class="text-center">
                                    <p>
                                        <strong id="checkout-subtotal">{{ $checkout_data['subtotal'] }}</strong>
                                    </p>
                                    <p>
                                        <strong id="checkout-tax">{{ $checkout_data['tax'] }}</strong>
                                    </p></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><h4><strong>{{ __('payments.total') }}:&nbsp;</strong></h4></td>
                                    <td  id="checkout-total" class="text-center text-secondary"><h4>{{ $checkout_data['total'] }}</h4></td>
                                </tr>
                            </tbody>
                        </table>

                        <button id="card-button"  class="subscribe btn btn-primary btn-block" type="button"> {{ __('payments.submit') }} </button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</section>

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {

    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const style = {
        base: {
        iconColor: '#666ee8',
        color: '#31325f',
        fontWeight: 400,
        fontFamily:
            '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '15px',
        '::placeholder': {
            color: '#aab7c4',
        },
        ':-webkit-autofill': {
            color: '#666ee8',
        },
        },
    };

    const elements = stripe.elements();
    const cardElement = elements.create('card', {style});

    // Add an instance of the card Element into the `card-element`
    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    const paymentMethodElement = document.getElementById('payment-method');
    const form = document.getElementById("payment-form");

    cardButton.addEventListener('click', async (e) => {
        e.target.setAttribute("disabled", true);
        e.target.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('payments.submitting')}} ...`;

        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: { name: cardHolderName.value }
            }
        );

        if (error) {
            showAlert( e.target, 'danger', '{{ __('payments.wrong_card_details') }}')
        } else {
            paymentMethodElement.value = paymentMethod.id
            debugger;
            form.submit();
        }
    });

    function showAlert(button, alert, message) {
        const alertEle = document.getElementById("alert");

        button.removeAttribute("disabled");
        button.innerHTML = `{{ __('payments.submit') }}`;

        alertEle.classList.remove("d-none");
        alertEle.classList.add("alert-"+alert);
        alertEle.innerHTML = message;
        setTimeout(function(){ 
            alertEle.classList.add("d-none");
        }, 5000);
    }

    var SITEURL = "{{url('/payment')}}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '#apply-voucher', function () {
        var that = $(this);
        $('#voucher').removeClass('is-invalid');
        var voucher = $('#voucher').val();
        if(!voucher) {
            return $('#voucher').addClass('is-invalid');
        }
        that.prop("disabled", true);
        that.html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
        );
        
        $.ajax({
            type: "POST",
            url: SITEURL + "/action/applyvoucher/"+voucher,
            success: function (data) {
                that.html('<i class="fa fa-check" aria-hidden="true"></i>');
                that.parent().parent().after('<p class="text-success pl-3 pt-1">'+data.message+'</p>');
                applyVoucher(data.data);
            },
            error: function (error) {
                that.prop("disabled", false);
                that.html("{{ __('payments.apply') }}");
                that.parent().parent().after('<p class="text-danger pl-3 pt-1">'+error.responseJSON.message+'</p>');
                setTimeout(function(){ 
                    $('.voucher-container').find('p').remove();
                }, 5000);
            }
        });
    }); 

    function applyVoucher(voucher) {
        var cost = parseFloat($('#subscription-cost').data('cost'));
        var tax_rate = {{ \Constants::TAX_RATE}};
        var promocode_value =  parseFloat((voucher.type == 'value') ? voucher.value : (cost * voucher.value/100));
        var subtotal = parseFloat(cost - promocode_value);
        var tax = parseFloat(subtotal * tax_rate);
        var total = parseFloat(subtotal + tax);
        console.log(typeof subtotal)
        console.log(tax)
        console.log(subtotal+tax)

        $('#promocode-value').html('-$'+promocode_value.toFixed(2));
        $('#checkout-subtotal').html('$'+subtotal.toFixed(2));
        $('#checkout-tax').html('$'+tax.toFixed(2));
        $('#checkout-total').children().html('$'+total.toFixed(2));
        $('#checkout-voucher').removeClass('d-none');
    }
    
    })(jQuery);
});
</script>
@endpush
@endsection
