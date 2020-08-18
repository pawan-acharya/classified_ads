<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	<div class="container">
		
		<div class="sticky-top" style="text-align: center;">
			<a type="button" class="btn btn-success" href="{{route('categories.create')}}">Add new category</a>
		</div>
	  	<div class="row">
		    <div class="col-2">
		    	<a type="button" class="btn btn-warning d-flex justify-content-center" href="{{route('categories.index')}}">Go Back</a>
		    </div>
		    <div class="col-8">
		    	<div class="card card-primary">
	              <div class="card-header d-flex justify-content-center">
	                <h3 class="card-title">{{$category->category_name}}</h3>
	              </div>
	              <!-- /.card-header -->
	              	<div class="card-body">
	                	<table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Field Name</th>
						      <th scope="col">FIeld Type</th>
						      <th scope="col">Required</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@php($row_count= 0)
						  	@foreach($category->form_items as $form_item)
						    <tr>
						      <th scope="row">{{++$row_count}}</th>
						      <td>{{$form_item->name}}</td>
						      <td>{{config('form_items')[$form_item->type]}}</td>
						      <td>{{($form_item->required== 1)? 'YES': 'NO'}}</td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>
	    			</div>

			  	</div>
			</div>
			<div class="col-2">
		    	<a type="button" class="btn btn-warning d-flex justify-content-center" href="{{route('categories.edit', ['category'=> $category->id])}}">Edit</a>
		    </div>
	    </div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
