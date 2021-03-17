@extends('layouts.main2')

@section('content')

    <div class="company-edit-profile">

        <div class="container">
            <div class="company-edit-profile__navigation">
                <x-navbar/>
            </div>

            <h2 class="company-edit-profile__header">
                Lisa uus paketikas
            </h2>

            <travel-offer-package-form
                    submitRoute="{{route('company.store_travel_offer', ['company' => $company])}}"/>

<!--            <div class="company-edit-profile__form-container">
                <div class="company-edit-profile__form-container__form">
                    <form class="VacationPackageForm"
                          action="{{route('company.store_travel_offer', ['company' => $company])}}"
                          method="POST"
                          autocomplete="off"
                    >
                        {{ csrf_field() }}

                        <div class="VacationPackageForm__field">
                            <form-select
                                    title="Asukoht"
                                    name="destination"
                                    :options="{{json_encode($destinations) }}"
                                    value="{{ old('destination') }}"/>
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

                        <div class="VacationPackageForm__subtitle">
                            Hotellid
                        </div>

                        <div class="VacationPackageForm__hotels">
                            <travel-offer-hotel />
                        </div>

                        <div class="VacationPackageForm__subtitle">
                            Info
                        </div>

                        <div class="VacationPackageForm__field">
                            <form-text-editor
                                    title="Kirjeldus"
                                    name="description"
                                    class="VacationPackageForm__editor"
                                    value="{{ old('description') }}"
                                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
                            </form-text-editor>
                        </div>

                        <div class="VacationPackageForm__field">
                            <form-text-editor
                                    title="Majutuse info"
                                    name="description"
                                    value="{{ old('description') }}"
                                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
                            </form-text-editor>
                        </div>

                        <div class="VacationPackageForm__field">
                            <form-text-editor
                                    title="Pakkumine sisaldab"
                                    name="description"
                                    value="{{ old('description') }}"
                                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
                            </form-text-editor>
                        </div>

                        <div class="VacationPackageForm__field">
                            <form-text-editor
                                    title="Pakkumine ei sisalda"
                                    name="description"
                                    value="{{ old('description') }}"
                                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
                            </form-text-editor>
                        </div>

                        <div class="VacationPackageForm__field">
                            <form-text-editor
                                    title="Lisatasu eest"
                                    name="description"
                                    value="{{ old('description') }}"
                                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
                            </form-text-editor>
                        </div>

                        <div class="VacationPackageForm__field">
                            <form-text-editor
                                    title="Lisainfo"
                                    name="description"
                                    value="{{ old('description') }}"
                                    errors="{{ $errors->count() ? json_encode($errors->keys()) : null}}">
                            </form-text-editor>
                        </div>

                        <div class="VacationPackageForm__submit-button">
                            <x-form-submit-button
                                    title="{{ trans('Lisa') }}"/>
                        </div>
                    </form>

                </div>
            </div>-->
        </div>

        <x-footer type="light"/>
    </div>
@endsection