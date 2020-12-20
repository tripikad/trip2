@extends('layouts.main2')

@section('content')

    <div class="page-company-profile">
        <div class="page-company-profile__header">
            <div class="container-lg">
                <div class="page-company-profile__navigation">
                    <x-navbar/>
                </div>

                <div class="page-company-profile__header-content">
                    <h3 class="page-company-profile__heading">{{$company->name}}</h3>

                    <div class="page-company-page__tabs">
                        <ul>
                            <li>
                                <a href="{{route('company.profile', [$company])}}">
                                    Pakkumised
                                    <span class="page-company-page__tabs__count">12</span>
                                </a>
                            </li>
                            <li class="page-company-page__tabs--active">
                                <a href="#">
                                    Minu info
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container page-company-page__content">
            <div class="row">
                <div class="col-12">

                    <x-form.error-section/>

                    <div class="company-edit-profile__form-container">
                        <div class="company-edit-profile__form-container__form">

                            <x-company.edit-profile-form
                                    :company="$company"
                                    :user="$user"/>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer type="light"/>
    </div>
@endsection