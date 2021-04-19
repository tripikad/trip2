@extends('layouts.main2')

@section('content')
    <div class="page-company-profile">
        <div class="page-company-profile__header">
            <div class="container-lg">
                <div class="page-company-profile__navigation">
                    <x-navbar/>
                </div>
                <div class="page-company-profile__heading">
                    <h3>{{$company->name}}</h3>
                </div>
                <div class="row">
                    <div class="col-md-8 col-12">
                        <div class="page-company-profile__tags">
                            <a href="{{route('company.profile', ['company' => $company])}}" class="page-company-profile__tags__tag {{Route::currentRouteName() === 'company.profile' ? 'page-company-profile__tags__tag--active' : ''}}">
                                <span>
                                    Pakkumised
                                </span>
                            </a>
                            <a href="{{route('company.edit_profile', ['company' => $company])}}" class="page-company-profile__tags__tag {{Route::currentRouteName() === 'company.edit_profile' ? 'page-company-profile__tags__tag--active' : ''}}">
                                <span>
                                    Minu Profiil
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container page-company-profile__content">
            @yield('body')
        </div>

        <x-footer/>
    </div>
@endsection