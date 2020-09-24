<div class="detail-wrapper">
    <h1 class="section-head">{{$classified_ad->title}}</h1>
    <div class="details">
        <h5> CITQ:{{$classified_ad->citq}}</h5>
    </div>
    <div class="details pricings">
         @foreach ($form_items_collection->where('type', '=', 'secondary_price') as $form_item)
            <ul class="d-flex price-list">
                <li class="price-list-item">
                    <h5>
                        {{$classified_ad->price}}  {{$classified_ad->price_for?'PER: ':''}} {{$classified_ad->price_for}}
                    </h5>
                </li>
                @foreach($form_item->children as $child)
                <li class="price-list-item"> 
                    <h5 class="col-12">
                        {{json_decode($classified_ad->form_values, TRUE)[$form_item->id]}} : Per {{$form_item->children()->first()->name}}
                    </h5> 
                </li>
                @endforeach
            </ul>
        @endforeach
    </div>
    <div class="row">
        @foreach ( $form_items_collection->whereNotIn('type', ['select', 'check_box', 'box', 'secondary_price']) as $form_item ) 
        <div class="details features">
            <div class="detail-item">
                <p class="detail-item-text mb-0 col-7 font-weight-bold">{{$form_item->name}}</hp>
                <p class="detail-item-value mb-0 col-5">{{json_decode($classified_ad->form_values, TRUE)[$form_item->id]}}</p>
            </div>
        </div>
        @endforeach

        @foreach ($form_items_collection->where('type', '=', 'check_box') as $form_item)
        <div class="details features">
            <h5>{{$form_item->name}}</h5>
            <div class= "container">
                <ul class="property-list">
                    @foreach($form_item->children as $child)
                    <li>{{array_key_exists($child->id, json_decode($classified_ad->form_values, TRUE))?$child->name:''}}</li>
                    @endforeach
                </ul>
            </div>
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
    