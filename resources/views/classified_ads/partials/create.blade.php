<form method="POST" action="{{ route('classified_ads.store', ['cat_id'=> $category->id]) }}" id="add_new_classified_ad" class="row" enctype="multipart/form-data">
	@csrf
	@if ($category->sub_category)
	  	<div class="form-group col-sm-6" >
		    <label for="" class="col-form-label text-md-right">#Sub-Category</label>
		    <select class="form-control @error('sub_category') is-invalid @enderror" name="sub_category">
		    	<option></option>
		    	@foreach (config('sub_category')[$category->sub_category] as $element)
		    		<option value="{{$element}}">{{$element}}</option>
		    	@endforeach
		    </select>
		    {{-- <input type="text" class="form-control  @error('sub_category') is-invalid @enderror" name="sub_category" required> --}}
	  	</div>
	@endif
	<div class="form-group col-sm-6">
	    <label for="" class="col-form-label text-md-right">Title</label>
	    <input type="text" class="form-control  @error('title') is-invalid @enderror"  name="title" onblur="checkTitle($(this))" required>
  	</div> 
  	<div class="form-group col-sm-6" >
	    <label for="" class="col-form-label text-md-right">#CITQ</label>
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
	  	<div class="form-group  col-sm-6">
	    	<button type="button" class="btn btn-secondary btn-sm" onclick="addNewImageDiv()">+</button>
			{{-- <button type="button" class="btn btn-danger btn-sm" onclick="removeThisItem($(this))">X</button> --}}
			@if ($category->type == 'none')
				<span class="note">Extra $5 will be charged to add more than 5 images</span>
			@endif
		</div>
	</div>
	<div class="form-group col-sm-6">
     	<label for="pac-input" class="col-form-label text-md-right">Location</label>
	    <input type="text"  id="pac-input" class="form-control  @error('location') is-invalid @enderror" name="location" >
  	</div>
  	<div class="form-group col-sm-6" id="url-div">
  		@if ($category->type != 'none' || Auth::user()->checkIfAdmin())
	     	<label for="classified_ad-url" class="col-form-label text-md-right">URL</label>
		    <input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" placeholder="URL">
	    @else
			<label for="classified_ad-url" class="col-form-label text-md-right">URL</label>
			<span class="note">Extra $1 will be charged to add a URL</span>
			<button type="button" class="btn btn-secondary btn-sm mb-1" onclick="addURL($(this))">+</button>
  		@endif
  	</div>

  	<div class="form-group col-sm-12">
	    <label for="exampleInputEmail1" class="col-form-label text-md-right  @error('descriptions') is-invalid @enderror">Description</label>
	    <textarea class="form-control"  name="descriptions"></textarea>
  	</div>

  	@include('classified_ads.partials.add',['parent' => 'create'])
	
	<div class="form-group col-sm-6" 
	@if ($category->type != 'none')
		style="display: none"
	@endif
	>
  		<label for="featured-ad" class="col-form-label text-md-right">Make this ad Featured</label>
  		<input type="checkbox"  id="make-featured" onclick="makeFeatured($(this))" name="is_featured" {{$category->type != 'none'?'checked':''}}>
	</div>
	<div class="form-group col-sm-6" id="featured-for" 
	@if ($category->type != 'none')
		style="display: none"
	@endif
	>
		<label for="featured-ad-duration" class="col-form-label text-md-right">choose duration</label>
		<select  class="form-control" id="featured-ad-duration" name="feature_type" onchange="addFeaturedAmount($(this))">
			<option value="day">1 Day</option>
			<option value="week">1 Week</option>
			<option value="month" {{$category->type != 'none'?'selected':''}}>1 Month</option>
		</select>
	</div>

  	<div class="form-group col-sm-6">
	  @if (Auth::user()->checkIfAdmin() || Auth::user()->ifLeftAds($category->type))
	  	<button type="submit" class="btn btn-main w-100">Create the Ad</button>
	@else
		<div class="single-ad-premium">
			<div>
				@if ($category->type != 'none')
					<ul>
						<li class="mb-0"><i class="far fa-image"></i>{{ __('payments.payment_plans.sales.pictures') }}</li>
						<li class="mb-0"><i class="fas fa-external-link-alt"></i>{{ __('payments.payment_plans.sales.url') }}</li>
						<li><i class="fas fa-star"></i>{{ __('payments.payment_plans.sales.featured') }}</li>
					</ul>
				@endif
			</div>
			<div class="price-box">
				<p class="plan-price" id="ad-total-amount">{{$category->type != 'none'?20:''}}</p>
			</div>
			<div class="valid-month">
				<span>{{ __('payments.valid_month') }}</span>
			</div>
			<button type="submit" class="btn btn-main w-100">{{ __('payments.payment_link') }}</button>
		</div>
	@endif
