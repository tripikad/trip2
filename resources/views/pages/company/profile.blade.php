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
            <div class="row">
                <div class="col-md-8 col-12">
                    <travel-offer-list
                            :items="{{json_encode($offers)}}"/>
                </div>
                <div class="col-md-4 col-12 mt-5 mt-md-0">
                    <div class="page-company-profile__new-package-btn">
                        <travel-offer-add-new-select :company-id="{{$company->id}}"/>
                    </div>
                    <div class="page-company-profile__plans">
                        <subscription-plan/>
                    </div>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection