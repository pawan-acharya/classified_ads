<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	Category: {{$classified_ad->category->category_name}} 
	<br>
	----------------------------------------------------------------
	<br>
		<a href="{{route('classified_ads.index')}}">Back</a> <br>
		@if (Auth::user()->checkIfOwner($classified_ad->id, 'classified_ad'))
			<a href="{{route('classified_ads.edit',['classified_ad'=> $classified_ad->id])}}">Edit</a>
			<form action="{{route('classified_ads.destroy',['classified_ad'=> $classified_ad->id])}}" method="POST">
				@csrf
				@method('DELETE')
				<button type="submit" >Delete</button>
			</form>
			<a href="{{route('chats.index',['classified_ad_id'=> $classified_ad->id])}}">Messages on this chat</a>
		@endif
	<br>
	----------------------------------------------------------------
	<br>
	@foreach (json_decode($classified_ad->form_values) as $key=>$value)
		{{$form_items_collection->find($key)->name}}-{{$value}}
		<br>
	@endforeach

	<br>
	<br>
	<br>

	@if (!Auth::user()->checkIfOwner($classified_ad->id, 'classified_ad') )
		@include('chats.visitors.index')
		@include('chats.visitors.reply')
	@endif

	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<script type="text/javascript">
		/*$( document ).ready(function() {
		    $.get( "{{route('chats.create', ['id'=>$classified_ad->id ])}}", function( data ) {
			  console.log(data);
			});
		});*/
	</script>
</body>
</html>



