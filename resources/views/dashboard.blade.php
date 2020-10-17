@extends('layouts.app')

@section('content')

<section id="my-account">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-4 bg-white mt-4">
                    <h5 class="row-head">{{ __('auth.my_information') }}<a type="submit" href="{{ route('home.edit') }}" class="edit-account">{{ __('auth.edit') }}</a></h5>
                    <div class= "row info-block">
                        <div class= "col-md-3">
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.first_name') }}:</span> {{$user->partner?$user->partner->first_name:$user->first_name}} </div></div>
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.name') }}:</span> {{$user->partner?$user->partner->name:$user->name}} </div></div>
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.home_phone') }}:</span> {{$user->partner?$user->partner->home_phone:$user->home_phone}} </div></div>
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.mobile_phone') }}:</span> {{$user->partner?$user->partner->mobile_phone:$user->mobile_phone}} </div></div>
                        </div>
                        <div class= "col-md-3">
                            @php($province = $user->partner?$user->partner->province:$user->province)
                            @php($province_langkey = 'auth.province_options.'.$province)
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.province') }}:</span> {{ __($province_langkey)}} </div></div>
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.postal_code') }}:</span> {{$user->partner?$user->partner->postal_code:$user->postal_code}}</div></div>
                            @php($correspondence_language = $user->partner?$user->partner->correspondence_language:$user->correspondence_language)
                            @php($correspondence_language_langkey = 'auth.'.$correspondence_language)
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.correspondence_language') }}:</span> {{ __($correspondence_language_langkey) }}</div></div>
                            <div class= "row"> <div class= "col-md-12"><span>{{ __('auth.email') }}:</span> {{$user->partner?$user->partner->email:$user->email}} </div></div>
                        </div>
                        <div class= "col-md-3">
                            @if (Auth::user()->file)
                                {{-- <img src="{{ Auth::user()->file->getPathAttribute() }}" width="100%"/> --}}
                                <img src="{{ Auth::user()->file->getPathAttribute() }}" width="100%" class="displayimage"/>
                            @else
                                <img src="{{ asset('images/avatar.png') }}"/>
                            @endif
                            <form id="profile-pic" action="{{route('home.displayImage')}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <input type="file" name="image" onchange="$('#profile-pic').submit();">
                            </form>
                        </div>
                        <div class="col-md-3 text-right">
                            @if (Auth::user()->checkIfAdmin())
                                <a type="button" class="btn btn-secondary mb-2" data-dismiss="modal">Alreay a member</a>
                            @else
                                <a type="button" href="{{route('become_member')}}" class="btn btn-secondary mb-2" data-dismiss="modal">Become a member for a month</a>
                            @endif
                        
                            @if (!Auth::user()->checkIfAdmin())
                                @if (Auth::user()->getLeftAds('sales') > 0)
                                    <a type="button" href="#"  class="btn btn-secondary" data-dismiss="modal" >
                                        Remaining Ads :- {{Auth::user()->getLeftAds('sales')}}
                                        <br>
                                        Package:- {{ucfirst('sales')}}
                                    </a>
                                @elseif(Auth::user()->getLeftAds('rental') > 0)
                                    <a type="button" href="#"  class="btn btn-secondary" data-dismiss="modal" >
                                        Remaining Ads :- {{Auth::user()->getLeftAds('rental')}}
                                        <br>
                                        Package:- {{ucfirst('rental')}}
                                    </a>
                                @else
                                <a type="button" href="{{route('bulk_pay')}}" class="btn btn-secondary" data-dismiss="modal">
                                    Pay for Bulk Ads
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                @if($user->partner)
                    @if($user->partner->status=='approved')
                    <div class="mb-4 bg-white">
                        <div class="row-head">{{ __('auth.refer_a_friend') }}</div>
                        <div class= "row info-block">
                            <div class="card col-md-6">
                                <div class="card-body">
                                <h5 class="card-title">{{ __('auth.send_invitation')}}</h5>
                                <p class="card-text">{{ __('auth.send_invitation_title')}}</p>
                                <button data-toggle="modal" data-target="#email-modal" class="btn btn-secondary btn-round">{{ __('auth.send_invitation')}}</button>
                                </div>
                            </div>
                            <div class="card col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('auth.your_coupon_code')}}</h5>
                                    <a class="btn btn-lg btn-secondary text-white mb-2">{{ $user->partner->promocode->code }}</a>
                                    <p class="card-text">{{ __('auth.total_ads_referred')}} {{$totalAdsReferred}} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('auth.send_invitation')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert d-none" role="alert"></div>
                                    <form id="email-form" method="POST" action="{{ url("partners/approve") }}">
                                        @csrf
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="input-group control-group after-add-more col-md-12">
                                                    <input type="text" name="emails[]" class="form-control" placeholder="{{ __('auth.enter_email') }}" required>
                                                    <div class="input-group-btn"> 
                                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> +</button>
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Copy Fields -->
                                    <div class="copy d-none" >
                                    <div class="control-group input-group col-md-12 mt-3">
                                        <input type="text" name="emails[]" class="form-control" placeholder="{{ __('auth.enter_email') }}">
                                        <div class="input-group-btn"> 
                                        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> -</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('auth.close')}}</button>
                                <button id="email-form-submit" type="button" class="btn btn-primary">{{ __('auth.send')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

                <div class="ad-container">
                    <div class="row-head">{{ __('auth.my_ads') }}<a href="{{ route('classified_ads.create') }}" class= "btn btn-main"> {{ __('auth.create_ad') }}</a></div>
                    <div class="card-body">
                        <div class= "row">
                        @foreach ($ads as $index => $ad)
                            @include('ads.partials.ad',['parent' => 'edit'])
                        @endforeach
                        </div>
                    </div>
                </div>

                {{-- @if(count($expiredAds) > 0)
                <div class="completed-ads">
                    <div class="row-head">{{ __('auth.completed_ads') }}<img src="{{ asset('images/icon/arrow-down.png') }}" alt="Arrow Down" /></div>
                    <div class="card-body">
                        <div class= "row">
                            @foreach ($expiredAds as $index => $ad)
                                @include('ads.partials.ad',['parent' => 'my-account'])
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif --}}
            </div>
        </div>
    </div>
</section>

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        var SITEURL = '{{url('/')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".add-more").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });

        $('body').on('click', '#email-form-submit', function () {
            var that = $(this)
            $(this).prop("disabled", true);
            $(this).html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('auth.sending')}} ...`
            );

            $.ajax({
                type: "POST",
                url: SITEURL + "/action/invite",
                data: $('#email-form').serialize(),
                dataType: 'json',
                success: function (data) {
                    showAlert(that, 'success', data.message)
                },
                error: function (error) {
                    showAlert(that, 'danger', error.responseJSON.message)
                }
            });
        }); 

        function showAlert(button, alert, message) {
            button.html(`{{ __('auth.send')}}`).prop("disabled", false);
            $('.alert').removeClass('d-none').addClass('alert-'+alert);
            $('.alert').html(message);
            setTimeout(function(){ 
                $('.alert').addClass('d-none');
            }, 3000);
        }
    })(jQuery);
});
</script>
@endpush
@endsection
