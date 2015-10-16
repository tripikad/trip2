{{ trans('auth.reset.email.body.line1') }}

{{ route('reset.password.form', [$token], true) }}

{{ trans('auth.reset.email.body.line2') }}

--
{{ config('site.name') }}