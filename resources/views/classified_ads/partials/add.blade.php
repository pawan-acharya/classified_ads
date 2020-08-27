@foreach ($category->form_items()->where('parent', null)->get() as $form_item)
	<div class="form-group">
	    
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