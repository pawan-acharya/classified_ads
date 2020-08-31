<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	<div class="row">
    <div class="col-sm">
    	
    </div>
    <div class="col-sm">
    	<div class=" card">
    		<div class="card-header">
    			<select class="form-control" id="category-select" onchange="getCategoryForm($(this))">
	    			@foreach ($categories as $category)
	    				<option value="{{$category->id}}" {{$category->id==$category_id?'selected':''}}> {{$category->category_name}} </option>
	    			@endforeach
    			</select>
    		</div>
    	</div>
    	<div class=" card">
    		<div class="card-header">
    			Fill the form
    		</div>
    		<div class="card-body" id="category_form_here">
		    	
			</div>
    	</div>
    </div>
    <div class="col-sm">
    </div>

	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<script type="text/javascript">
		function getCategoryForm(item){
			var cat_id= item.val();
			url= "{{route('classified_ads.create', ':cat_id')}}";
			url= url.replace(':cat_id', cat_id);
			$.get(url, function(response){
				$('#category_form_here').html(response);
			});
		}
		getCategoryForm($('#category-select'));
	</script>
</body>
</html>