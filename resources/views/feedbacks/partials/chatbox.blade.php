
<div>
	<form action="javascript:void(0)" method="POST"  id="feed_back_form" data-url="{{route('feedbacks.reply',['chat_room_id'=> $feedbacks->first()->chat_room->id])}}">
		@csrf
		<input type="hidden" id="last_feedback_id" name="last_feedback_id" value="">
		<div class="form-group">
	        <textarea class="form-control" name="message" required></textarea>
		</div>
		<button type="submit" class="send-button"><i class="fas fa-paper-plane"></i></button>
	</form>
</div>
{{-- {{route('feedbacks.reply',['chat_room_id'=> $feedbacks->first()->chat_room->id])}} --}}