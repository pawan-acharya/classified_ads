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
	<div class="form-group col-sm-12">
     	<label for="pac-location" class="col-form-label text-md-right">Location</label>
	    <input type="text"  id="pac-input" class="form-control  @error('location') is-invalid @enderror" name="location" >
  	</div>

  	<div class="form-group col-sm-12">
	    <label for="exampleInputEmail1" class="col-form-label text-md-right  @error('descriptions') is-invalid @enderror">Description</label>
	    <textarea class="form-control"  name="descriptions"></textarea>
  	</div>

  	@include('classified_ads.partials.add')
  	
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
	  	$('#image-div').append(html);
	}

	function removeThisItem(item){
		item.parent().prev().remove();
		item.parent().remove();	
	}

	function initialize() {
	  var input = document.getElementById('pac-input');
	  new google.maps.places.Autocomplete(input);
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>