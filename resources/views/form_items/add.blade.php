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
    	<form method="POST" action="{{ route('form_items.store', ['id'=> $id]) }}" id="add_new_field_form">
    		@csrf
	  		<div id="container">
		  			
	  		</div>
		  	<a href="javascript:void(0);"  class="btn btn-danger" onclick="return addNewColumn()">+</a> <br>
		  	<button type="submit" class="btn btn-primary">Submit</button>
		</form>
    </div>
    <div class="col-sm">
    </div>
	

	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	
	<script type="text/javascript">
		var js_array= [];
	 	js_array= {!! json_encode(config('form_items')) !!} ;
		function addNewColumn(){
			var html=`<div class="form-group">
				    <select  class="form-control"  name="types[]">`;
				    	for (var key in js_array) {
						  html+=`<option value= `+key+`>`+js_array[key]+`</option>`;
						}
		     	html+=`</select>
				    <input type="text" class="form-control" placeholder="Enter name for the form" name="names[]" required>
				    <select  class="form-control"  name="mandatories[]">
				    	<option value= 'yes'>Required</option>
				    	<option value='no'>NOt Required</option>
				    </select>
				    <button type="button" class="btn btn-danger" onclick="removeThisItem(this)">X</button>
			  	</div>` ;
			$('#add_new_field_form>#container').append(html);
		}

		function removeThisItem(val){
			val.parentElement.remove();
		}
	</script>
	
</body>
</html>
