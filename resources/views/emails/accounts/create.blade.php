@component('mail::message')

{{ __('emails.account.open_account') }}

@component('mail::button', ['url' => $url])
{{ __('emails.account.create_account') }}
@endcomponent

{{ __('emails.thanks') }}<br>
{{ config('app.name') }}
@endcomponent