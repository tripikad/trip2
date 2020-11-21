<form {{ $attributes->merge(['class' => 'register-business-user-form']) }}
    action="{{ route('register_business_user.submit') }}"
    method="POST"
    autocomplete="off"
>
    {{ csrf_field() }}

    <div class="register-business-user-form__field">
        <x-form.text-Field
                label="{{ trans('auth.register.field.name.title') }}"
                name="name"/>
    </div>
    <div class="register-business-user-form__field">
        <x-form.text-Field
                label="{{ trans('auth.register.field.company_name.title') }}"
                name="company_name"/>
    </div>
    <div class="register-business-user-form__field">
        <x-form.text-field
                label="{{ trans('auth.register.field.email.title') }}"
                name="email"/>
    </div>
    <div class="register-business-user-form__field">
        <x-form.text-field
                label="{{ trans('auth.register.field.password.title') }}"
                name="password"
                type="password"/>
    </div>
    <div class="register-business-user-form__field">
        <x-form.text-field
                label="{{ trans('auth.register.field.password_confirmation.title') }}"
                name="password_confirmation"
                type="password"/>
    </div>
    <div class="register-business-user-form__submit-button">
        <x-form.submit-button
                title="{{ trans('auth.register.submit.title') }}"/>
    </div>

    {!! Honeypot::generate('full_name', 'time') !!}
</form>