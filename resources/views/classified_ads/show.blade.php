
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
                <h1 class="text-center section-head">{{$classified_ad->title}}</h1>
                @if ($classified_ad->user->id == Auth::id())
                     <a href="{{ route('classified_ads.review', ['classified_ad'=>$classified_ad->id]) }}" class=" no-print" style="float: right;">
                        <i class="fa fa-angle-left"></i>
                        Review Page
                    </a>
                @endif
                <div class="row ad-single mb-4">
                    <div class="col-md-8 col-12">
                        @include('classified_ads.partials.main')
                        @include('classified_ads.partials.description')
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
                                @if($classified_ad->is_wishlisted)
                                <a href="javascript:void()" class="ad-sharing-tool-link"><i class="fab fa-gratipay"></i> {{ __('ads.added_to_favorites') }}</a>
                                @else 
                                <a href="javascript:void()" id="add-to-wishlist" class="ad-sharing-tool-link" onclick="addToFavoutires({{$classified_ad->id}})"><i class="fab fa-gratipay"></i> {{ __('ads.add_to_favorites') }}</a>
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

    
</section>

@push('js')
<script type="text/javascript">
    function addToFavoutires(id){
            url= "{{route('wishlists.create', ':classified_ad_id')}}";
            url= url.replace(':classified_ad_id', id);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
            })
            .done(function( data ) {
            });
    }
</script>

@endpush

@endsection




