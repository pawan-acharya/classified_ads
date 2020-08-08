{{$category->category_name}} 
<br>
[
	<br>
	@foreach($category->form_items as $form_item)
	<br>
	[{{$form_item->name}}, {{config('form_items')[$form_item->type]}}, {{($form_item->required== 1)? 'required': 'not-required'}}],
	@endforeach
]
<br>
<a type="button" class="btn btn-danger" href="{{route('categories.edit',['category'=>$category->id])}}">Edit</a>