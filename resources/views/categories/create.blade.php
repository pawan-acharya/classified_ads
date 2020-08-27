
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
		    	<a type="button" class="btn btn-warning d-flex justify-content-center" href="{{route('categories.index')}}">Go Back</a>
		    </div>
		    <div class="col-8">
		    	<form class=""   id="category-form"  >
		    	<div class="card card-primary">
	              <!-- /.card-header -->
	              	<div class="card-body">
	              		<div class="form-group">
						    <label for="exampleInputEmail1">Category name:</label>
						    <input type="text" class="form-control" id="fname" name="category_name" required="">
					  	</div>
	    			</div>
			  	</div>

			  	<div class="card card-primary">
			  		<div class="card-header d-flex justify-content-center">
	                	<h5 class="card-title">Form Items</h5>
	              	</div>
	              <!-- /.card-header -->
	              	<div class="card-body" id="card_body">
				  			<div class="form-group row divRow">
				  				<div class="form-group col-sm-3">
				  					<label for="exampleInputEmail1">Field Name</label>
								    <select  class="form-control types" name="types[]">
								    	@foreach(config('form_items') as $key=>$value)
									    	<option value='{{$key}}'
								    		>{{$value}}</option>
								    	@endforeach
								    </select>
							    </div>
							    <div class="form-group  col-sm-3">
							    	<label for="exampleInputEmail1">Field Type</label>
							    	<input type="text" class="form-control" placeholder="Enter name for the form" name="names[]" required="">
							    </div>
							    <div class="form-group  col-sm-3">
							    	<label for="exampleInputEmail1">Required/Not</label>
								    <select  class="form-control"  name="mandatories[]">
								    	<option value= 'yes'
								    	>Required</option>
								    	<option value='no'
								    	>NOt Required</option>
								    </select>
							    </div>
							    <div class="form-group  col-sm-3">
							    	<button type="button" class="btn btn-warning " onclick="addBoxes($(this))">OK</button>
								</div>
						  	</div>
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
		var html=`<div class="form-group row divRow">
				
				<input type="hidden" name="ids[]" value="0">
				<div class="form-group   col-sm-3">
			    <select  class="form-control types"  name="types[]">`;
			    	for (var key in js_array) {
					  html+=`<option value= `+key+`>`+js_array[key]+`</option>`;
					}
		    html+=`</select>
		    </div>
		    	<div class="form-group   col-sm-3">
			    <input type="text" class="form-control " placeholder="Enter name for the form" name="names[]" required>
			    </div>
			    <div class="form-group   col-sm-3">
			    <select  class="form-control"  name="mandatories[]">
			    	<option value= 'yes'>Required</option>
			    	<option value='no'>Not Required</option>
			    </select>
			    </div>
			    <div class="form-group  col-sm-3">
			    <button type="button" class="btn btn-warning " onclick="addBoxes($(this))">OK</button>
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
			    </div>
		  	</div>` ;


	  	var html_child=`<div class="form-group row divRow">
				
				<input type="hidden" name="ids[]" value="0">
				<div class="form-group   col-sm-3">
			    <select  class="form-control types"  name="types[]">`;
			    	for (var key in js_array) {
			    		if(key=='box'){continue;}
					  html_child+=`<option value= `+key+`>`+js_array[key]+`</option>`;
					}
		    html_child+=`</select>
		    </div>
		    	<div class="form-group   col-sm-3">
			    <input type="text" class="form-control " placeholder="Enter name for the form" name="names[]" required>
			    </div>
			    <div class="form-group   col-sm-3">
			    <select  class="form-control"  name="mandatories[]">
			    	<option value= 'yes'>Required</option>
			    	<option value='no'>Not Required</option>
			    </select>
			    </div>
			    <div class="form-group  col-sm-3">
			    <button type="button" class="btn btn-success " onclick="addNewColumnChild($(this))">+</button>
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
			    </div>
		  	</div>` ;


		function addNewColumn(){
			$('#card_body').append(html) ;
		}
		function addNewColumnChild(item){
			item.closest('.divRow').parent().append(html_child) ;
			item.remove();
		}

		function addBoxes(item){
			if(item.closest('.divRow').find('.types').first().val() =='box'){
				item.closest('.divRow').append(html_child) ;
			}
		}

		function removeThisItem(item){
			item.closest('.divRow').remove();
		}

	</script>

	<script type="text/javascript">
		$( "form#category-form" ).submit(function(event) {
			event.preventDefault();
			var url= "{{ route('categories.store') }}";
			var category_name= $(this).find("input[name='category_name']").val();
			var big_array= new Array();
			$.each( $(this).find('.card-body>.divRow'), function( key, value ) {
				var small_array= {
					'type': $(value).find("select[name='types[]']").first().val(),
					'name': $(value).find("input[name='names[]']").first().val(),
					'mandatory': $(value).find("select[name='mandatories[]']").first().val(),
				};
			
			 	var tiny_array =new Array();
			  	$.each( $(value).find('.divRow'), function( key, value ) {
			  		tiny_array.push({
						'type': $(value).find("select[name='types[]']").first().val(),
						'name': $(value).find("input[name='names[]']").first().val(),
						'mandatory': $(value).find("select[name='mandatories[]']").first().val(),
					});
			    });
			    small_array['box_array']= tiny_array;
			    big_array.push(small_array);
			});
			var data= new Array();
			data= {
				"_token": "{{ csrf_token() }}",
				'category_name': category_name,
				'big_array': big_array,
			};
		  	
		  	$.ajax({
			  	type: "POST",
			  	url: url,
			  	data: data,
			  	dataType: "json",
			})
			.done(function( data ) {
			    window.location = "{{ route('categories.index')}}";
		  	})
		  	.fail(function() {
		    	alert( "error" );
		  	});
		});
	</script>
</body>
</html>
