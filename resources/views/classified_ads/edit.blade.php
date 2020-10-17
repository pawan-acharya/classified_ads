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
                        <div class="form-group col-sm-12" >
                            <select class="form-control" id="category-select" name="category_id" onchange="getCategoryForm($(this))">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id== $classified_ad->category_id?'selected':''}}> {{$category->category_name}} </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- @if ($classified_ad->category->sub_category)
                            <div class="form-group col-sm-6" >
                                <label for="" class="col-form-label text-md-right">#Sub-Category</label>
                                <select class="form-control @error('sub_category') is-invalid @enderror" name="sub_category">
                                    <option></option>
                                    @foreach (config('sub_category')[$classified_ad->category->sub_category] as $element)
                                        <option value="{{$element}}" {{$classified_ad->sub_category == $element?'selected':''}}>
                                            {{$element}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif --}}
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1" class="col-form-label text-md-right">Title</label>
                            <input type="text" class="form-control  @error('title') is-invalid @enderror"  name="title" onblur="checkTitle({{$classified_ad->id}}, $(this))" value="{{$classified_ad->title}}" required>
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
                            {{-- <div class="form-group col-sm-6">
                                <label for="exampleInputEmail1" class="col-form-label text-md-right">#Images</label>
                                <input type="file" class="" name="title_images[]" value="{{$classified_ad->file->name}}">
                            </div> --}}
                            @php($imageCount=1)
                            @foreach ($classified_ad->files as $file)
                                <div class="form-group col-sm-6">
                                    <input type="file" class="" name="title_images[]" value="{{$file->name}}">
                                </div>
                                @if ($imageCount==1)
                                    <div class="form-group  col-sm-3">
                                        <button type="button" class="btn btn-secondary " onclick="addNewImageDiv()">+</button>
                                    </div>
                                @else
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn btn-danger" onclick="removeThisItem($(this))">X</button>
                                    </div>
                                @endif
                                @php($imageCount++)
                            @endforeach
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="pac-input" class="col-form-label text-md-right">Location</label>
                            <input type="text"  id="pac-input" class="form-control  @error('location') is-invalid @enderror" name="location" value="{{$classified_ad->location}}" >
                        </div>
                        <div class="form-group col-sm-6" id="url-div">
                            @if($classified_ad->url || $classified_ad->category->type != 'none' )
                                <label for="classified_ad-url" class="col-form-label text-md-right">Add a URl</label>
                                <input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" placeholder="URL" value="{{$classified_ad->url}}">
                                @if ( $classified_ad->category->type == 'none' )
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeURLField($(this))">X</button>
                                @endif
                            @else
                                <label for="classified_ad-url" class="col-form-label text-md-right" onclick="addURL($(this))">Add a URL</label>
                            @endif
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="exampleInputEmail1" class="col-form-label text-md-right  @error('descriptions') is-invalid @enderror">Description</label>
                            <textarea class="form-control"  name="descriptions">{{$classified_ad->descriptions}}</textarea>
                        </div>
                        <div id="edit-dyanmic-fields" class="form-group col-sm-12">
                            @include('classified_ads.partials.edit')
                        
                            <div class="form-group col-sm-6"
                            @if ($classified_ad->category->type != 'none')
                                style="display: none"
                            @endif
                            >
                                <label for="featured-ad" class="col-form-label text-md-right">Make this ad Featured</label>
                                <input type="checkbox"  id="make-featured" onclick="makeFeatured($(this))" name="is_featured" 
                                {{$classified_ad->is_featured?'checked':''}}
                                >
                            </div>
                            <div class="form-group col-sm-6" id="featured-for"
                            @if ($classified_ad->category->type != 'none' )
                                style="display: none"
                            @endif
                            >
                                <label for="featured-ad-duration" class="col-form-label text-md-right" >choose duration</label>
                                <select  class="form-control" id="featured-ad-duration" name="feature_type" onchange="addFeaturedAmount($(this))">
                                    <option value="day" {{$classified_ad->feature_type== 'day'?'selected':''}}>1 Day</option>
                                    <option value="week" {{$classified_ad->feature_type== 'week'?'selected':''}}>1 Week</option>
                                    <option value="month" {{$classified_ad->feature_type== 'month'?'selected':''}}>1 Month</option>
                                </select>
                            </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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
<script type="text/javascript">
    var is_admin= {!! Auth::user()->checkIfAdmin()?1:0!!} ;
    var has_plan = {!! Auth::user()->ifLeftAds($category->type)?1:0!!};

    function getCategoryForm(item){
        var url= "{{route('classified_ads.editForm', ':category')}}";
        url= url.replace(':category', item.val());
        $.get( url, function( html ) {
            $('#edit-dyanmic-fields').html(html);
        });
    }

    function checkTitle(classified_ad_id, item){
        var url= "{{route('classified_ads.checkTitleForEdit', ['classified'=>':classified', 'title'=>':title'])}}";
        url= url.replace(':classified', classified_ad_id);
        url= url.replace(':title', item.val());
        $.get( url, function( data ) {
            if(data){
                $('form button:submit').prop('disabled', true);
                $('input[name ="title"]').css('border', '1px solid red');
            }else{
                $('form button:submit').prop('disabled', false);
                $('input[name ="title"]').css('border', 'none');
            }
        });
    }

    function addNewImageDiv(){
        var html= `<div class="form-group col-sm-6">
            <input type="file" class="" name="title_images[]" >
        </div>
        <div class="form-group col-sm-6">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeThisItem($(this))">X</button>
        </div>`;
        var imageDivCount= $('#image-div input').length;
        var category_type= "{!! $category->type !!}";
        if(category_type == 'none' && !is_admin && !has_plan){
            if(imageDivCount== 6){
                // calculateTotalAmount(5);
                $('#selected-features').append('<li class="mb-0">More than 6 Images</li>');
            }
        }
        $('#image-div').append(html);
    }
    function removeThisItem(item){
        var imageDivCount= $('#image-div input').length;
        var category_type= "{!! $category->type !!}";
        if(category_type == 'none' && !is_admin && !has_plan){
            if(imageDivCount== 7){
                // calculateTotalAmount(-5);
            }
        }
        item.parent().prev().remove();
        item.parent().remove(); 
    }

    function addURL(item){
        $('#selected-features').append('<li class="mb-0">Added a URL</li>')
        var url_input_field= '<input type="text"  id="classified_ad-url" class="form-control  @error('url') is-invalid @enderror" name="url" placeholder="URL"> <button type="button" class="btn btn-danger btn-sm" onclick="removeURLField($(this))">X</button>';
        item.parent('#url-div').append(url_input_field);
    }
    function removeURLField(item){
        item.prev().remove();
        item.remove();
    }

    function makeFeatured(item){
        if( item.is(':checked') ){
            $('#featured-for').children().show();
            // addFeaturedAmount($('#featured-ad-duration'));
            $('#selected-features').append('<li class="mb-0">Featured Ad</li>')
        }else{
            $('#featured-for').children().hide();
            // calculateTotalAmount(-previousAmount);
            // previousAmount= 0;
        }
    }
    // debugger;
    // var jq = $.noConflict(); 
    // makeFeatured( $('#make-featured') );
    
</script>
@endpush

@endsection
