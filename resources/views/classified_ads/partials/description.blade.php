<div class="detail-wrapper">
    <div class="row">
        <div class="col-12 details">
            <h5 class="col-12"> CITQ:{{$classified_ad->citq}}</h5>
        </div>
    </div>
    <div class="col-12 details">
         <h5 class="col-12">
             {{$classified_ad->price}}  {{$classified_ad->price_for?'PER: ':''}} {{$classified_ad->price_for}}
         </h5>
    </div>

    <div class="row">
        <div class="col-12 details">
            @foreach ( $form_items_collection->whereNotIn('type', ['select', 'check_box', 'box', 'secondary_price']) as $form_item ) 
                <div class="detail-item">
                    <p class="detail-item-text mb-0 col-7 font-weight-bold">{{$form_item->name}}</hp>
                    <p class="detail-item-value mb-0 col-5">{{json_decode($classified_ad->form_values, TRUE)[$form_item->id]}}</p>
                </div>
            @endforeach
            <hr class="solid">
        </div>
    </div>

    <div class="row">
        <div class="col-12 details">
            @foreach ($form_items_collection->where('type', '=', 'secondary_price') as $form_item)
                <div class= "row container">
                    <ul class="col-7 property-list">
                        @foreach($form_item->children as $child)
                        <li> 
                            <h5 class="col-12">
                                {{json_decode($classified_ad->form_values, TRUE)[$form_item->id]}} : Per {{$form_item->children()->first()->name}}
                            </h5> 
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            <hr class="solid">
        </div>
    </div>

    <div class="row">
        <div class="col-12 details">
            @foreach ($form_items_collection->where('type', '=', 'check_box') as $form_item)
                <h5 class="col-12">{{$form_item->name}}</h5>
                <div class= "row container">
                    <ul class="col-7 property-list">
                        @foreach($form_item->children as $child)
                        <li>{{array_key_exists($child->id, json_decode($classified_ad->form_values, TRUE))?$child->name:''}}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            <hr class="solid">
        </div>
    </div>

    <div class="row">
        <div class="col-12 details">
            @foreach ($form_items_collection->where('type', '=', 'select') as $form_item)
                <h5 class="col-12">{{$form_item->name}}</h5>
                <div class= "row container">
                    <ul class="col-7 property-list">
                        @foreach($form_item->children as $child)
                        <li>
                            @if (array_key_exists($form_item->id, json_decode($classified_ad->form_values, TRUE)))
                                {{json_decode($classified_ad->form_values, TRUE)[$form_item->id]== $child->id?$child->name:""}}
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            <hr class="solid">
        </div>
    </div>

    <div class="row">
        <div class="col-12 details">
           
            @foreach ($form_items_collection->where('type', '=', 'box') as $form_item)
            <div class="col-sm-6  detail-item">
                <h5 class="col-12">{{$form_item->name}}</h5>
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
</div>