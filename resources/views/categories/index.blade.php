<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	<div class="container">
		<div class="sticky-top" style="text-align: center;">
			<a type="button" class="btn btn-success " href="{{route('categories.create')}}">Add new category</a>
		</div>
	  <div class="row">
	    <div class="col-2">
	    </div>
	    <div class="col-8">
	    	<div class="card card-primary">
              <div class="card-header d-flex justify-content-center">
                <h3 class="card-title">Categories</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
		     	 	@foreach($categories as $category)
						<div class="col-sm-4">
							<a href="{{route('categories.show',['category'=>$category->id])}}">
			                    <div class="position-relative p-3" style="height: 180px; color:black">
			                      <div class="ribbon-wrapper">
			                        <div class="ribbon bg-primary">
			                          {{$category->category_name}}
			                        </div>
			                      </div>
			                       <br>
			                      <small>{{$category->description}}</small>
			                    </div>
		                    </a>
	                  	</div>
					@endforeach

	    </div>
	    <div class="col-2">
	    </div>
	  </div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
