@extends('layouts.admin')

@section('content')
	@include('layouts.admin.headers.cards')
	<div class="container">
		<div class="sticky-top" style="text-align: center;">
			<a type="button" class="btn btn-success " href="{{route('categories.create')}}">Add new category</a>
		</div>
	  <div class="row">
	    <div class="col-2">
	    </div>
	    <div class="col-8">
	    	<div class="card card-primary">
              <div class="card-header d-flex justify-content-center">
                <h3 class="card-title">Categories</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
		     	 	@foreach($categories as $category)
						<div class="col-sm-4">
							<a href="{{route('categories.show',['category'=>$category->id])}}">
			                    <div class="position-relative p-3" style="height: 180px; color:black">
			                      <div class="ribbon-wrapper">
			                        <div class="ribbon bg-primary">
			                          {{$category->category_name}}
			                        </div>
			                      </div>
			                       <br>
			                       <div>
			                       		@if ($category->file)
			                       		 	<img src="{{ $category->file->getPathAttribute() }}" width="100%"/>
			                       		@endif
			                       </div>
			                      <small>{{$category->description}}</small>
			                    </div>
		                    </a>
	                  	</div>
					@endforeach

	    </div>
	    <div class="col-2">
	    </div>
	  </div>
	</div>
@endsection