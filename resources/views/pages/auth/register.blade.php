@extends('layouts.main')

@section('title', trans('auth.register.title'))

@section('header')

    @include('component.header')

@stop

@section('content')

<div class="r-auth">

    <div class="r-auth__map">

        <div class="c-auth-map">
            @include('component.svg.standalone', [
                'name' => 'map'
            ])
        </div>
    </div>

    <div class="r-auth__header">

        <div class="r-auth__masthead">

            @include('component.auth.masthead', [
                'subtitle' => 'Liitu Trip.ee reisihuviliste seltskonnaga'
            ])

        </div>
    </div>

    <div class="r-auth__content">

        <ul class="c-auth-tabs">
            <li class="c-auth-tabs__item"><span class="c-auth-tabs__text">Emailiga</span></li>
            <li class="c-auth-tabs__item"><a href="{{ route('facebook.redirect') }}" class="c-auth-tabs__link m-facebook">Facebook</a></li>
            <li class="c-auth-tabs__item"><a href="{{ route('google.redirect') }}" class="c-auth-tabs__link m-google">Google</a></li>
        </ul>

        <div class="r-auth__content-inner">

            {!! Form::open(['route' => 'register.submit']) !!}

                {!! Honeypot::generate('full_name', 'time') !!}

                <div class="c-form__group">
                    {!! Form::label('name', trans('auth.register.field.name.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::text('name', null, [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('email', trans('auth.register.field.email.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::email('email', null, [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('password', trans('auth.register.field.password.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::password('password', [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('password_confirmation', trans('auth.register.field.password_confirmation.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::password('password_confirmation', [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::submit(trans('auth.register.submit.title'), [
                        'class' => 'c-button m-large m-block'
                    ]) !!}
                </div>
            {!! Form::hidden('eula', 1) !!}
            {!! Form::close() !!}
        </div>

        <div class="r-auth__content-footer">

            <div class="c-auth-footer">

                <p class="c-auth-footer__text">
                    {!! trans('auth.register.field.eula.title', [
                        'link' => '<a href="' . route('static.show', [25151]) . '" class="c-auth-footer__link">' . trans('auth.register.field.eula.title.link'). '</a>'
                    ]) !!}</p>

            </div>

        </div>
    </div>
</div>

@stop

@section('footer')

    @include('component.footer')

@stop