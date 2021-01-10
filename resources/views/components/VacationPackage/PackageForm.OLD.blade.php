<form {{ $attributes->merge(['class' => 'VacationPackageForm']) }}
      action="{{ $submitRoute }}"
      method="POST"
      autocomplete="off"
>
    {{ csrf_field() }}

    <div class="VacationPackageForm__subtitle">
        Üldinfo
    </div>

    <div class="VacationPackageForm__field">
        <x-form.text-field
                label="Pakkumise nimetus"
                name="name"
                value="{{ old('name') }}"/>
    </div>

    <div class="row VacationPackageForm__field">
        <div class="col-md-6 col-12">
            <form-datepicker
                    title="Algus"
                    name="start_date"
                    placeholder="Algus"
                    value="{{ old('start_date') }}"
                    disable-past-dates="true"
                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
            </form-datepicker>
        </div>

        <div class="col-md-6 col-12">
            <form-datepicker
                    title="Lõpp"
                    name="end_date"
                    placeholder="lõpp"
                    value="{{ old('end_date') }}"
                    disable-past-dates="true"
                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
            </form-datepicker>
        </div>
    </div>

    <div class="row VacationPackageForm__field">
        <div class="col-md-6 col-12">
            <x-form.text-field
                    label="Hind alates €"
                    name="price"
                    value="{{ old('price') }}"/>
        </div>
    </div>

    <div class="VacationPackageForm__field">
        <text-editor
                title="Sisu"
                name="description"
                value="{{ old('description') }}"
                errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
        </text-editor>
    </div>

    <div class="VacationPackageForm__field">
        <x-form.text-field
                label="Link"
                name="link"
                value="{{ old('link') }}"/>
    </div>

    <div class="VacationPackageForm__submit-button">
        <x-form.submit-button
                title="{{ trans('Lisa') }}"/>
    </div>
</form>