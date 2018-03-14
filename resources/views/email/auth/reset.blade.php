@component('mail::message')
# {{ trans('auth.reset.email.body.line1') }}

@component('mail::button', ['url' => route('reset.password.form', [$user->remember_token], true),'color' => 'green'])
{{ trans('auth.reset.email.button.text') }}
@endcomponent

@component('mail::panel')
{{ trans('auth.reset.email.body.line2') }}
@endcomponent

@endcomponent
