@extends('layouts.main')

@section('title', trans('auth.reset.apply.title'))

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
                'subtitle' => 'Sisesta oma e-mail ja me saadame sulle kinnituslingi'
            ])
        </div>
    </div>

    <div class="r-auth__content">
        <div class="r-auth__content-inner">
            {!! Form::open(['route' => 'reset.apply.submit']) !!}

                {!! Honeypot::generate('full_name', 'time') !!}

                <div class="c-form__group">
                    {!! Form::label('email', trans('auth.reset.apply.field.email.title'), [
                        'class' => 'c-form__label'
                    ]) !!}
                    {!! Form::email('email', null, [
                        'class' => 'c-form__input'
                    ]) !!}
                </div>
                <div class="c-form__group">
                    {!! Form::submit(trans('auth.reset.apply.submit.title'), [
                        'class' => 'c-button m-large m-block'
                    ]) !!}
                </div>
            {!! Form::close() !!}
        </div>

        <div class="r-auth__content-footer">
            <div class="c-auth-footer">
                <p class="c-auth-footer__text">Tuli meelde? <a href="{{ route('login.form') }}" class="c-auth-footer__link">Logi sisse siit</a>.</p>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')
    @include('component.footer')
@stop
