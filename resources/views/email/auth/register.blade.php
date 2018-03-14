@component('mail::message')
# {{ trans('auth.register.email.body.line1') }}

{{ trans('auth.register.email.body.line2') }}

@component('mail::button', ['url' => route('register.confirm', [$user->registration_token], true),'color' => 'green'])
{{ trans('auth.register.email.button.text') }}
@endcomponent

@endcomponent
