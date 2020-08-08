<form action="{{ route('categories.update', ['category'=> $category->id]) }}" method="POST">
	@csrf
	@method('PUT')
  	<label for="fname">Category name:</label><br>
  	<input type="text" id="fname" name="category_name" value="{{$category->category_name}}"><br>
  	<input type="submit" value="Submit">
</form>