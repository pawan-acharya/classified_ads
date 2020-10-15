@extends('layouts.app')

@section('content')
	<div class="card card-primary">
      <div class="card-body">
        <div class="row">
        	<div class="col-sm-3">
				<div class="tab" id="main-tab">
					@foreach ($chat_rooms as $chat_room)
					<a href="{{route('feedbacks.show', ['chat_room_id'=> $chat_room->id])}}">
						<div class="user-card {{$chat_room->id ==$feedbacks->first()->chat_room->id?'active-chat':''}}">
							<div class="user-avatar">
								{{-- <img src="{{ $chat_room->advertiser_user->file->getPathAttribute() }}" width="100%" class="displayimage"/> --}}
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
				</div>
        	</div>
        	<div class="col-sm-6" id="main_col">
				<div class="chat-section">
					<table class="table">
						<tbody>
							@foreach ($feedbacks as $feedback)
								<tr>
								@if ($feedback->user->id == Auth::id())
									<td></td>
									<td class="message message-sent" data-feeback-id="{{$feedback->id}}"><span>{{$feedback->message}}</span></td>
								@else
									<td class="message message-received" data-feeback-id="{{$feedback->id}}"><span>{{$feedback->message}}</span></td>
									<td></td>
								@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('feedbacks.partials.chatbox')	
			</div>
			
			<div class="col-sm-3">
				<div class="members-setting">
					<div class="user-card">
						<div class="user-avatar"><img src="{{ asset('images/avatar.png') }}"/></div>
						<div class="user-content">
							<p class="user-name">{{ $feedback->user->first_name }}</p>
							<p>Member since {{ date('d F, Y', strtotime($feedback->user->created_at)) }}</p>
						</div>
					</div>

					<div class="sidebar-similar-ads">
						<div class="featured-ads-items">
							<h5>Ads</h5>
								<div class="featured-ads-item d-flex">
									<div class="aspect-ratio-box-wrap" style="width:20%;">
										<div class="aspect-ratio-box">
											<img src="{{ $chat_room->classified_ad->file->getPathAttribute() }}" width="100%">
										</div>
									</div>
									<div class="pl-2" width="70%">
										<h6>{{$chat_room->classified_ad->title}}</h6>
										<h6 class="ads-item-price">
											${{$chat_room->classified_ad->price}} 
											{{$chat_room->classified_ad->price_for?'/':''}} {{$chat_room->classified_ad->price_for}}
										</h6>
									</div>
								</div>
						</div>
					</div>
					<div class="sidebar-similar-ads">
						<div class="featured-ads-items">
							<h5>Ads</h5>
							<a class="featured-ads-item d-flex" href="/classified_ads/{{$chat_room->classified_ad->id}}">
								<div class="aspect-ratio-box-wrap" style="width:20%;">
									<div class="aspect-ratio-box">
										<img src="{{ $chat_room->classified_ad->file->getPathAttribute() }}" width="100%">
									</div>
								</div>
								<div class="pl-2" width="70%">
									<h6>{{$chat_room->classified_ad->title}}</h6>
									<h6 class="ads-item-price">
										${{$chat_room->classified_ad->price}} 
										{{$chat_room->classified_ad->price_for?'/':''}} {{$chat_room->classified_ad->price_for}}
									</h6>
								</div>
							</a>
						</div>
					</div>
					<div class="sidebar-similar-ads">
						<div class="featured-ads-items">
							<h5>Similar Ads</h5>
							@for ($i = 0; $i < 5; $i++)
								<div class="featured-ads-item d-flex">
									<div class="aspect-ratio-box-wrap" style="width:20%;">
										<div class="aspect-ratio-box">
											<img src="{{ asset('images/tree-snow.jpg') }}" width="100%">
										</div>
									</div>
									<div class="pl-2" width="70%">
										<h6>Real estate Broker</h6>
										<h6 class="ads-item-price">$40 / night</h6>
									</div>
								</div>
							@endfor
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
@push('js')
<script type="text/javascript">
	
	window.addEventListener('DOMContentLoaded', function() {
		(function($) {
			var active_chatroom= {!!$feedbacks->first()->chat_room->id!!};
			$("#main_col #feed_back_form").submit(function(){
				var $form = $(this);
				$(this).find("#last_feedback_id").val($("#main_col").find("tr ").last().find("td.badge").data("feeback-id"));
				var serializedData = $form.serialize();
				url = $form.data( "url" );
			
				request = $.ajax({
					url: url,
					type: "post",
					data: serializedData
				});
				request.done(function (html){
					$("#feed_back_form")[0].reset();
					$("#main_col").find("tbody").append(html);
					getChatRooms();
				});
			});

			function refreshFeedbacks(){
				var url= "{{route('feedbacks.show', ':chat_room_id')}}";
				url= url.replace(':chat_room_id', {!! $feedbacks->first()->chat_room_id !!});
				$.get(url, function(html){
					$("#main_col").find("tbody").html(html);
				});
			}
			setInterval( refreshFeedbacks, 10000 );
			
			function getChatRooms(){
				$.get("{{route('chatrooms.index')}}", function(html){
					$("#main-tab").html(html);
					$("#main-tab .user-card[data-id=" + active_chatroom + "]").addClass("active-chat");
				});
			}
			setInterval(getChatRooms, 10000);
		})(jQuery);
	});
</script>
@endpush

@endsection