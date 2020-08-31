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
    	<form method="POST" action="{{ route('classified_ads.store', ['cat_id'=> $category->id]) }}" id="add_new_classified_ad" class="row" enctype="multipart/form-data">
    		@csrf
	  		<div class="form-group col-sm-6">
			    <label for="exampleInputEmail1">Title</label>
			    <input type="text" class="form-control"  name="title" required>
		  	</div>
		  	<div class="form-group col-sm-6">
			    <label for="exampleInputEmail1">#CITQ</label>
			    <input type="text" class="form-control" name="citq" required>
		  	</div>
		  	<div class="col-sm-12 row" id="image-div">
			  	<div class="form-group col-sm-6">
				    <label for="exampleInputEmail1">#Images</label>
				    <input type="file" class="" name="title_images[]" required>
			  	</div>
			  	<div class="form-group  col-sm-3">
			    	<button type="button" class="btn btn-secondary " onclick="addNewImageDiv()">+</button>
			    	{{-- <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button> --}}
				</div>
			</div>
		  	<div class="form-group col-sm-12">
			    <label for="exampleInputEmail1">Description</label>
			    <textarea class="form-control"  name="descriptions"></textarea>
		  	</div>

		  	@include('classified_ads.partials.add')
		  	
		  	<div class="form-group col-sm-6">
		  		<button type="submit" class="btn btn-primary">Submit</button>
		  	</div>
		</form>
    </div>
    <div class="col-sm">
    </div>

	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<script type="text/javascript">
		function addNewImageDiv(){
			var html= `<div class="form-group col-sm-6">
			    <input type="file" class="" name="title_images[]" >
		  	</div>
		  	<div class="form-group col-sm-6">
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
		  	</div>`;
		  	$('#image-div').append(html);
		}

		function removeThisItem(item){
			item.parent().prev().remove();
			item.parent().remove();	
		}
	</script>
</body>
</html>