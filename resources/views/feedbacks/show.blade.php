@extends('layouts.app')

@section('content')
	<div class="card card-primary">
      <div class="card-body">
        <div class="row">
        	<div class="col-sm-3">
				<div class="tab" id="main-tab">
					<div class="user-card">
						<div class="user-avatar"><img src="{{ asset('images/avatar.png') }}"/></div>
						<div class="user-content">
							<p class="user-name">Carl Lynch</p>
							<p>Honesty is just a test policy</p>
							<span class="message-time">1:23 PM<span>
						</div>
					</div>
					<div class="user-card">
						<div class="user-avatar"><img src="{{ asset('images/avatar.png') }}"/></div>
						<div class="user-content">
							<p class="user-name">Ricky</p>
							<p>Did the do.</p>
							<span class="message-time">8/8/19<span>
						</div>
					</div>
				</div>
        	</div>
        	<div class="col-sm-6" id="main_col">
				<table class="table">
					  <tbody>
					  	@foreach ($feedbacks as $feedback)
					    	<tr>
					    	@if ($feedback->user->id== Auth::id())
					    		<td></td>
					    		<td class="message message-sent" style="width: 100%;" data-feeback-id="{{$feedback->id}}"><span>{{$feedback->message}}</span></td>
				    		@else
				    			<td class="message message-received" style="width: 100%;" data-feeback-id="{{$feedback->id}}"><span>{{$feedback->message}}</span></td>
				    			<td></td>
					    	@endif
					    	</tr>
					    @endforeach
					  </tbody>
				</table>
				@include('feedbacks.partials.chatbox')	
			</div>
			<div class="col-sm-3">
				<table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">Field Name</th>
				      <th scope="col">Value</th>
				    </tr>
				  </thead>
				  <tbody>
				  
				  </tbody>
				</table>
			</div>
		</div>
	  </div>
	</div>
@push('js')
<script type="text/javascript">
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
	    });
  	});

  	function refreshFeedbacks(){
  		var url= "{{route('feedbacks.show', ':chat_room_id')}}";
  		url= url.replace(':chat_room_id', {!! $feedbacks->first()->chat_room_id !!});
  		// debugger;
  		$.get(url, function(html){
	        $("#main_col").find("tbody").append(html);
	    });
  	}
	  setInterval( refreshFeedbacks, 10000 );
	  
	  function getChatRooms(){
      $.get("{{route('chatrooms.index')}}", function(html){
          $("#main-tab").html(html);
      });
    }
    getChatRooms();
    setInterval(getChatRooms, 10000);
</script>
@endpush

@endsection