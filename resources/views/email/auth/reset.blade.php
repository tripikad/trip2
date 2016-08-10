{{ trans('auth.reset.email.body.line1') }}
<br /><br />
{{ route('reset.password.form', [$token], true) }}
<br /><br />
{{ trans('auth.reset.email.body.line2') }}
<br /><br />
--
<br />
{{ config('site.name') }}