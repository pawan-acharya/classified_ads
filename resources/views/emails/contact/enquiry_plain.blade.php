@component('mail::message')

{{ __('emails.enquiry.received_enquiry') }}

@component('mail::table')
|                                           |               | 
| ----------------------------------------- |:-------------:|
| {{ __('emails.enquiry.last_name') }}      | {{$last_name}}|
| {{ __('emails.enquiry.email') }}          | {{$email}}    | 
| {{ __('emails.enquiry.subject') }}        | {{$subject}}  | 
| {{ __('emails.enquiry.message') }}        | {{$body}}     |
@endcomponent

{{ __('emails.thanks') }}<br>
{{ config('app.name') }}
@endcomponent