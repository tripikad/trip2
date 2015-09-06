{{!! trans('email.password.body', [
    'url' => link_to_route('reset.password.form', null, [$token], [])
]) !!}


</br></br>
---
</br>
{{ config('site.name') }}