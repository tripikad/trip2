@extends('layouts.main2')

@section('content')
    <div class="page-company-profile">
        <div class="page-company-profile__header">
            <div class="container-lg">
                <div class="page-company-profile__navigation">
                    <x-navbar/>
                </div>
                <div class="page-company-profile__heading pb-4">
                    <h3>{{$company->name}}</h3>
                </div>
            </div>
        </div>

        <div class="container page-company-profile__content">
            <div class="col-md-8 col-12">
                @if ($company->user->description)
                    <div class="page-company-profile__company_description">
                        <div class="BlockTitle__title page-company-profile__block">Tutvustus</div>
                        <div>
                            {!! $company->user->description !!}
                        </div>
                    </div>
                @endif

                <div class="BlockTitle__title page-company-profile__block">Pakkumised</div>
                <x-company-travel-offer-list :company="$company"/>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection