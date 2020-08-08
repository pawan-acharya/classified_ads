@component('mail::message')

{{ __('emails.partners.approved') }}

@component('mail::button', ['url' => route('home')])
{{ $promocode->code }}
@endcomponent

@if($promocode->data['type'] == "value")
{{ __('emails.partners.promocode') }} ${{$promocode->data['value']}} {{ __('emails.partners.off') }}.
@else 
{{ __('emails.partners.promocode') }} {{$promocode->data['value']}}% {{ __('emails.partners.off') }}.
@endif

{{ __('emails.thanks') }}<br>
{{ config('app.name') }}
@endcomponent