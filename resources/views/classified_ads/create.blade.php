@extends('layouts.app')

@section('content')
   <section id="ad-create">
    <div class="container bg-white">
    	<h1 class="section-head">{{ Session::has('ad-edit') ? __('ads.lease_details') : __('ads.details') }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-8 my-5">
		    	<div class=" card">
		    		<div class="card-header">
		    			<select class="form-control" id="category-select" onchange="getCategoryForm($(this))">
			    			@foreach ($categories as $category)
			    				<option value="{{$category->category_name}}" {{$category->id==$category_id?'selected':''}}> {{$category->category_name}} </option>
			    			@endforeach
		    			</select>
		    		</div>
		    	</div>
		    	<div class=" card">
		    		<div class="card-header">
		    			Fill the form
		    		</div>
		    		<div class="card-body" id="category_form_here">
				    	
					</div>
		    	</div>
        	</div>
        </div>
    </div>
</section>
  
@push('scripts-vars')

	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="text/javascript">
		function getCategoryForm(item){
			var cat_id= item.val();
			url= "{{route('classified_ads.create', ':cat_id')}}";
			url= url.replace(':cat_id', cat_id);
			$.get(url, function(response){
				$('#category_form_here').html(response);
				  // var input = document.getElementById('pac-input');
				  var input = $('#category_form_here #pac-input')[0];
				  // debugger;
				  new google.maps.places.Autocomplete(input);
			});
		}

		$( document ).ready(function() {
			getCategoryForm($('#category-select'));
		});
	</script>

@endpush
@endsection