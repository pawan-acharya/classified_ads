@component('mail::message')

{{ __('emails.partners.rejected') }}

{{ __('emails.thanks') }}<br>
{{ config('app.name') }}
@endcomponent