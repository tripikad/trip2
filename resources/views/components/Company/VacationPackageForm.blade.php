<form {{ $attributes->merge(['class' => 'CompanyVacationPackageForm']) }}
      action="{{ route('company.update_profile', [$company]) }}"
      method="POST"
      autocomplete="off"
      enctype="multipart/form-data"
>
    {{ csrf_field() }}

    <div class="CompanyVacationPackageForm__subtitle">
        Üldinfo
    </div>

    <div class="CompanyVacationPackageForm__field">
        <x-form.text-field
                label="Pakkumise nimetus"
                name="email"
                value="{{ old('email', $company->name) }}"/>
    </div>

    <div class="row CompanyVacationPackageForm__field">
        <div class="col-md-6 col-12">
            <x-form.text-field
                    label="Algus"
                    name="email"
                    value="{{ old('email', $company->name) }}"/>
        </div>

        <div class="col-md-6 col-12">
            <x-form.text-field
                    label="Lõpp"
                    name="email"
                    value="{{ old('email', $company->name) }}"/>
        </div>
    </div>

    <div class="row CompanyVacationPackageForm__field">
        <div class="col-md-6 col-12">
            <x-form.text-field
                    label="Hind alates €"
                    name="email"
                    value="{{ old('email', $company->name) }}"/>
        </div>
    </div>

    <div class="CompanyVacationPackageForm__field">
        <text-editor
                label="Sisu"
                name="description"
                value="{{ old('description', '<p>Some text here</p>') }}">
        </text-editor>
    </div>

    <div class="CompanyVacationPackageForm__subtitle">
        Omadused
    </div>

    <div class="CompanyEditProfileForm__submit-button">
        <x-form.submit-button
                title="{{ trans('Lisa') }}"/>
    </div>
</form>