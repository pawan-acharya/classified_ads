<form action="{{ route('categories.store') }}" method="POST">
	@csrf
  	<label for="fname">Category name:</label><br>
  	<input type="text" id="fname" name="category_name" placeholder="Enter new category name"><br>
  	<input type="submit" value="Submit">
</form>