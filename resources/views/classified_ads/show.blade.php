Category: {{$classified_ad->category->category_name}} 
<br>
----------------------------------------------------------------
<br>
	<a href="{{route('classified_ads.index')}}">Back</a> <br>
	@if(Auth::id()== $classified_ad->user->id)
		<a href="{{route('classified_ads.edit',['classified_ad'=> $classified_ad->id])}}">Edit</a>
		<form action="{{route('classified_ads.destroy',['classified_ad'=> $classified_ad->id])}}" method="POST">
			@csrf
			@method('DELETE')
			<button type="submit" >Delete</button>
		</form>
	@endif
<br>
----------------------------------------------------------------
<br>
@foreach (json_decode($classified_ad->form_values) as $key=>$value)
	{{$form_items_collection->find($key)->name}}-{{$value}}
	<br>
@endforeach

@if(Auth::id()!= $classified_ad->user->id)
	@include('feedbacks.partials.add')
@endif
