@extends('layouts.app')

@section('content')

<section id="my-account">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h1 class="section-head"> {{ __('ads.wishlist') }} </h1>

                <div class="col-md-12 ad-container">
                    <div class="row-head">{{ __('auth.my_ads') }}</div>
                    <div class="card-body">
                        <div class= "row">
                        @foreach ($ads as $index => $ad)
                            @include('ads.partials.ad',['parent' => 'wishlist'])
                        @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"">{{ __('auth.send_invitation')}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert d-none" role="alert"></div>
                            <form id="email-form" method="POST" action="{{ url("partners/approve") }}">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="input-group control-group after-add-more col-md-12">
                                            <input type="text" name="emails[]" class="form-control" placeholder="Enter email" required>
                                            <div class="input-group-btn"> 
                                              <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> +</button>
                                            </div>
                                          </div>   
                                    </div>
                                </div>
                            </form>
                            <!-- Copy Fields -->
                            <div class="copy d-none" >
                            <div class="control-group input-group col-md-12 mt-3">
                                <input type="text" name="emails[]" class="form-control" placeholder="Enter email">
                                <div class="input-group-btn"> 
                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> -</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('auth.close')}}</button>
                          <button id="email-form-submit" type="button" class="btn btn-primary">{{ __('auth.send')}}</button>
                        </div>
                      </div>
                    </div>
                </div>


            </div>
            
        </div>
    </div>
</section>

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        var SITEURL = "{{ url('/wishlists') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '#remove-from-whislists', function (event) {
            event.preventDefault();
            var that = $(this);
            var ad_id = that.data('ad_id');
            that.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            );
            
            $.ajax({
                type: "DELETE",
                url: SITEURL + '/' + ad_id,
                success: function (data) {
                    that.parent().parent().parent().parent().remove();
                },
                error: function (error) {
                    alert(error.responseJSON.message);
                }
            });
        }); 
    })(jQuery);
});
</script>
@endpush

@endsection
