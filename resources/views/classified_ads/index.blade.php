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
	    	<a class="btn btn-success" href="{{route('chatrooms.index')}}">Messages</a> <br>
	    </div>
	    <div class="col-8">
	    	<div class="card card-primary">
              <div class="card-header d-flex justify-content-center">
                <h3 class="card-title">Categories</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
						<table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Category name</th>
						      <th scope="col">Ad Count</th>
						      <th scope="col">Classified Ads</th>
						      <th>Add New</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($categories as $category)
						    <tr>
						      	<td></td>
						      	<td>{{$category->category_name}}</td>
						      	<td>{{$category->classified_ads()->where('approved', 1)->count()}}</td>
						      	<td>
						      		@php($row_count= 0)
						      		@foreach ($category->classified_ads()->where('approved', 1)->get() as $classified_ad)
						      			{{++$row_count}}. <a href="{{route('classified_ads.show', ['classified_ad'=>$classified_ad->id])}}"> {{$classified_ad->title}}(
					      				 	{{($classified_ad->user->id== Auth::id())?'YOU':$classified_ad->user->name}} )
						      			</a>
						      			<br>
						      		@endforeach
						      	</td>
						      	<td>
						      		<a type="button" class="btn btn-warning" href="{{route('classified_ads.create', ['cat_id'=> $category->id])}}">+</a>
						      	</td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>
	    		</div>
	    	<div class="col-2">
	    </div>
	  </div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
