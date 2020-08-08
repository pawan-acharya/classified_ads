<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	<div class="container">
		<a type="button" class="btn btn-success" href="{{route('categories.create')}}">Add new category</a>
	  <div class="row">
	    <div class="col-2">
	    </div>
	    <div class="col-8">
     	 	@foreach($categories as $category)
				{{$category->category_name}}
				
					[
					<br>
						@foreach($category->form_items as $form_item)
							[
								{{$form_item->name}}, 
								{{config('form_items')[$form_item->type]}}, 
								{{($form_item->required== 1)? 'required': 'not-required'}}
							],
							<br>
						@endforeach
					],
				<a type="button" class="btn btn-primary" href="{{route('categories.show',['category'=>$category->id])}}">View</a>
				<a type="button" class="btn btn-danger" href="{{route('categories.edit',['category'=>$category->id])}}">Edit</a>
				<br>
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
