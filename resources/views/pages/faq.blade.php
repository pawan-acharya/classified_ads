@extends('layouts.app')

@section('content')

<section id="faq-intro">
    <div class="container">
        <h1 class="section-head">{{ __('pages.faq') }}</h1>    
        <div class="faq-question">
            <p>Question Lorem Ipsum nulla auctor consectetur nunc, id hendrerit tortor placerat sit amet ?</p>
            <img src="{{ asset('images/icon/arrow-down.png') }}">
        </div>
        <div class="faq-question">
            <p>Question Lorem Ipsum nulla auctor consectetur nunc, id hendrerit tortor placerat sit amet ? </p>
            <img src="{{ asset('images/icon/arrow-down.png') }}">
        </div>
        <div class="faq-response-wrapper">
            <h6>{{ __('pages.reply') }}</h6>
            <p>- <br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quam nulla, placerat sit amet feugiat id, viverra id tortor. Fusce in sodales erat. Aliquam id orci quis dui
                lobortis sodales. Nulla auctor consectetur nunc, id hendrerit tortor placerat sit amet. Ut rutrum fringilla ipsum ut ultrices. Aliquam erat volutpat. Curabitur sagittis
                elementum feugiat. Etiam dolor diam, viverra vitae malesuada sed, pellentesque quis lorem. Fusce fermentum eu lectus ac suscipit. Sed arcu risus, rhoncus in felis 
                eget, obortis tempus sem.
            </p>
        </div>
    </div>
</section>

@endsection
