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
                </div>
            </div>
        </div>

        <div class="container page-company-profile__content">
            <company-travel-offers-page :company="{{json_encode($company)}}"/>
        </div>

        <x-footer/>
    </div>
@endsection