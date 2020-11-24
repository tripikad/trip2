<form {{ $attributes->merge(['class' => 'CompanyEditProfileForm']) }}
      action="{{ route('user.update_company', ['id' => $user->id]) }}"
      method="POST"
      autocomplete="off"
      enctype="multipart/form-data"
>
    {{ csrf_field() }}

    {{--User info--}}
    <div class="CompanyEditProfileForm__subtitle">
        {{trans('user.edit.account.title')}}
    </div>

    <div class="CompanyEditProfileForm__field">
        <x-form.text-Field
                label="{{ trans('auth.register.field.name.title') }}"
                name="name"
                value="{{$user->name}}"
                disabled="true"/>
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.text-field
                label="{{ trans('auth.register.field.email.title') }}"
                name="email"
                value="{{ old('email', $user->email) }}"/>
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.text-field
                label="{{ trans('auth.register.field.password.title') }}"
                name="password"
                type="password"/>
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.text-field
                label="{{ trans('auth.register.field.password_confirmation.title') }}"
                name="password_confirmation"
                type="password"/>
    </div>

    {{--Company info--}}
    <div class="CompanyEditProfileForm__subtitle CompanyEditProfileForm__subtitle--withTop">
        {{trans('company.edit.info.subtitle')}}
    </div>

    <div class="CompanyEditProfileForm__field">
        <x-form.text-Field
                label="{{ trans('auth.register.field.company_name.title') }}"
                name="company_name"
                value="{{ old('company_name', $company->name) }}"/>
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.textarea
                label="{{ trans('company.description') }}"
                name="description"
                value="{{ old('description', $user->description) }}"/>
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.text-field
                label="{{ trans('company.edit.homepage.title') }}"
                name="homepage"
                value="{{ old('homepage', $user->contact_homepage) }}"/>
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.text-field
                label="{{ trans('company.edit.facebook.title') }}"
                name="facebook"
                value="{{ old('facebook', $user->contact_facebook) }}"/>
    </div>

    {{--Company info--}}
    <div class="CompanyEditProfileForm__subtitle CompanyEditProfileForm__subtitle--withTop">
        {{trans('company.edit.logo.subtitle')}}
    </div>
    <div class="CompanyEditProfileForm__field">
        <x-form.image-file-upload
                name="logo"
        />
    </div>

    <div class="CompanyEditProfileForm__submit-button">
        <x-form.submit-button
                title="{{ trans('company.edit.submit') }}"/>
    </div>
</form>