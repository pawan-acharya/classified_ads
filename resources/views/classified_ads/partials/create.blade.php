<form method="POST" action="{{ route('classified_ads.store', ['cat_id'=> $category->id]) }}" id="add_new_classified_ad" class="row" enctype="multipart/form-data">
	@csrf
	<div class="form-group col-sm-6">
	    <label for="exampleInputEmail1" class="col-form-label text-md-right">Title</label>
	    <input type="text" class="form-control  @error('title') is-invalid @enderror"  name="title" required>
  	</div> 
  	<div class="form-group col-sm-6" >
	    <label for="exampleInputEmail1" class="col-form-label text-md-right">#CITQ</label>
	    <input type="text" class="form-control  @error('citq') is-invalid @enderror" name="citq" required>
  	</div>
  	<div class="form-group col-sm-6">
	    <label for="exampleInputEmail1" class="col-form-label text-md-right">Price</label>
	    <input type="number" class="form-control  @error('price') is-invalid @enderror" name="price" required>
  	</div>
  	<div class="form-group col-sm-6">
	    <label for="exampleInputEmail1" class="col-form-label text-md-right">Per</label>
	    <input type="text" class="form-control  @error('price_for') is-invalid @enderror" name="price_for" >
  	</div>
  	<div class="col-sm-12 row" id="image-div">
	  	<div class="form-group col-sm-6">
		    <label for="exampleInputEmail1" class="col-form-label text-md-right">#Images</label>
		    <input type="file" class="" name="title_images[]" >
	  	</div>
	  	<div class="form-group  col-sm-3">
	    	<button type="button" class="btn btn-secondary " onclick="addNewImageDiv()">+</button>
	    	{{-- <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button> --}}
		</div>
	</div>
	<div class="form-group col-sm-6">
     	<label for="pac-input" class="col-form-label text-md-right">Location</label>
	    <input type="text"  id="pac-input" class="form-control  @error('location') is-invalid @enderror" name="location" >
  	</div>
  	<div class="form-group col-sm-6" id="url-div">
  		@if ($category->type != 'none')
	     	<label for="classified_ad-url" class="col-form-label text-md-right">Add a URl</label>
		    <input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" >
	    @else
	    	<label for="classified_ad-url" class="col-form-label text-md-right" onclick="addURL($(this))">Add a URL</label>
  		@endif
  	</div>

  	<div class="form-group col-sm-12">
	    <label for="exampleInputEmail1" class="col-form-label text-md-right  @error('descriptions') is-invalid @enderror">Description</label>
	    <textarea class="form-control"  name="descriptions"></textarea>
  	</div>

  	@include('classified_ads.partials.add')
  	
  	<div class="form-group col-sm-6">
  		<label for="featured-ad" class="col-form-label text-md-right">Make this ad Featured</label>
  		<input type="checkbox" name="featured" id="make-featured" onclick="makeFeatured($(this))">
  	</div>
  	<div class="form-group col-sm-6" id="featured-for">
  		<label for="featured-ad-duration" class="col-form-label text-md-right">choose duration</label>
  		<select  class="form-control" id="featured-ad-duration" name="featured_duration" onchange="addFeaturedAmount($(this))">
  			<option value="day">1 Day</option>
  			<option value="week">1 Week</option>
  			<option value="month">1 Month</option>
  		</select>
  	</div>
  	<div class="form-group col-sm-6">
  		<button type="submit" class="btn btn-primary">Submit</button>
  	</div>
</form>

<script type="text/javascript">
	function addNewImageDiv(){
		var html= `<div class="form-group col-sm-6">
		    <input type="file" class="" name="title_images[]" >
	  	</div>
	  	<div class="form-group col-sm-6">
		    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
	  	</div>`;
	  	var imageDivCount= $('#image-div input').length;
	  	var category_type= "{!! $category->type !!}";
	  	if(category_type == 'none'){
		  	if(imageDivCount== 6){
		  		alert( 'additional 5$' );
		  		calculateTotalAmount(5);
		  	}
	  	}
	  	$('#image-div').append(html);
	}

	function removeThisItem(item){
		var imageDivCount= $('#image-div input').length;
	  	var category_type= "{!! $category->type !!}";
	  	if(category_type == 'none'){
		  	if(imageDivCount== 7){
		  		alert( 'deduce 5$' );
		  		calculateTotalAmount(-5);
		  	}
	  	}
		item.parent().prev().remove();
		item.parent().remove();	
	}

	function addURL(item){
		alert( 'additional 1$' );
		calculateTotalAmount(1);
		var url_input_field= '<input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" > <button type="button" class="btn btn-danger " onclick="removeURLField($(this))">X</button>';
		item.parent('#url-div').append(url_input_field);
	}

	function removeURLField(item){
		alert( 'deduction 1$' );
		calculateTotalAmount(-1);
		item.prev().remove();
		item.remove();
	}
	var previousAmount= 0;
	function addFeaturedAmount(item){
		var category_type= "{!! $category->type !!}";
	  	if(category_type == 'none'){
			if(item.val() == 'day'){
				calculateTotalAmount(5-previousAmount);
				previousAmount= 5; 
			}else if(item.val() == 'week'){
				calculateTotalAmount(8-previousAmount);
				previousAmount= 8;
			}else if(item.val() == 'month'){
				calculateTotalAmount(20-previousAmount);
				previousAmount= 20;
			}
		}
	}

	var totalamount= 0;
	function calculateTotalAmount(number){
		totalamount+= number;
		alert('total amount= '+totalamount+ '$');
	}

	function makeFeatured(item){
		if( item.is(':checked') ){
			$('#featured-for').children().show();
			addFeaturedAmount($('#featured-ad-duration'));
		}else{
			$('#featured-for').children().hide();
			calculateTotalAmount(-previousAmount);
			previousAmount= 0;
		}
	}
	makeFeatured($('#make-featured'));
	function initialize() {
	  var input = document.getElementById('pac-input');
	  new google.maps.places.Autocomplete(input);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>