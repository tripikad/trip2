{{ trans('auth.register.email.body.line1') }}

{{ trans('auth.register.email.body.line2') }}

{{ route('register.confirm', [$user->registration_token], true) }}

--
{{ config('site.name')}}
