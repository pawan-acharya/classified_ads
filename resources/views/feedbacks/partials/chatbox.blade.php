
<div>
	<form action="javascript:void(0)" method="POST"  id="feed_back_form" data-url="{{route('feedbacks.reply',['chat_room_id'=> $feedbacks->first()->chat_room->id])}}">
		@csrf
		<input type="hidden" id="last_feedback_id" name="last_feedback_id" value="">
		<div class="form-group ">
	        <input type="text" class="form-control" name="message" required>
		</div>
		<button type="submit" class="btn btn-success float-right text-right"  >Send</button>
	</form>
</div>
{{-- {{route('feedbacks.reply',['chat_room_id'=> $feedbacks->first()->chat_room->id])}} --}}