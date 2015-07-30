{{ trans('email.password.body', [
    'url' => route('reset.password.form', [$token])
]) }}

---

{{ config('site.name') }}