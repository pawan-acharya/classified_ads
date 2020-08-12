<a href="{{route('chats.index',['classified_ad_id'=> $replies->first()->chat->classified_ad->id])}}">Back to chat lists</a>
<br>
---------------------------------------------------------------------------------------------------------
<br>
@foreach ($replies as $reply)
		{{$reply->reply_by=='advertiser'?'YOU': $reply->chat->user->name}}:
		{{$reply->message}}<br>
@endforeach

<form action="{{route('chats.owner_reply',['chat_id'=> $replies->first()->chat->id])}}" method="POST">
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