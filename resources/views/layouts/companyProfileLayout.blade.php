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
                            <div class="page-company-profile__tags__tag {{Route::currentRouteName() === 'company.profile' ? 'page-company-profile__tags__tag--active' : ''}}">
                                <a href="{{route('company.profile', ['company' => $company])}}">Pakkumised</a>
                            </div>
                            <div class="page-company-profile__tags__tag {{Route::currentRouteName() === 'company.edit_profile' ? 'page-company-profile__tags__tag--active' : ''}}">
                                <a href="{{route('company.edit_profile', ['company' => $company])}}">Minu Profiil</a>
                            </div>
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