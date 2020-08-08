@extends('layouts.app')

@section('content')
<section id="single-ad-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ Str::contains(url()->previous(), 'ads')? url()->previous() : route('home') }}" class="return-button no-print">
                    <i class="fa fa-angle-left"></i>
                    {{ Str::contains(url()->previous(), 'ads')?  __('ads.return_results') : __('ads.return_to_my_account') }}
                </a>
                <h1 class="text-center section-head">{{$ad->title}}</h1>
                <div class="row ad-single mb-4">
                    <div class="col-md-6 col-12">
                        @include('ads.partials.main')
                    </div>

                    <div class="col-md-6 col-12">
                        @include('ads.partials.description')
                    </div>
                </div>
                <div class="row justify-content-center no-print">
                    <div class="row col-md-8 single-ad-tools ">
                        <div class="col-md-4"> 
                            <a @if(Auth::check()) data-toggle="modal" data-target="#user-modal" @else href="{{ route('login') }}" @endif class="btn btn-primary btn-round text-white">
                                {{ __('ads.contact_announcer') }}
                            </a>    
                        </div>
                        <div class="row col-md-8"> 
                            <div class="col-md-4 ad-sharing-tool">
                                <a href="javascript:void();" id="print-ad" class="ad-sharing-tool-link"><i class="fas fa-print"></i> {{ __('ads.print') }}</a>
                            </div>  
                            <div class="col-md-4 ad-sharing-tool">
                                @if($ad->is_wishlisted)
                                <a href="javascript:void()" class="ad-sharing-tool-link"><i class="fab fa-gratipay"></i> {{ __('ads.added_to_favorites') }}</a>
                                @else 
                                <a href="javascript:void()" id="add-to-wishlist" class="ad-sharing-tool-link" data-ad_id="{{ $ad->id }}"><i class="fab fa-gratipay"></i> {{ __('ads.add_to_favorites') }}</a>
                                @endif
                            </div>  
                            <div class="col-md-4 ad-sharing-tool">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" class="ad-sharing-tool-link"><i class="fas fa-share-alt"></i> {{ __('ads.send_friend') }}</a>
                            </div>  
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ __('ads.user_details')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class= "row info-block"> 
                    <div class= "col-md-12"><span>{{ __('auth.first_name') }}:</span> {{$ad->user->first_name}} </div>
                    <div class= "col-md-12"><span>{{ __('auth.name') }}:</span> {{$ad->user->name}} </div>
                    <div class= "col-md-12"><span>{{ __('auth.home_phone') }}:</span> {{$ad->user->home_phone}} </div>
                    <div class= "col-md-12"><span>{{ __('auth.mobile_phone') }}:</span> {{$ad->user->mobile_phone}} </div>
                    @php($province_langkey = 'auth.province_options.'.$ad->user->province)
                    <div class= "col-md-12"><span>{{ __('auth.province') }}:</span> {{ __($province_langkey)}} </div>
                    <div class= "col-md-12"><span>{{ __('auth.postal_code') }}:</span> {{$ad->user->postal_code}} </div>
                    <div class= "col-md-12"><span>{{ __('auth.email') }}:</span> {{$ad->user->email}} </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('auth.close')}}</button>
            </div>
          </div>
        </div>
    </div>
</section>

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        var SITEURL = "{{ url('/wishlists') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '#print-ad', function () {
            $('#single-ad-page').print({
                addGlobalStyles : true,
                noPrintSelector: '.no-print'
            });
        });

        $('body').on('click', '#add-to-wishlist', function () {
            var that = $(this);
            var ad_id = that.data('ad_id');
            that.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            );
            
            $.ajax({
                type: "POST",
                url: SITEURL + '/' + ad_id,
                success: function (data) {
                    that.html(
                        "<i class='fab fa-gratipay'></i>{{ __('ads.added_to_favorites') }}"
                    );
                },
                error: function (error) {
                    that.html(
                        "<i class='fab fa-gratipay'></i> {{ __('ads.add_to_favorites') }}"
                    );
                    alert(error.responseJSON.message);
                    
                }
            });
        }); 
    })(jQuery);
});
</script>
@endpush

@endsection
