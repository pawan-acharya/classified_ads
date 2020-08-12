@foreach ($chat_rooms as $chat_room)
	{{($chat_room->advertiser == Auth::id())?$chat_room->visitor_user->name:$chat_room->advertiser_user->name}}
	<a href="{{route('feedbacks.show', ['chat_room_id'=> $chat_room->id])}}">Reply to the chat</a>
	<br>
@endforeach