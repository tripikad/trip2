@extends('layouts.main2')

@section('content')
    <div class="page-company-register">
        <div class="container page-company-register__navigation">
            <x-navbar/>
        </div>

        <h2 class="page-company-register__header">
            {{trans('auth.register.business_user.title')}}
        </h2>

        <h2 class="page-company-register__sub-header">
            {{trans('auth.register.subhead.title')}}
        </h2>

        <div class="page-company-register__form">
            <x-company-register-form />
        </div>

        <div class="page-company-register__eula">
            <div class="register-business-user__eula__link">
                {!! trans('auth.register.field.eula.title', [
                            'link' => format_link(
                                route('static.show.id', [25151]),
                                trans('auth.register.field.eula.title.link'),
                                true
                            )
                        ])
                !!}
            </div>
        </div>

        <x-footer type="light"/>
    </div>
@endsection