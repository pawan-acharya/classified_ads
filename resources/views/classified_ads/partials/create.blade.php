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