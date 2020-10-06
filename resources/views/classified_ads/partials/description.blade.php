<div class="detail-wrapper">
    @if ($classified_ad->location)
     <div class="details">
         <h5>{{$classified_ad->location}}</h5>
    </div>
    @endif
    <div class="detail-heading-wrapper d-flex">
        <h1 class="detail-head">{{$classified_ad->title}}</h1>
        <div class="ad-sharing-tool">
            @if($classified_ad->is_wishlisted)
            <a href="javascript:void()" class="ad-sharing-tool-link"><i class="far fa-heart"></i>{{ __('ads.added_to_favorites') }}</a>
            @else 
            <a href="javascript:void()" id="add-to-wishlist" class="ad-sharing-tool-link" onclick="addToFavoutires({{$classified_ad->id}})"><i class="far fa-heart"></i>{{ __('ads.add_to_favorites') }}</a>
            @endif
        </div>  
        <div class="ad-sharing-tool ml-auto">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" class="ad-sharing-tool-link"><i class="fas fa-share-square"></i> {{ __('ads.send_friend') }}</a>
        </div>
    </div>
    
    <div class="details">
        <h5> CITQ:{{$classified_ad->citq}}</h5>
    </div>
    <div class="details pricings">
        <ul class="d-flex price-list">
            <li class="price-list-item">
                <h5>
                    {{$classified_ad->price}}  {{$classified_ad->price_for?'PER: ':''}} {{$classified_ad->price_for}}
                </h5>
            </li>
            @foreach ($form_items_collection->where('type', '=', 'secondary_price') as $form_item)
            @foreach($form_item->children as $child)
            <li class="price-list-item"> 
                <h5 class="col-12">
                    {{json_decode($classified_ad->form_values, TRUE)[$form_item->id]}} : Per {{$form_item->children()->first()->name}}
                </h5> 
            </li>
            @endforeach
            @endforeach
        </ul>
    </div>
    @if ($classified_ad->url)
    <div class="row">
        <div class="col-12 details">
            <h3 class="col-12"> URL:{{$classified_ad->url}}</h3>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="details features">
        @foreach ( $form_items_collection->whereNotIn('type', ['select', 'check_box', 'box', 'secondary_price']) as $form_item ) 
            <div class="detail-item d-flex">
                <p class="detail-item-text font-weight-bold">{{$form_item->name}}</hp>
                <p class="detail-item-value mb-0">{{json_decode($classified_ad->form_values, TRUE)[$form_item->id]}}</p>
            </div>
        @endforeach
        </div>

        @foreach ($form_items_collection->where('type', '=', 'check_box') as $form_item)
        <div class="details features">
            <h5>{{$form_item->name}}</h5>
            <ul class="property-list">
                @foreach($form_item->children as $child)
                <li>{{array_key_exists($child->id, json_decode($classified_ad->form_values, TRUE))?$child->name:''}}</li>
                @endforeach
            </ul>
        </div>
        @endforeach
    
        @foreach ($form_items_collection->where('type', '=', 'select') as $form_item)
        <div class="details features">
            <h5>{{$form_item->name}}</h5>
            <ul class="property-list">
                @foreach($form_item->children as $child)
                <li>{{json_decode($classified_ad->form_values, TRUE)[$form_item->id]== $child->id?$child->name:""}}</li>
                @endforeach
            </ul>
        </div>
        @endforeach
   
        @foreach ($form_items_collection->where('type', '=', 'box') as $form_item)
        <div class="details features">
            <h5>{{$form_item->name}}</h5>
            <div class="card-body">
                @foreach ($form_item->children as $child)
                    <img src="{{asset('storage')}}/{{$child->logo}}" style="height: 15px;">
                    {{$child->name}}: {{json_decode($classified_ad->form_values, TRUE)[$child->id]}} <br>
                @endforeach
            </div>
        </div>
        @endforeach 
    </div>
</div>

<div class="ad-description-wrapper">
    <h5 class="ad-description-title"> {{ __('ads.ad_description') }} </h5>
    <p class="ad-description-text"> {{ $classified_ad->descriptions }} </p>
</div>