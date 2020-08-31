@foreach ($category->form_items()->whereNotIn('type', ['check_box', 'select', 'None'])->where('parent', null)->get() as $form_item)
	<div class="form-group col-sm-6">
	    
		@switch($form_item->type)
		    @case('text')
		    	<label for="exampleInputEmail1">{{$form_item->name}}</label>
	    	    <input type="text" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" aria-describedby="emailHelp" {{($form_item->required )?'required':''}}>
		        @break
	        @case('number')
	        	<label for="exampleInputEmail1">{{$form_item->name}}</label>
		       	<input type="number" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		        @break
	        @case('date')
	        	<label for="exampleInputEmail1">{{$form_item->name}}</label>
		        <input type="date" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}"  aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		        @break
		    @case('box')
		           <div class="card">
		           		<div class="card-header">
		           			<label for="exampleInputEmail1">{{$form_item->name}}</label>
		           		</div>
		           		<div class="card-body">
		           			@foreach ($form_item->children as $child)
		           				<img src="{{asset('storage')}}/{{$child->logo}}" style="height: 15px;">
			           			@switch($child->type)
				           			@case('text')
								    	<label for="exampleInputEmail1">{{$child->name}}</label>
							    	    <input type="text" class="form-control" name="{{$child->id}}-{{$child->name}}" aria-describedby="emailHelp" {{($child->required )?'required':''}}>
								        @break
							        @case('number')
							        	<label for="exampleInputEmail1">{{$child->name}}</label>
								       	<input type="number" class="form-control" name="{{$child->id}}-{{$child->name}}" aria-describedby="emailHelp"  {{($child->required )?'required':''}}>
								        @break
							        @case('date')
							        	<label for="exampleInputEmail1">{{$child->name}}</label>
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

@if ($category->form_items()->where('type', 'select')->where('parent', null)->first())
 	<div class="card col-sm-6" >
		@foreach ($category->form_items()->where('type', 'select')->where('parent', null)->get() as $form_item)
			<div class="card-header">
	   			<label for="exampleInputEmail1">{{$form_item->name}}</label>
	   		</div>
	   		<div class="card-body">
				<div class="form-group">
			  	@foreach ($form_item->children as $child)
		        	@if ($child)
					 	<input type="radio"  name="{{$form_item->id}}-{{$form_item->name}}" value="{{$child->id}}">
			  			<label for="">{{$child->name}}</label><br>
		        	@endif
		    	@endforeach
				</div>
			</div>
		@endforeach
	</div>
@endif

@if ($category->form_items()->where('type', 'check_box')->where('parent', null)->first())
	<div class="card col-sm-6" >
		@foreach ($category->form_items()->where('type', 'check_box')->where('parent', null)->get() as $form_item)
			<div class="card-header">
	   			<label for="exampleInputEmail1">{{$form_item->name}}</label>
	   		</div>
	   		<div class="card-body">
				<div class="form-group">
			  	@foreach ($form_item->children as $child)
		        	@if ($child)
		  			 	<label for="exampleInputEmail1">{{$child->name}}</label>
			        	<input type="checkbox"name="{{$child->id}}-{{$child->name}}" >
		        	@endif
		    	@endforeach
				</div>
			</div>
		@endforeach
	</div>
@endif