@extends('layouts.app')

@section('content')
<section id="ad-edit" class="primary-background">
    <h1 class="section-head">{{ Session::has('ad-edit') ? __('ads.lease_details') : __('ads.details') }}</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 my-5">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger row" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if(!Session::has('ad-edit'))
                    <form method="POST" action="{{ route('ads.nextupdate', $ad->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field("PUT") }}
                        <!-- Ad fields start-->
                        <div class="form-group row">
                            @php($old_category = old('category') ? old('category') : $ad->category)
                            <div class="col-md-6">
                                <label for="category" class="col-form-label text-md-right">{{ __('ads.category') }}</label>
                                <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.category_options') as $key => $category)
                                        <option value="{{$key}}" @if ($old_category == $key) selected @endif> {{$category}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @php( $old_vehicle_year = old('vehicle_year') ? old('vehicle_year') : $ad->vehicle_year )
                            <div class="col-md-6">
                                <label for="vehicle_year" class="col-form-label text-md-right">{{ __('ads.vehicle_year') }}</label>
                                <select id="vehicle_year" class="form-control @error('vehicle_year') is-invalid @enderror" name="vehicle_year" required>
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.vehicle_year_options') as $key => $vehicle_year)
                                        <option value="{{$key}}" @if ($old_vehicle_year == $key) selected @endif> {{$vehicle_year}}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_brand = old('brand') ? old('brand') : $ad->brand )
                            <div class="col-md-6">
                                <label for="brand" class="col-form-label text-md-right">{{ __('ads.brand') }}</label>
                                <select id="brand" class="form-control @error('brand') is-invalid @enderror" name="brand" required>
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.brand_options') as $key => $brand)
                                        <option value="{{$key}}" @if ($old_brand == $key) selected @endif> {{$brand}}</option>
                                    @endforeach
                                </select>
                                @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @php( $old_model = old('model') ? old('model') : $ad->model )
                            <div class="col-md-6">
                                <label for="model" class="col-form-label text-md-right">{{ __('ads.model') }}</label>
                                <select id="model" class="form-control @error('model') is-invalid @enderror" name="model" required>
                                    <option value="" selected disabled></option>
                                    <option value="" > {{ __('ads.select_model') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            @if(str_replace('_', '-', app()->getLocale()) == 'fr')
                                @php( $old_exterior_color = old('exterior_color') ? old('exterior_color') :  $ad->exterior_color_fr )
                            @else
                                @php( $old_exterior_color = old('exterior_color') ? old('exterior_color') : $ad->exterior_color )
                            @endif
                            <div class="col-md-6">
                                <label for="exterior_color" class="col-form-label text-md-right">{{ __('ads.exterior_color') }}</label>
                                <input id="exterior_color" type="text" class="form-control @error('exterior_color') is-invalid @enderror" name="exterior_color" value="{{ $old_exterior_color }}" required autocomplete="exterior_color">
                                @error('exterior_color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if(str_replace('_', '-', app()->getLocale()) == 'fr')
                                @php( $old_interior_color = old('interior_color') ? old('interior_color') :  $ad->interior_color_fr )
                            @else
                                @php( $old_interior_color = old('interior_color') ? old('interior_color') : $ad->interior_color )
                            @endif
                            <div class="col-md-6">
                                <label for="interior_color" class="col-form-label text-md-right">{{ __('ads.interior_color') }}</label>
                                <input id="interior_color" type="text" class="form-control @error('interior_color') is-invalid @enderror" name="interior_color" value="{{ $old_interior_color }}" autocomplete="interior_color">

                                @error('interior_color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @php( $old_number_of_places = old('number_of_places') ? old('number_of_places') : $ad->number_of_places )
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="number_of_places" class="col-form-label text-md-right">{{ __('ads.number_of_places') }}</label>
                                <input id="number_of_places" type="number" min="0" class="form-control @error('number_of_places') is-invalid @enderror" name="number_of_places" value="{{ $old_number_of_places }}" required autocomplete="number_of_places" >
                                @error('number_of_places')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @php( $old_engine = old('engine') ? old('engine') : $ad->engine )
                            <div class="col-md-6">
                                <label for="engine" class="col-form-label text-md-right">{{ __('ads.engine') }}</label>
                                <input id="engine" type="number" min="0" class="form-control @error('engine') is-invalid @enderror" name="engine" value="{{ $old_engine }}"  autocomplete="engine" required >
                                @error('engine')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_cylinder = old('cylinder') ? old('cylinder') : $ad->cylinder )
                            <div class="col-md-6">
                                <label for="cylinder" class="col-form-label text-md-right">{{ __('ads.cylinder') }}</label>
                                <input id="cylinder" type="number" min="0" class="form-control @error('cylinder') is-invalid @enderror" name="cylinder" value="{{ $old_cylinder }}" required autocomplete="cylinder" >
                                @error('cylinder')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @php( $old_transmission = old('transmission') ? old('transmission') : $ad->transmission )
                            <div class="col-md-6">
                                <label for="transmission" class="col-form-label text-md-right">{{ __('ads.transmission') }}</label>
                                <select id="transmission" class="form-control @error('transmission') is-invalid @enderror" name="transmission" required>
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.transmission_options') as $key => $transmission)
                                        <option value="{{$key}}" @if ($old_transmission == $key) selected @endif> {{$transmission}}</option>
                                    @endforeach
                                </select>
                                @error('transmission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_motor_skills = old('motor_skills') ? old('motor_skills') : $ad->motor_skills )
                            <div class="col-md-6">
                                <label for="motor_skills" class="col-form-label text-md-right">{{ __('ads.motor_skills') }}</label>
                                <select id="motor_skills" class="form-control @error('motor_skills') is-invalid @enderror" name="motor_skills" required>
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.motor_skills_options') as $key => $motor_skill)
                                        <option value="{{$key}}" @if ($old_motor_skills == $key) selected @endif> {{$motor_skill}}</option>
                                    @endforeach
                                </select>
                                @error('motor_skills')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @php( $old_current_mileage = old('current_mileage') ? old('current_mileage') : $ad->current_mileage )
                            <div class="col-md-6">
                                <label for="current_mileage" class="col-form-label text-md-right">{{ __('ads.current_mileage') }}</label>
                                <input id="current_mileage" type="number" min="0" class="form-control @error('current_mileage') is-invalid @enderror" name="current_mileage" autocomplete="current_mileage" value="{{ $old_current_mileage }}" required >

                                @error('current_mileage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary" onclick="$(this).parent().find('input[type=file]').click();">{{ __('ads.add_files') }}</span>
                                    <input name="images[]" onchange="$(this).parent().parent().find('.form-control').html(getFileNames($(this)[0].files));" style="display: none;" type="file" multiple>
                                </span>
                                <span class="form-control"></span>
                                </div>

                            </div>
                        </div>
                        
                        <div class="row thumbnails">
                            @foreach ($ad->files as $index => $file)
                            <div class="col-md-4 col-xs-6 thumbnail">
                                <div class="aspect-ratio-box image-wrapper-auto mb-3">
                                    <img src="{{ $file->getPathAttribute() }}" width="100%"/>
                                </div>
                                @if($index > 0)
                                <a class="btn btn-danger btn-sm delete-image" data-file_id="{{$file->id}}" href="javascript:void();" >x</a>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <h5> {{ __('ads.interior_option') }} </h5>
                                <div class="row">
                                    @foreach (__('ads.interior_options') as $key => $option)
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="option_{{$key}}" value="{{$key}}" name="interior_options[]" @if ( in_array($key, $ad->interior_options) ) checked @endif>
                                                <label class="custom-control-label" for="option_{{$key}}">{{$option}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <br> </br>
                            <div class="col-md-12 mt-3">
                                <h5> {{ __('ads.inclusion_option') }} </h5>
                                <div class="row">
                                    @foreach (__('ads.inclusion_options') as $key => $option)
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="option_{{$key}}" value="{{$key}}" name="inclusion_options[]" @if ( in_array($key, $ad->inclusion_options) ) checked @endif>
                                                <label class="custom-control-label" for="option_{{$key}}">{{$option}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Ad fields end-->
 
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-round">
                                    {{ __('ads.next_step') }}
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{ route('ads.update', $ad->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field("PUT") }}
                        <div class="form-group row">
                            @php( $old_monthly_payments_before_taxes = old('monthly_payments_before_taxes') ? old('monthly_payments_before_taxes') : $ad->lease->monthly_payments_before_taxes )
                            <div class="col-md-6">
                                <label for="monthly_payments_before_taxes" class="col-form-label text-md-right">{{ __('ads.lease.monthly_payments_before_taxes') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="monthly_payments_before_taxes" type="number" min="0" class="form-control @error('monthly_payments_before_taxes') is-invalid @enderror" name="monthly_payments_before_taxes" value="{{ $old_monthly_payments_before_taxes }}" required autocomplete="monthly_payments_before_taxes" >
                                </div>
                                @error('monthly_payments_before_taxes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php( $old_monthly_payments_after_taxes = old('monthly_payments_after_taxes') ? old('monthly_payments_after_taxes') : $ad->lease->monthly_payments_after_taxes )
                            <div class="col-md-6">
                                <label for="monthly_payments_after_taxes" class="col-form-label text-md-right">{{ __('ads.lease.monthly_payments_after_taxes') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="monthly_payments_after_taxes" type="number" min="0" class="form-control @error('monthly_payments_after_taxes') is-invalid @enderror" name="monthly_payments_after_taxes" value="{{ $old_monthly_payments_after_taxes }}" required autocomplete="monthly_payments_after_taxes" >
                                </div>
                                @error('monthly_payments_after_taxes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_initial_down_payment = old('initial_down_payment') ? old('initial_down_payment') :  $ad->lease->initial_down_payment )
                            <div class="col-md-6">
                                <label for="initial_down_payment" class="col-form-label text-md-right">{{ __('ads.lease.initial_down_payment') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="initial_down_payment" type="number" min="0" class="form-control @error('initial_down_payment') is-invalid @enderror" name="initial_down_payment" value="{{ $old_initial_down_payment }}" required autocomplete="initial_down_payment" >
                                </div>
                                @error('initial_down_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php( $old_security_deposit = old('security_deposit') ? old('security_deposit') :  $ad->lease->security_deposit )
                            <div class="col-md-6">
                                <label for="security_deposit" class="col-form-label text-md-right">{{ __('ads.lease.security_deposit') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="security_deposit" type="number" min="0" class="form-control @error('security_deposit') is-invalid @enderror" name="security_deposit" value="{{ $old_security_deposit }}" required autocomplete="security_deposit">
                                </div>
                                @error('security_deposit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_purchase_option = old('purchase_option') ? old('purchase_option') :  $ad->lease->purchase_option )
                            <div class="col-md-6">
                                <label for="purchase_option" class="col-form-label text-md-right">{{ __('ads.lease.purchase_option') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="purchase_option" type="number" min="0" class="form-control @error('purchase_option') is-invalid @enderror" name="purchase_option" value="{{ $old_purchase_option }}" required autocomplete="purchase_option">
                                </div>
                                @error('purchase_option')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php( $old_contract_kilometers = old('contract_kilometers') ? old('contract_kilometers') :  $ad->lease->contract_kilometers )
                            <div class="col-md-6">
                                <label for="contract_kilometers" class="col-form-label text-md-right">{{ __('ads.lease.contract_kilometers') }}</label>
                                <div class="input-group mb-3">
                                    <input id="contract_kilometers" type="number" min="0" class="form-control @error('contract_kilometers') is-invalid @enderror" name="contract_kilometers" value="{{ $old_contract_kilometers }}" required autocomplete="contract_kilometers" >
                                </div>
                                @error('security_deposit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_excess_mileage_fee = old('excess_mileage_fee') ? old('excess_mileage_fee') :  $ad->lease->excess_mileage_fee )
                            <div class="col-md-6">
                                <label for="excess_mileage_fee" class="col-form-label text-md-right">{{ __('ads.lease.excess_mileage_fee') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="excess_mileage_fee" type="number" min="0" class="form-control @error('excess_mileage_fee') is-invalid @enderror" name="excess_mileage_fee" value="{{ $old_excess_mileage_fee }}" required autocomplete="excess_mileage_fee" >
                                </div>
                                @error('excess_mileage_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php( $old_contract_start_date = old('contract_start_date') ? old('contract_start_date') :  Carbon\Carbon::parse($ad->lease->contract_start_date)->format('d-m-Y') )
                            <div class="col-md-6">
                                <label for="contract_start_date" class="col-form-label text-md-right">{{ __('ads.lease.contract_start_date') }}</label>
                                <div class="input-group mb-3">
                                    <input id="contract_start_date" data-provide="datepicker" data-date-format="dd-mm-yyyy" type="text" class="form-control @error('contract_start_date') is-invalid @enderror" name="contract_start_date" value="{{ $old_contract_start_date }}" required autocomplete="contract_start_date">
                                </div>
                                @error('contract_start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_contract_duration = old('contract_duration') ? old('contract_duration') :  $ad->lease->contract_duration )
                            <div class="col-md-6">
                                <label for="contract_duration" class="col-form-label text-md-right">{{ __('ads.lease.contract_duration') }}</label>
                                <div class="input-group mb-3">
                                    <input id="contract_duration" type="number" min="0" class="form-control @error('contract_duration') is-invalid @enderror" name="contract_duration" value="{{ $old_contract_duration }}" required autocomplete="contract_duration" min="1">
                                </div>
                                @error('contract_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php( $old_contract_end_date = old('contract_end_date') ? old('contract_end_date') :  Carbon\Carbon::parse($ad->lease->contract_end_date)->format('d-m-Y') )
                            <div class="col-md-6">
                                <label for="contract_end_date" class="col-form-label text-md-right">{{ __('ads.lease.contract_end_date') }}</label>
                                <div class="input-group mb-3">
                                    <input id="contract_end_date" data-provide="datepicker" data-date-format="dd-mm-yyyy" type="text" class="form-control @error('contract_end_date') is-invalid @enderror" name="contract_end_date" value="{{ $old_contract_end_date }}" required autocomplete="contract_end_date">
                                </div>
                                @error('contract_end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_incentive_amount = old('incentive_amount') ? old('incentive_amount') :  $ad->lease->incentive_amount )
                            <div class="col-md-6">
                                <label for="incentive_amount" class="col-form-label text-md-right">{{ __('ads.lease.incentive_amount') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="incentive_amount" type="number" min="0" class="form-control @error('incentive_amount') is-invalid @enderror" name="incentive_amount" value="{{ $old_incentive_amount }}" required autocomplete="incentive_amount" >
                                </div>
                                @error('incentive_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php( $old_deposit_amount = old('deposit_amount') ? old('deposit_amount') :  $ad->lease->deposit_amount )
                            <div class="col-md-6">
                                <label for="deposit_amount" class="col-form-label text-md-right">{{ __('ads.lease.deposit_amount') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="deposit_amount" type="number" min="0" class="form-control @error('deposit_amount') is-invalid @enderror" name="deposit_amount" value="{{ $old_deposit_amount }}" required autocomplete="deposit_amount" >
                                </div>
                                @error('deposit_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @php( $old_transfer_fees = old('transfer_fees') ? old('transfer_fees') :  $ad->lease->transfer_fees )
                            <div class="col-md-6">
                                <label for="transfer_fees" class="col-form-label text-md-right">{{ __('ads.lease.transfer_fees') }}</label>
                                <select id="transfer_fees" class="form-control @error('transfer_fees') is-invalid @enderror" name="transfer_fees" required>
                                    @foreach (__('ads.lease.transfer_fees_options') as $key => $option)
                                    <option value="{{$key}}" @if ($old_transfer_fees == $key) selected @endif> {{$option}}</option>
                                    @endforeach
                                </select>

                                @error('transfer_fees_options')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            @if(str_replace('_', '-', app()->getLocale()) == 'fr')
                                @php( $old_title = old('title') ? old('title') :  $ad->title_fr )
                            @else
                                @php( $old_title = old('title') ? old('title') :  $ad->title )
                            @endif
                            <div class="col-md-12">
                                <label for="title" class="col-form-label text-md-right">{{ __('ads.title') }}</label>
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $old_title }}" required autocomplete="title">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            @if(str_replace('_', '-', app()->getLocale()) == 'fr')
                                @php( $old_description = old('description') ? old('description') :  $ad->description_fr )
                            @else
                                @php( $old_description = old('description') ? old('description') :  $ad->description_fr )
                            @endif
                            
                            <div class="col-md-12">
                                <label for="description" class="col-form-label text-md-right">{{ __('ads.description') }}</label>
                                <textarea name="description" id="description" class="form-control" rows="5">{{ $old_description }}</textarea>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-round">
                                    {{ __('ads.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts-vars')
<script>
    var options ={!! json_encode(__('ads.model_options')) !!};
    var old_model = '{{ $old_model ?? ''}}';
    var validationRequired = "{{ __('auth.required') }}";
    var validationPattern = "{{ __('auth.invalid_info') }}";
</script>
@endpush

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        var SITEURL = "{{url('/files')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.delete-image', function () {
            var that = $(this);
            var file_id = that.data('file_id');
            that.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            );
            
            $.ajax({
                type: "DELETE",
                url: SITEURL + '/' +file_id,
                success: function (data) {
                    that.parent().remove();
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        }); 
    })(jQuery);
});
</script>
@endpush

@endsection
