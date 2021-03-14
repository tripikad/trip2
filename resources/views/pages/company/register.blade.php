@extends('layouts.main2')

@section('content')

    <div class="register-business-user">

        <div class="container register-business-user__navigation">
            <x-navbar/>
        </div>

        <h2 class="register-business-user__header">
            {{trans('auth.register.business_user.title')}}
        </h2>

        <h2 class="register-business-user__sub-header">
            {{trans('auth.register.subhead.title')}}
        </h2>

        <div class="register-business-user__form-container">
            <div class="register-business-user__form-container__form">
                <x-company-register-form />
            </div>
        </div>

        <div class="register-business-user__eula-container">
            <div class="register-business-user__eula-container__eula_link">
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