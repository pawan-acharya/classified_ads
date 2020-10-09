@extends('layouts.admin')
@push('scripts-vars')
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<style type="text/css">
		select { font-family: 'FontAwesome', Verdana }
	</style>
@endpush
@section('content')
    @include('layouts.admin.headers.cards')
	<div class="container">
		
		
	  	<div class="row">
		    <div class="col-2">
		    	<a type="button" class="btn btn-warning d-flex justify-content-center" href="{{route('categories.index')}}">Go Back</a>
		    </div>
		    <div class="col-8">
		    	<form class=""   id="category-form"  enctype="multipart/form-data">
		    	<div class="card card-primary">
	              <!-- /.card-header -->
	              	<div class="card-body row">
	              		<div class="form-group col-6">
						    <label for="exampleInputEmail1">Category name:</label>
						    <input type="text" class="form-control" id="fname" name="category_name" required="">
					  	</div>
					  	<div class="form-group col-6">
						    <label for="exampleInputEmail1">Category Poster Image:</label>
						    <input type="file" class="form-control" id="fname" name="image" required>
					  	</div>
					  	<div class="form-group col-6">
						    <label for="cat-type">Category Description:</label>
						    <select class="form-control" id="cat-type" name="type" >
						    	<option value="none"></option>
						    	<option value="rental">Rentals package</option>
						    	<option value="sales">Sales package</option>
						    </select> 
					  	</div>
					  	<div class="form-group col-6">
						    <label for="cat-sub-category">Will contain sub-category?</label>
						    <select class="form-control" id="cat-sub-category" name="sub_category" >
						    	<option value="none"></option>
						    	<option value="services">Services</option>
						    	<option value="packages">Packages & activities</option>
						    </select> 
					  	</div>
					  	<div class="form-group col-12">
						    <label for="exampleInputEmail1">Category Description:</label>
						    <textarea class="form-control" id="fname" name="description" ></textarea> 
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
							    	<input type="text" class="form-control" placeholder="Enter name for the form" name="names[]" required="" >
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
							    	<button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
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
@endsection

