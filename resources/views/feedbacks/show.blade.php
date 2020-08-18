<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>

	<div class="card card-primary">
      <div class="card-body">
        <div class="row">
        	<div class="col-sm">
        		<a type="button" class="btn btn-warning d-flex justify-content-center" href="{{route('chatrooms.index')}}">Go Back</a>
        	</div>
        	<div class="col-sm" id="main_col">
				<table class="table " >
					  <tbody>
					  	@foreach ($feedbacks as $feedback)
					    	<tr>
					    	@if ($feedback->user->id== Auth::id())
					    		<td></td>
					    		<td class="badge badge-primary text-wrap" style="width: 10rem;" data-feeback-id="{{$feedback->id}}">{{$feedback->message}}</td>
				    		@else
				    			<td class="badge badge-light text-wrap" style="width: 10rem;" data-feeback-id="{{$feedback->id}}">{{$feedback->message}}</td>
				    			<td></td>
					    	@endif
					    	</tr>
					    @endforeach
					  </tbody>
				</table>
				@include('feedbacks.partials.chatbox')	
			</div>
			<div class="col-sm">
				<table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">Field Name</th>
				      <th scope="col">Value</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach (json_decode($feedbacks->first()->chat_room->classified_ad->form_values) as $key=>$value)
				    <tr>
				      	<td>{{$form_items_collection->find($key)->name}}</td>
				      	<td>{{$value}}</td>
				    </tr>
				    @endforeach
				  </tbody>
				</table>
			</div>
		</div>
	  </div>
	</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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
</script>
</body>
</html>
