@foreach ($classified_ad->category->form_items as $form_item)
	<div class="form-group">
	    <label for="exampleInputEmail1">{{$form_item->name}}</label>
		@switch($form_item->type)
		    @case('text')
		        <input type="text" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" value="{{json_decode($classified_ad->form_values, true)[$form_item->id]}}" aria-describedby="emailHelp" {{($form_item->required )?'required':''}}>
		    	<small id="emailHelp" class="form-text text-muted">&Lorem ipsum dolor sit amet</small>
		        @break
	        @case('number')
		       	<input type="number" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" value="{{json_decode($classified_ad->form_values, true)[$form_item->id]}}" aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		    	<small id="emailHelp" class="form-text text-muted">&Lorem ipsum dolor sit amet</small>
		        @break
	        @case('date')
		        <input type="date" class="form-control" name="{{$form_item->id}}-{{$form_item->name}}" value="{{json_decode($classified_ad->form_values, true)[$form_item->id]}}" aria-describedby="emailHelp"  {{($form_item->required )?'required':''}}>
		    	<small id="emailHelp" class="form-text text-muted">&Lorem ipsum dolor sit amet</small>
		        @break
		    @default
		            Default case...
		@endswitch
	</div>
@endforeach