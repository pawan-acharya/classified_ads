<form action="{{route('feedbacks.reply',['chat_room_id'=> $feedbacks->first()->chat_room->id])}}" method="POST">
	@csrf
	<div class="form-group">
	    <label for="exampleInputEmail1">Chat box</label>
	    <br>
        <input type="text" class="form-control" name="message" required>
        <br>
    	<small class="form-text text-muted">enter your queries </small>
	</div>
	<button type="submit" >Send</button>
</form>