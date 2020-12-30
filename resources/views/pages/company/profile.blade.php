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
                <div class="col-md-8 col-12">
                    <x-company.vacation-package-list :company="$company"/>
                </div>
                <div class="col-md-4 col-12 mt-5 mt-md-0">
                    <div class="page-company-profile__new-package-btn">
                        <button-vue
                                route="{{route('company.add_package', [$company])}}"
                                title="Lisa uus pakkumine"/>
                    </div>

                    <div class="page-company-profile__plans">
                        <vacation-package-subscription-plan/>
                    </div>

<!--                    <div>
                        <x-ads id="{{config('promo.sidebar_small.id2')}}"/>
                        <x-ads id="{{config('promo.sidebar_large.id2')}}"/>
                    </div>-->
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
@endsection