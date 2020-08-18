<form action="{{route('feedbacks.create',['classified_ad'=> $classified_ad->id])}}" method="POST">
	@csrf
	<div class="form-group">
	    <label for="exampleInputEmail1">Chat box</label>
	    <br>
        <input type="text" class="form-control" name="message" required>
        <br>
    	<small class="form-text text-muted">enter your queries </small>
	</div>
	<button class="btn btn-success" type="submit" >Send</button>
</form>