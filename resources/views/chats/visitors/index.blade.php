@php($chat= $classified_ad->chats()->where('user_id', Auth::id())->first())
@if($chat)
@foreach ($chat->replies as $reply)
	{{$reply->reply_by=='visitor'?'YOU':'OWNER'}}:
	{{$reply->message}}<br>
@endforeach
@endif