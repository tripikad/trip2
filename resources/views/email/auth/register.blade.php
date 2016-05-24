{{ trans('auth.register.email.body.line1') }}
<br /><br />
{{ trans('auth.register.email.body.line2') }}
<br /><br />
{{ route('register.confirm', [$user->registration_token], true) }}
<br /><br />
--
<br />
{{ config('site.name')}}
