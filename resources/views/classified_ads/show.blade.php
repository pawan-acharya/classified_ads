{{-- Category: {{$classified_ad->category->category_name}} 
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
@endforeach --}}




<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	<div class="container">
	  <div class="row">
	    <div class="col-2">
	    	<a class="btn btn-warning" href="{{route('classified_ads.index')}}">Back</a> <br>
	    </div> 
	    <div class="col-8">
	    	<div class="card card-primary">
              <div class="card-header d-flex justify-content-center">
                <h3 class="card-title">Category:  {{$classified_ad->category->category_name}} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
						<table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">Field Name</th>
						      <th scope="col">Value</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach (json_decode($classified_ad->form_values) as $key=>$value)
						    <tr>
						      	<td>{{$form_items_collection->find($key)->name}}</td>
						      	<td>{{$value}}</td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>
	    		</div>
	    		@if(Auth::id()== $classified_ad->user->id)
					<form action="{{route('classified_ads.destroy',['classified_ad'=> $classified_ad->id])}}" method="POST">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger" type="submit" >Delete</button>
					</form>
				@else
					@include('feedbacks.partials.add')
				@endif
	    	
	  		</div>
		</div>
		</div>
		@if(Auth::id()== $classified_ad->user->id)
		<div class="col-2">
	    	<a class="btn btn-warning" href="{{route('classified_ads.edit',['classified_ad'=> $classified_ad->id])}}">Edit</a>
	    </div> 
	    @endif
		</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>



