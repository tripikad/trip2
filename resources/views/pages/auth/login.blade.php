@extends('layouts.one_column')

@section('title')
    {{ trans('auth.login.title') }}
@stop

@section('content.one')

    {!! Form::open(['route' => 'login.submit']) !!}

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

        <div class="c-form__group">
            {!! Form::checkbox('remember') !!}
            {!! Form::label('remember', trans('auth.login.field.remember.title')) !!}
        </div>

        <div class="c-form__group">
            {!! Form::submit(trans('auth.login.submit.title'), [
                'class' => 'c-button m-large m-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

    <div class="c-form__group">
        @include('component.link', [
            'title' => trans('auth.reset.apply.title'),
            'route' => route('reset.apply.form')
        ])
    </div>

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

@stop
