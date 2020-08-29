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


{{-- @foreach ($category->form_items()->where('type', 'select')->where('parent', null)->get() as $form_item)
	<div class="form-group">
	    <label for="exampleInputEmail1">{{$form_item->name}}</label>
        <select class="form-control" name="{{$form_item->id}}-{{$form_item->name}}">
        	@foreach (explode(',', $form_item->options) as $option)
	        	@if ($option)
        			<option value="{{$option}}">{{$option}}</option>
	        	@endif
        	@endforeach
        </select>
	</div>
@endforeach --}}

 <div class="card">
	@foreach ($category->form_items()->where('type', 'select')->where('parent', null)->get() as $form_item)
		<div class="card-header">
   			<label for="exampleInputEmail1">{{$form_item->name}}</label>
   		</div>
   		<div class="card-body">
			<div class="form-group">
		  	@foreach (explode(',', $form_item->options) as $option)
	        	@if ($option)
				 	<input type="radio"  name="{{$form_item->id}}-{{$form_item->name}}" value="{{$option}}">
		  			<label for="">{{$option}}</label><br>
	        	@endif
	    	@endforeach
			</div>
		</div>
	@endforeach
</div>

<div class="card">
 	<div class="card-body">
		@foreach ($category->form_items()->where('type', 'check_box')->where('parent', null)->get() as $form_item)
			<div class="form-group">
			    <label for="exampleInputEmail1">{{$form_item->name}}</label>
		        <input type="checkbox"name="{{$form_item->id}}-{{$form_item->name}}" >
		        </select>
			</div>
		@endforeach
	</div>
</div>