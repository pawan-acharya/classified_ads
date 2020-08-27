<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>
	<div class="container">
	  	<div class="row">
	  		<div class="col-sm-8">
	  			<div class="row">
	  				<div class="col-sm-6 card">
	  					<div class="card-body">
	  						
	  					</div>
	  				</div>
	  				<div class="col-sm-3 card">
	  					<div class="card-body">
	  						
	  					</div>
	  				</div>
	  				<div class="col-sm-3 card">
	  					<div class="card-body">
	  						
	  					</div>
	  				</div>
	  			</div>

	  			<div class="row">
	  				@foreach ($form_items_collection->where('type', '=', 'box') as $form_item)
	  				<div class="col-sm-6 card">
	  					<div class="card-header">
	  						{{$form_item->name}}
	  					</div>
	  					<div class="card-body">
	  						@foreach ($form_item->children as $child)
	  							{{$child->name}}: {{json_decode($classified_ad->form_values, TRUE)[$child->id]}} <br>
	  						@endforeach
	  					</div>
	  				</div>
  					@endforeach	
	  			</div>
	  		</div>	
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>



