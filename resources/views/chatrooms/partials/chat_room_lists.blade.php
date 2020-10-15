
@foreach ($chat_rooms as $chat_room)
	<a href="{{route('feedbacks.show', ['chat_room_id'=> $chat_room->id])}}">
		<div class="user-card" data-id="{{$chat_room->id}}">
			<div class="user-avatar">
				{{-- <img src="{{ Auth::user()->file->getPathAttribute() }}" width="100%" class="displayimage"/> --}}
				<img src="{{($chat_room->advertiser == Auth::id())?$chat_room->visitor_user->file->getPathAttribute():$chat_room->advertiser_user->file->getPathAttribute()}}" width="100%" class="displayimage"/>
			</div>
			<div class="user-content"
				@if ($chat_room->feedbacks()->latest()->first()->read)
					style="color: black;"
				@endif
			>
				<p class="user-name">
					{{($chat_room->advertiser == Auth::id())?$chat_room->visitor_user->name:$chat_room->advertiser_user->name}}
				</p>
				<p>{{$chat_room->feedbacks()->latest()->first()->message}}</p>
				{{-- <span class="message-time">{{$chat_room->feedbacks()->latest()->first()->created_at}}<span> --}}
			</div>
		</div>
	</a>
@endforeach