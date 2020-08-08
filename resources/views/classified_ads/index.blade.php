@foreach ($categories as $category)
	<a type="button" class="btn btn-warning" href="{{route('classified_ads.create', ['cat_id'=> $category->id])}}">+</a>
	{{$category->category_name}} :- 
	@foreach ($category->classified_ads as $classified_ad)
	<a href="{{route('classified_ads.show', ['classified_ad'=>$classified_ad->id])}}">id:-{{$classified_ad->id}}:- Show</a>,
	@endforeach
	<br>
@endforeach