@extends('layouts.app')

@section('content')
<section id="articles-intro">
    <div class="container">
        <h1 class="section-head">{{ __('pages.articles') }}</h1>
        <div class="row">
            <div class="col-md-5 article-content">
                <h5 class="font-weight-bold mb-3">Titre Lorem ipsum dolor sit amet consectetur adipiscing elit</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praes- ent in commodo ipsum. Etiam mauris nisl, efficitur ut tellus non, condimentum aliquam ex. Pellentesque pellentesque eu purus vitae ultricies. Duis leo nisi, maximus sed aliquet dictum, lobor- tis non ante. Sed condimentum dui sit amet vulputate egestas. Praesent consectetur elementum nunc, ac viverra dolor mattis ornare. Nunc vel commodo quam. Praesent enim massa, feugiat eu tortor eget, cursus molestie metus. Aliquam sed sapien hen- drerit, semper ligula in, consequat dolor. In ac massa luctus, ali- quam tellus non, pulvinar diam.</p>
                <p>Pellentesque sed lectus varius, mattis quam eget, molestie elit. Mauris ultrices porta nunc, a tincidunt ligula mollis eget. Sed luctus vehicula enim, iaculis rhoncus nulla. Aenean gravida, nunc non sodales faucibus, sem ex varius dolor, quis fringilla lacus quam non eros. Pellentesque vitae nibh eget orci venenatis sa- gittis sit amet eu massa. Pellentesque tempus augue egestas leo ornare dignissim. In purus purus, tristique vitae laoreet nec, tris- tique ac arcu. In laoreet diam sed enim condimentum, eu place- rat nibh congue. Maecenas id iaculis elit. Fusce elementum mi a metus scelerisque, ac gravida nisi molestie. Ut auctor vestibulum ornare. In luctus lobortis sagittis. Vestibulum bibendum augue a urna hendrerit, ut placerat metus vulputate.</p>
                <p>Quisque sodales neque ullamcorper velit euismod, vitae laoreet metus tempor. Nunc placerat fermentum viverra. Pellentesque ac eleifend ipsum, non mollis sapien. Praesent tempor ullamcor- per erat vitae convallis. Nulla quis lorem aliquet, venenatis libero vitae, vestibulum lectus. In ac nibh consequat, euismod magna sit amet, venenatis neque. Phasellus elementum eu nunc a maxi- mus. Donec ullamcorper arcu id cursus dignissim. Sed rhoncus in ante sit amet posuere. Quisque id felis eros. Suspendisse leo diam, ultrices sit amet ullamcorper vitae, dapibus ac risus.</p>
            </div>   
            <div class="col-md-7">
                <div class="article-image">
                    <img src="{{ asset('images/woman-driving-car.jpg') }}" class="img-responsive mb-4" width="100%">
                    <p>{{ __('pages.photo_credit') }} xxxxxx {{ __('pages.or_legend') }} xxxx</p>
                </div>
                <div class="image-text-wrapper clearfix"> 
                    <div class="col-md-6 pt-3 float-left">
                        <h6 class="font-weight-bold">Titre Lorem ipsum dolor sit amet consectetur adipiscing elit</h6>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing eli.</p>
                        <div class="btn-toolbar my-4">
                            <a href="#" class="btn btn-primary btn-round mr-3">{{ __('pages.article_previous') }}</a>
                            <a href="#" class="btn btn-primary btn-round">{{ __('pages.article_next') }}</a>
                        </div>
                            
                    </div>
                    <div class="col-md-6 image-wrapper-auto">
                        <img src="{{ asset('images/audi-black.jpg') }}" class="img-responsive" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection