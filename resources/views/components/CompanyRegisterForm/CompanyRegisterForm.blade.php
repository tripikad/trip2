<form {{ $attributes->merge(['class' => 'RegisterBusinessUserForm']) }}
      action="{{ route('register_company.submit') }}"
      method="POST"
      autocomplete="off"
>
    {{ csrf_field() }}

    <div class="RegisterBusinessUserForm__field">
        <x-form-text-field
                title="{{ trans('auth.register.field.name.title') }}"
                name="name"/>
    </div>
    <div class="RegisterBusinessUserForm__field">
        <x-form-text-field
                title="{{ trans('auth.register.field.company_name.title') }}"
                name="company_name"/>
    </div>
    <div class="RegisterBusinessUserForm__field">
        <x-form-text-field
                title="{{ trans('auth.register.field.email.title') }}"
                name="email"/>
    </div>
    <div class="RegisterBusinessUserForm__field">
        <x-form-text-field
                title="{{ trans('auth.register.field.password.title') }}"
                name="password"
                type="password"/>
    </div>
    <div class="RegisterBusinessUserForm__field">
        <x-form-text-field
                title="{{ trans('auth.register.field.password_confirmation.title') }}"
                name="password_confirmation"
                type="password"/>
    </div>
    <div class="RegisterBusinessUserForm__submit-button">
        <x-form-submit-button
                title="{{ trans('auth.register.submit.title') }}"/>
    </div>

    {!! Honeypot::generate('full_name', 'time') !!}
</form>