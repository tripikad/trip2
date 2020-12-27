@extends('layouts.main2')

@section('content')

    <div class="page-company-profile">
        <div class="page-company-profile__header">
            <div class="container-lg">
                <div class="page-company-profile__navigation">
                    <x-navbar/>
                </div>
                <div class="page-company-profile__header-content">
                    <h3 class="page-company-profile__header-content__heading">{{$company->name}}</h3>
                    <x-tabs :tabs="$items" class="dark"/>
                </div>
            </div>
        </div>

        <div class="container page-company-profile__content">
            <div class="row">
                <div class="col-md-12 col-12">
                    <x-form.error-section/>

                    <x-company.edit-profile-form
                            :company="$company"
                            :user="$user"/>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection