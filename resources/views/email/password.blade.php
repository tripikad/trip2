{{ trans('email.password.body', ['url' => url('password/reset/' . $token)]) }}

---

{{ config('site.name') }}