@push('js')	
	<script type="text/javascript">
	 	var js_array= {!! json_encode(config('form_items')) !!} ;
	 	var js_logos= {!!  json_encode(config('logos')) !!} ; ;

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


	  	var html_box=`<div class="form-group row divRow">
				<input type="hidden" name="ids[]" value="0">
				<div class="form-group   col-sm-2">
			    <select  class="form-control types"  name="types[]">`;
			    	for (var key in js_array) {
			    		if(key=='text'|| key=='number'){
					  		html_box+=`<option value= `+key+`>`+js_array[key]+`</option>`;
					  	}
					}
		    html_box+=`</select>
		    </div>
		    	<div class="form-group   col-sm-3">
			    <input type="text" class="form-control " placeholder="Enter name for the form" name="names[]" required>
			    </div>
			    <div class="form-group   col-sm-3">
			    	<select  class="form-control types"  name="logos[]">`;
			    	for (var key in js_logos) {
					  html_box+=`<option value= `+js_logos[key]+`> `+js_logos[key]+`</option>`;
					}
			    html_box+=`</select>
			    </div>
			    <div class="form-group   col-sm-2">
			    <select  class="form-control"  name="mandatories[]">
			    	<option value= 'yes'>Required</option>
			    	<option value='no'>Not Required</option>
			    </select>
			    </div>
			    <div class="form-group  col-sm-2">
			    <button type="button" class="btn btn-success " onclick="addNewBoxBody($(this))">+</button>
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
			    </div>
	  	</div>` ;


	  	var html_select= `<div class="form-group row divRow">
				<input type="hidden" name="ids[]" value="0">
				<div class="form-group   col-sm-3">
		    	</div>
		    	<div class="form-group   col-sm-3">
			    <input type="text" class="form-control " placeholder="Enter name for the form" name="child_names[]" required>
			    </div>
			    <div class="form-group   col-sm-3">
			    	<select  class="form-control types"  name="logos[]">
			    	<option></option>`;
			    	for (var key in js_logos) {
					  html_select+=`<option value= `+key+`> &#x`+js_logos[key]+`; </option>`;
					}
			    	html_select+=`</select>
			    </div>
			    <div class="form-group  col-sm-3">
			    <button type="button" class="btn btn-success " onclick="addNewSelectBody($(this))">+</button>
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
			    </div>
	  	</div>` ;

	  	var html_secondary_price= `<div class="form-group row divRow">
				<input type="hidden" name="ids[]" value="0">
				<div class="form-group   col-sm-3">
					 <input type="text" class="form-control " value="Per" readonly>
		    	</div>
		    	<div class="form-group   col-sm-3">
			    <input type="text" class="form-control " placeholder="Enter name for the form" name="child_names[]" required>
			    </div>
			    <div class="form-group   col-sm-3">
			    </div>
			    <div class="form-group  col-sm-3">
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
			    </div>
	  	</div>` ;

	  	var html_activity= `<div class="form-group row divRow">
			<input type="hidden" name="ids[]" value="0">
			<div class="form-group   col-sm-2">
		    </div>
		    	<div class="form-group   col-sm-3">
			    <input type="text" class="form-control " placeholder="Enter name for the form" name="child_names[]" required>
			    </div>
			    <div class="form-group   col-sm-3">
			    	<select  class="form-control types"  name="logos[]">`;
			    	for (var key in js_logos) {
					  html_activity+=`<option value= `+js_logos[key]+`> `+js_logos[key]+`</option>`;
					}
			    html_activity+=`</select>
			    </div>
			    <div class="form-group   col-sm-2">
			   
			    </div>
			    <div class="form-group  col-sm-2">
			    <button type="button" class="btn btn-success " onclick="addNewActivityBody($(this))">+</button>
			    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
			    </div>
	  	</div>` ;




		function addNewColumn(){
			$('#card_body').append(html) ;
		}
		function addNewBoxBody(item){
			item.closest('.divRow').parent().append(html_box) ;
			item.remove();
		}
		function addNewSelectBody(item){
			item.closest('.divRow').parent().append(html_select) ;
			item.remove();
		}
		function addNewActivityBody(item){
			item.closest('.divRow').parent().append(html_activity) ;
			item.remove();
		}

		function addBoxes(item){
			if(item.closest('.divRow').find('.types').first().val() =='box'){
				item.closest('.divRow').append(html_box) ;
			}
			else if(item.closest('.divRow').find('.types').first().val() =='select'){
				item.closest('.divRow').append(html_select) ;
			}
			else if(item.closest('.divRow').find('.types').first().val() =='check_box'){
				item.closest('.divRow').append(html_select) ;
			}
			else if(item.closest('.divRow').find('.types').first().val() =='primary_price'){
				item.closest('.divRow').append(html_primary_price) ;
			}
			else if(item.closest('.divRow').find('.types').first().val() =='secondary_price'){
				item.closest('.divRow').append(html_secondary_price) ;
			}else if(item.closest('.divRow').find('.types').first().val() =='activity'){
				item.closest('.divRow').append(html_activity) ;
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
			var type= $(this).find("select[name='type']").val();
			var sub_category= $(this).find("select[name='sub_category']").val();
			var description= $(this).find("textarea[name='description']").val();
			var image= $(this).find("input[name='image']").val();
			var big_array= new Array();
			$.each( $(this).find('.card-body>.divRow'), function( key, value ) {
				var small_array= {
					'type': $(value).find("select[name='types[]']").first().val(),
					'name': $(value).find("input[name='names[]']").first().val(),
					'mandatory': $(value).find("select[name='mandatories[]']").first().val(),
				};
				if($(value).find("select[name='types[]']").first().val()== 'box'){
					var tiny_array =new Array();
				  	$.each( $(value).find('.divRow'), function( key, value ) {
				  		tiny_array.push({
							'type': $(value).find("select[name='types[]']").first().val(),
							'name': $(value).find("input[name='names[]']").first().val(),
							'mandatory': $(value).find("select[name='mandatories[]']").first().val(),
							'logo': $(value).find("select[name='logos[]']").first().val(),
						});
				    });
			     	small_array['box_array']= tiny_array;
				}else if($(value).find("select[name='types[]']").first().val()== 'select' || $(value).find("select[name='types[]']").first().val()== 'check_box'){
					var tiny_array =new Array();
			 		$.each( $(value).find('.divRow'), function( key, value ) {
			 			tiny_array.push({
							'type': 'None',
							'name': $(value).find("input[name='child_names[]']").first().val(),
							'logo': $(value).find("select[name='logos[]']").first().val(),
							'mandatory': 'yes',
						});
				 	});
				 	small_array['box_array']= tiny_array;
				}else if($(value).find("select[name='types[]']").first().val()== 'secondary_price'){
					var tiny_array =new Array();
			 		$.each( $(value).find('.divRow'), function( key, value ) {
			 			tiny_array.push({
							'type': 'None',
							'name': $(value).find("input[name='child_names[]']").first().val(),
							'mandatory': 'yes',
						});
				 	});
				 	small_array['box_array']= tiny_array;
				}
				else if($(value).find("select[name='types[]']").first().val()== 'activity'){
					var tiny_array =new Array();
			 		$.each( $(value).find('.divRow'), function( key, value ) {
			 			tiny_array.push({
			 				'type': 'None',
							'name': $(value).find("input[name='child_names[]']").first().val(),
							'logo': $(value).find("select[name='logos[]']").first().val(),
						});
				 	});
				 	small_array['box_array']= tiny_array;
				}
		    	big_array.push(small_array);
			   
			});

			var formData = new FormData();
		  	formData.append('_token', "{{ csrf_token() }}");
		  	formData.append('category_name', category_name);
		  	formData.append('type', type);
		  	formData.append('sub_category', sub_category);
		  	formData.append('description', description);
			formData.append('image', $(this).find("input[name='image']")[0].files[0]);
		  	formData.append('big_array', JSON.stringify(big_array));
		  	
		  	$.ajax({
			  	type: "POST",
			  	url: url,
			  	data: formData,
			  	processData: false,  // tell jQuery not to process the data
       			contentType: false,  // tell jQuery not to set contentType
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
@endpush

