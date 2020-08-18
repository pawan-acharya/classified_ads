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
		    	<form class="" action="{{ route('categories.update', ['category'=> $category->id]) }}" method="POST">
		    		@csrf
					@method('PUT')
		    	<div class="card card-primary">
	              <!-- /.card-header -->
	              	<div class="card-body">
	              		<div class="form-group">
						    <label for="exampleInputEmail1">Category name:</label>
						    <input type="text" class="form-control" id="fname" name="category_name" value="{{$category->category_name}}">
					  	</div>
	    			</div>
			  	</div>

			  	<div class="card card-primary">
			  		<div class="card-header d-flex justify-content-center">
	                	<h5 class="card-title">Form Items</h5>
	              	</div>
	              <!-- /.card-header -->
	              	<div class="card-body" id="card_body">
	                	@foreach($category->form_items as $form_item)
				  			<div class="form-group">
				  				<input type="hidden" name="ids[]" value="{{$form_item->id}}" required>
				  				<div class="form-group">
				  					<label for="exampleInputEmail1">Field Name</label>
								    <select  class="form-control" id="exampleInputEmail1" name="types[]">
								    	@foreach(config('form_items') as $key=>$value)
									    	<option value='{{$key}}'
									    	{{$form_item->type == $key? 'selected':''}}
								    		>{{$value}}</option>
								    	@endforeach
								    </select>
							    </div>
							    <div class="form-group">
							    	<label for="exampleInputEmail1">Field Type</label>
							    	<input type="text" class="form-control" placeholder="Enter name for the form" name="names[]" value="{{$form_item->name}}">
							    </div>
							    <div class="form-group">
							    	<label for="exampleInputEmail1">Required/Not Required</label>
								    <select  class="form-control"  name="mandatories[]">
								    	<option value= 'yes'
								    	{{$form_item->required == 1? 'selected':''}}
								    	>Required</option>
								    	<option value='no'
								    	{{$form_item->required == 0? 'selected':''}}
								    	>NOt Required</option>
								    </select>
							    </div>
							    <button type="button" class="btn btn-danger" onclick="removeThisItem(this)">X</button>
						  	</div>
			  			@endforeach
	    			</div>
	    			<a href="javascript:void(0);"  class="btn btn-success" onclick="return addNewColumn()">Add another column+</a> 
			  	</div>
			  	<input type="submit" class="btn btn-primary" value="Submit">
			  	</form>
			</div>
			<div class="col-2">
		    </div>
	    </div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<script type="text/javascript">
		var js_array= [];
	 	js_array= {!! json_encode(config('form_items')) !!} ;
		function addNewColumn(){
			var html=`<div class="form-group">
					
					<input type="hidden" name="ids[]" value="0">
					<div class="form-group">
				    <select  class="form-control"  name="types[]">`;
				    	for (var key in js_array) {
						  html+=`<option value= `+key+`>`+js_array[key]+`</option>`;
						}
			    html+=`</select>
			    </div>
			    	<div class="form-group">
				    <input type="text" class="form-control" placeholder="Enter name for the form" name="names[]" required>
				    </div>
				    <div class="form-group">
				    <select  class="form-control"  name="mandatories[]">
				    	<option value= 'yes'>Required</option>
				    	<option value='no'>Not Required</option>
				    </select>
				    </div>
				    <button type="button" class="btn btn-danger" onclick="removeThisItem(this)">X</button>
			  	</div>` ;
			  	debugger;
			// $('#card_body form-group').append(html);
			$('#card_body').append(html) ;
		}

		function removeThisItem(val){
			val.parentElement.remove();
		}
	</script>
</body>
</html>
