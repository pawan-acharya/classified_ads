@foreach ($category->form_items as $form_item)
	<div class="form-group">
	    <label for="exampleInputEmail1">{{$form_item->name}}</label>
		@switch($form_item->type)
		    @case('text')
		        <input type="text" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" aria-describedby="emailHelp" {{($form_item->required )?'required':''}}>
		        @break
	        @case('number')
		       	<input type="number" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		        @break
	        @case('date')
		        <input type="date" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}"  aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		        @break
		    @default
		            Default case...
		@endswitch
	</div>
@endforeach