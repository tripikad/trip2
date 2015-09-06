{{ trans('auth.register.email.body.intro') }}!

{!! trans('auth.register.email.body.text', [
    'link' => link_to_route('register.confirm', null, [$user->registration_token], [])
]) !!}


</br></br>
---
</br>
{{ config('site.name') }}
