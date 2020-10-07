@extends('layouts.app')

@section('content')
<div class="container">
  <div class="message-container bg-white">
      <div class="row-head">{{ __('auth.my_messages') }}</div>
      <div class="card-body">
          <div class= "row">
              <div class="tab" id="main-tab">
          </div>
      </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
  (function($) {
    function getChatRooms(){
      $.get("{{route('chatrooms.index')}}", function(html){
          $("#main-tab").html(html);
      });
    }
    getChatRooms();
    setInterval(getChatRooms, 10000);
  })(jQuery);
});
</script>
@endpush

@endsection