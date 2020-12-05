@extends('layouts.main2')

@section('content')

    <div class="company-edit-profile">
        <x-body-background-map/>

        <div class="container company-edit-profile__navigation">
            <x-navbar/>
        </div>

        <h2 class="company-edit-profile__header">
            {{trans('Lisa uus pakkumine')}}
        </h2>

        <x-form.error-section/>

        <div class="company-edit-profile__form-container">
            <div class="company-edit-profile__form-container__form">

                <x-company.vacation-package-form
                        :company="$company"
                />

            </div>
        </div>

        <x-footer type="light"/>
    </div>
@endsection