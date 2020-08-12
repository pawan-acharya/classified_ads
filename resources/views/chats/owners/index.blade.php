<a href="{{route('classified_ads.show', ['classified_ad'=> $chats->first()->classified_ad->id])}}">Back to Ad</a>
<br>
-------------------------------------------------------
<br>
@foreach ($chats as $chat)
	{{$chat->user->name}}-
	<a href="{{route('replies.index', ['chat_id'=> $chat->id])}}">Reply to Feedback</a> 
	<br>
@endforeach