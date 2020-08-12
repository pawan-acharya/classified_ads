@foreach ($feedbacks as $feedback)
	{{($feedback->user->id== Auth::id())?'YOU':$feedback->user->name}}
	({{($feedback->chat_room->classified_ad->user_id != $feedback->user->id)?'Visitor':'Advitisor'}})
	:-{{$feedback->message}}
	<br>
@endforeach

<br><br>

@include('feedbacks.partials.chatbox')	