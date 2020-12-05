@extends('layouts.main2')

@section('content')

    <div class="page-company-profile">
        <div class="page-company-profile__header">
            <div class="container">
                <div class="page-company-profile__navigation">
                    <x-navbar/>
                </div>

                <div class="page-company-profile__header-content">
                    <h3 class="page-company-profile__heading">{{$company->name}}</h3>

                    <div class="page-company-page__tabs">
                        <ul>
                            <li class="page-company-page__tabs--active">
                                <a href="#">
                                    Pakkumised
                                    <span class="page-company-page__tabs__count">12</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('company.edit_profile', [$company])}}">
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
                <div class="col-md-8 col-12">
                    Pakkumised
                </div>
                <div class="col-md-4 col-12 mt-5 mt-md-0">
                    <button-vue
                            route="{{route('company.add_package', [$company])}}"
                            title="Lisa uus pakkumine">
                    </button-vue>
                </div>
            </div>
        </div>

        <x-footer type="light"/>
    </div>
@endsection