@extends('layouts.main')

@section('title', trans('auth.login.title'))

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
                'subtitle' => 'Pole veel kasutaja? <a href="/register">Registreeri siin</a>'
            ])

        </div>
    </div>

    <div class="r-auth__content">

        <ul class="c-auth-tabs">
            <li class="c-auth-tabs__item"><span class="c-auth-tabs__text">Kasutajanimi</span></li>
            <li class="c-auth-tabs__item"><a href="{{ route('facebook.redirect') }}" class="c-auth-tabs__link m-facebook">Facebook</a></li>
            <li class="c-auth-tabs__item"><a href="{{ route('google.redirect') }}" class="c-auth-tabs__link m-google">Google</a></li>
        </ul>

        <div class="r-auth__content-inner">

            {!! Form::open(['route' => 'login.submit']) !!}

                {!! Honeypot::generate('full_name', 'time') !!}

                <div class="c-form__group">
                    {!! Form::label('name', trans('auth.login.field.name.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::text('name', null, [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::label('password', trans('auth.login.field.password.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::password('password', [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>

                <div class="c-form__group m-small-margin">
                    {{ Form::checkbox('remember', 1, null, [
                        'class' => 'c-form__input m-checkbox',
                        'id' => 'remember'
                    ]) }}

                    {!! Form::label('remember', trans('auth.login.field.remember.title'),[
                        'class' => 'c-form__label m-checkbox'
                    ]) !!}
                </div>

                <div class="c-form__group">
                    {!! Form::submit(trans('auth.login.submit.title'), [
                        'class' => 'c-button m-large m-block'
                    ]) !!}
                </div>

            {!! Form::close() !!}

        </div>

        <div class="r-auth__content-footer">

            <div class="c-auth-footer">

                <p class="c-auth-footer__text">
                    {!! trans('auth.reset.apply.title') !!}
                    <a href="{{ route('reset.apply.form') }}" class="c-auth-footer__link">{{ trans('auth.reset.apply.title.link') }}</a></p>

            </div>
        </div>

        {{--

        <div class="c-form__group">
            @include('component.link', [
                'title' => trans('auth.login.facebook.title'),
                'route' => route('facebook.redirect')
            ])
        </div>

        <div class="c-form__group">
            @include('component.link', [
                'title' => trans('auth.login.google.title'),
                'route' => route('google.redirect')
            ])
        </div>

        --}}

    </div>

</div>

@stop

@section('footer')

    @include('component.footer')

@stop