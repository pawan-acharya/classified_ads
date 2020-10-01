@extends('layouts.app')

@section('content')
<section id="ad-edit" class="primary-background">
    <h1 class="section-head">{{ Session::has('ad-edit') ? __('ads.lease_details') : __('ads.details') }}</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 my-5">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger row" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class=" card">
                    <div class="card-header">
                        Fill the form
                    </div>
                    <div class="card-body" id="category_form_here">
                    <form method="POST" action="{{ route('classified_ads.update', ['classified_ad'=>$classified_ad->id]) }}" enctype="multipart/form-data" class="row">
                        @csrf
                        {{ method_field("PUT") }}
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1" class="col-form-label text-md-right">Title</label>
                            <input type="text" class="form-control  @error('title') is-invalid @enderror"  name="title" value="{{$classified_ad->title}}" required>
                        </div> 
                        <div class="form-group col-sm-6" >
                            <label for="exampleInputEmail1" class="col-form-label text-md-right">#CITQ</label>
                            <input type="text" class="form-control  @error('citq') is-invalid @enderror" name="citq" value="{{$classified_ad->citq}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1" class="col-form-label text-md-right">Price</label>
                            <input type="number" class="form-control  @error('price') is-invalid @enderror" name="price" value="{{$classified_ad->price}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1" class="col-form-label text-md-right">Per</label>
                            <input type="text" class="form-control  @error('price_for') is-invalid @enderror" name="price_for" value="{{$classified_ad->price_for}}">
                        </div>
                        <div class="col-sm-12 row" id="image-div">
                            <div class="form-group col-sm-6">
                                <label for="exampleInputEmail1" class="col-form-label text-md-right">#Images</label>
                                <input type="file" class="" name="title_images[]" value="{{$classified_ad->file->name}}">
                            </div>
                            <div class="form-group  col-sm-3">
                                <button type="button" class="btn btn-secondary " onclick="addNewImageDiv()">+</button>
                            </div>
                            @foreach ($classified_ad->files as $file)
                                <div class="form-group col-sm-6">
                                    <input type="file" class="" name="title_images[]" value="{{$file->name}}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="pac-input" class="col-form-label text-md-right">Location</label>
                            <input type="text"  id="pac-input" class="form-control  @error('location') is-invalid @enderror" name="location" value="{{$classified_ad->location}}" >
                        </div>
                        <div class="form-group col-sm-6" id="url-div">
                            @if($classified_ad->url || $classified_ad->category->type != 'none' || Auth::user()->checkIfAdmin() || Auth::user()->ifLeftAds())
                                <label for="classified_ad-url" class="col-form-label text-md-right">Add a URl</label>
                                <input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" value="{{$classified_ad->url}}">
                            @else
                                <label for="classified_ad-url" class="col-form-label text-md-right" onclick="addURL($(this))">Add a URL</label>
                            @endif
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="exampleInputEmail1" class="col-form-label text-md-right  @error('descriptions') is-invalid @enderror">Description</label>
                            <textarea class="form-control"  name="descriptions">{{$classified_ad->descriptions}}</textarea>
                        </div>

                        @include('classified_ads.partials.edit')
                        
                        <div class="form-group col-sm-6">
                            <label for="featured-ad" class="col-form-label text-md-right">Make this ad Featured</label>
                            <input type="checkbox"  id="make-featured" onclick="makeFeatured($(this))" name="is_featured" {{$classified_ad->is_featured?'checked':''}}>
                        </div>
                        <div class="form-group col-sm-6" id="featured-for">
                            @if($classified_ad->is_featured)
                            <label for="featured-ad-duration" class="col-form-label text-md-right">choose duration</label>
                            <select  class="form-control" id="featured-ad-duration" name="feature_type" onchange="addFeaturedAmount($(this))">
                                @if ($classified_ad->category->type =='none' && !Auth::user()->checkIfAdmin() && !Auth::user()->ifLeftAds())
                                    <option value="day">1 Day</option>
                                    <option value="week">1 Week</option>
                                @endif
                                <option value="month">1 Month</option>
                            </select>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-round">
                                    {{ __('ads.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts-vars')
<script>
    var options ={!! json_encode(__('ads.model_options')) !!};
    var old_model = '{{ $old_model ?? ''}}';
    var validationRequired = "{{ __('auth.required') }}";
    var validationPattern = "{{ __('auth.invalid_info') }}";
</script>
@endpush

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        var SITEURL = "{{url('/files')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.delete-image', function () {
            var that = $(this);
            var file_id = that.data('file_id');
            that.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            );
            
            $.ajax({
                type: "DELETE",
                url: SITEURL + '/' +file_id,
                success: function (data) {
                    that.parent().remove();
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