</form>

<script type="text/javascript">
	var is_admin= {!! Auth::user()->checkIfAdmin()?1:0!!} ;
	var has_plan = {!! Auth::user()->ifLeftAds($category->type)?1:0!!};
	function addNewImageDiv(){
		var html= `<div class="form-group col-sm-6">
		    <input type="file" class="" name="title_images[]" >
	  	</div>
	  	<div class="form-group col-sm-6">
		    <button type="button" class="btn btn-danger btn-sm" onclick="removeThisItem($(this))">X</button>
	  	</div>`;
	  	var imageDivCount= $('#image-div input').length;
	  	var category_type= "{!! $category->type !!}";
	  	if(category_type == 'none' && !is_admin && !has_plan){
		  	if(imageDivCount== 6){
		  		calculateTotalAmount(5);
				$('#selected-features').append('<li class="mb-0">More than 6 Images</li>');
			}
	  	}
	  	$('#image-div').append(html);
	}

	function removeThisItem(item){
		var imageDivCount= $('#image-div input').length;
	  	var category_type= "{!! $category->type !!}";
	  	if(category_type == 'none' && !is_admin && !has_plan){
		  	if(imageDivCount== 7){
		  		calculateTotalAmount(-5);
		  	}
	  	}
		item.parent().prev().remove();
		item.parent().remove();	
	}

	function addURL(item){
		calculateTotalAmount(1);
		$('#selected-features').append('<li class="mb-0">Added a URL</li>')
		var url_input_field= '<input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" placeholder="URL"> <button type="button" class="btn btn-danger btn-sm" onclick="removeURLField($(this))">X</button>';
		item.parent('#url-div').append(url_input_field);
	}

	function removeURLField(item){
		calculateTotalAmount(-1);
		item.prev().remove();
		item.remove();
	}
	var previousAmount= 0;
	function addFeaturedAmount(item){
		var category_type= "{!! $category->type !!}";
	  	if(category_type == 'none' && !is_admin && !has_plan){
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

	var category_type= "{!! $category->type !!}";
  	if(category_type != 'none' && !is_admin && !has_plan){
  		var totalamount= 20;
  	}else{
		var totalamount= 0;
  	}
	function calculateTotalAmount(number){
		totalamount+= number;
		$('#ad-total-amount').html('Total Amount: '+totalamount+ '$')
		
	}

	function makeFeatured(item){
		if( item.is(':checked') ){
			$('#featured-for').children().show();
			addFeaturedAmount($('#featured-ad-duration'));
			$('#selected-features').append('<li class="mb-0">Featured Ad</li>')
		}else{
			$('#featured-for').children().hide();
			calculateTotalAmount(-previousAmount);
			previousAmount= 0;
		}
	}
	
	function checkTitle(item){
		var url= "{{route('classified_ads.checkTitle', ':title')}}";
		url= url.replace(':title', item.val());
		$.get( url, function( data ) {
	  		if(data){
	  			$('#add_new_classified_ad button:submit').prop('disabled', true);
	  			$('input[name ="title"]').css('border', '1px solid red');
	  		}else{
	  			$('#add_new_classified_ad button:submit').prop('disabled', false);
	  			$('input[name ="title"]').css('border', 'none');
	  		}
		});
	}
	makeFeatured($('#make-featured'));
</script>