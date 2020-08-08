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
    	<form method="POST" action="{{ route('classified_ads.update', ['classified_ad'=> $classified_ad->id]) }}" id="edit_classified_ad">
    		@csrf
    		@method('PUT')
	  		<div class="form-group">
			    <label for="exampleInputEmail1">Static Field 1</label>
			    <input type="text" class="form-control" aria-describedby="emailHelp" value="Static field isn't be saved" required>
			    <small id="emailHelp" class="form-text text-muted">&Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</small>
		  	</div>
		  	<div class="form-group">
			    <label for="exampleInputEmail1">Static Field 2</label>
			    <input type="text" class="form-control"  aria-describedby="emailHelp" value="Static field isn't be saved"  required>
			    <small id="emailHelp" class="form-text text-muted">&Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</small>
		  	</div>
		  	<div class="form-group">
			    <label for="exampleInputEmail1">Static Field 3</label>
			    <input type="text" class="form-control" aria-describedby="emailHelp" value="Static field isn't be saved" required>
			    <small id="emailHelp" class="form-text text-muted">&Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</small>
		  	</div>

		  	@include('classified_ads.partials.edit')

		  	<button type="submit" class="btn btn-primary">Submit</button>
		</form>
    </div>
    <div class="col-sm">
    </div>

	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>