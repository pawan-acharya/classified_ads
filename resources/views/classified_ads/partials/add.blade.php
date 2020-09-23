@foreach ($category->form_items()->whereNotIn('type', ['check_box', 'select', 'None', 'secondary_price'])->where('parent', null)->get() as $form_item)
	<div class="form-group col-sm-6">
	    
		@switch($form_item->type)
		    @case('text')
		    	<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$form_item->name}}</label>
	    	    <input type="text" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" aria-describedby="emailHelp" {{($form_item->required )?'required':''}}>
		        @break
	        @case('number')
	        	<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$form_item->name}}</label>
		       	<input type="number" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		        @break
	        @case('date')
	        	<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$form_item->name}}</label>
		        <input type="date" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}"  aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		        @break
		    @case('box')
		           <div class="card">
		           		<div class="card-header">
		           			<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$form_item->name}}</label>
		           		</div>
		           		<div class="card-body">
		           			@foreach ($form_item->children as $child)
		           				<img src="{{asset('storage')}}/{{$child->logo}}" style="height: 15px;">
			           			@switch($child->type)
				           			@case('text')
								    	<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$child->name}}</label>
							    	    <input type="text" class="form-control" name="{{$child->id}}-{{$child->name}}" aria-describedby="emailHelp" {{($child->required )?'required':''}}>
								        @break
							        @case('number')
							        	<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$child->name}}</label>
								       	<input type="number" class="form-control" name="{{$child->id}}-{{$child->name}}" aria-describedby="emailHelp"  {{($child->required )?'required':''}}>
								        @break
							        @case('date')
							        	<label for="exampleInputEmail1" class="col-form-label text-md-right">{{$child->name}}</label>
								        <input type="date" class="form-control" name="{{$child->id}}-{{$child->name}}"  aria-describedby="emailHelp"  {{($child->required )?'required':''}}>
								        @break
								    @default
							    @endswitch
						    @endforeach
		           		</div>
		           </div>
	           @default
		@endswitch
	</div>
@endforeach

@if ($category->form_items()->where('type', 'secondary_price')->where('parent', null)->first())
 	<div class="card col-sm-12" >
 		<div class="card-header">
   			<label for="exampleInputEmail1" >Prices</label>
   		</div>
   		<div class="card-body row">
			@foreach ($category->form_items()->where('type', 'secondary_price')->where('parent', null)->get() as $form_item)
				<div class="form-group col-sm-6">
			  	@foreach ($form_item->children as $child)
		        	@if ($child)
					 	<input type="number"  class="form-control"  name="{{$form_item->id}}-{{$form_item->name}}" >
			  			<label for="" class="col-form-label text-md-right">Per {{$child->name}}</label><br>
		        	@endif
		    	@endforeach
				</div>
			@endforeach
		</div>
	</div>
@endif

@if ($category->form_items()->where('type', 'select')->where('parent', null)->first())
	@foreach ($category->form_items()->where('type', 'select')->where('parent', null)->get() as $form_item)
	        <div class="col-md-12">
	            <h5>{{$form_item->name}} </h5>
	            <div class="row">
	                @foreach ($form_item->children as $child)
	                    <div class="col-md-6">
	                        <div class="custom-control custom-checkbox">
	                            <input type="radio" class="custom-control-input" id="option_{{$child->name}}" value="{{$child->id}}"  name="{{$form_item->id}}-{{$form_item->name}}" >
	                            <label class="custom-control-label" for="option_{{$child->name}}">{{$child->name}}</label>
	                        </div>
	                    </div>
	                @endforeach
	            </div>
	        </div>
	        <br> </br>
	@endforeach
@endif

						

@if ($category->form_items()->where('type', 'check_box')->where('parent', null)->first())
	@foreach ($category->form_items()->where('type', 'check_box')->where('parent', null)->get() as $form_item)
	        <div class="col-md-12">
	            <h5>{{$form_item->name}} </h5>
	            <div class="row">
	                @foreach ($form_item->children as $child)
	                    <div class="col-md-6">
	                        <div class="custom-control custom-checkbox">
	                            <input type="checkbox" class="custom-control-input" id="option_{{$child->name}}" value="{{$child->id}}"  name="{{$child->id}}-{{$child->name}}">
	                            <label class="custom-control-label" for="option_{{$child->name}}">{{$child->name}}</label>
	                        </div>
	                    </div>
	                @endforeach
	            </div>
	        </div>
	        <br> </br>
	@endforeach
@endif

@if ($category->form_items()->where('type', 'activity')->where('parent', null)->first())
	@foreach ($category->form_items()->where('type', 'activity')->where('parent', null)->get() as $form_item)
	        <div class="col-md-12">
	            <h5>{{$form_item->name}} </h5>
	            <div class="row">
	                @foreach ($form_item->children as $child)
	                    <div class="col-md-6">
	                    	<img src="{{asset('storage')}}/{{$child->logo}}" style="height: 15px;">
	                        <div class="custom-control custom-checkbox">
	                            <input type="checkbox" class="custom-control-input" id="option_{{$child->name}}" value="{{$child->id}}"  name="{{$child->id}}-{{$child->name}}">
	                            <label class="custom-control-label" for="option_{{$child->name}}">{{$child->name}}</label>
	                        </div>
	                    </div>
	                @endforeach
	            </div>
	        </div>
	        <br> </br>
	@endforeach
@endif