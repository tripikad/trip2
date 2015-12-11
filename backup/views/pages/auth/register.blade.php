@extends('layouts.one_column')

@section('title')
    {{ trans('auth.register.title') }}
@stop

@section('content.one')

    {!! Form::open(['route' => 'register.submit']) !!}

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
            {!! Form::checkbox('eula', 1) !!}
            {!! trans('auth.register.field.eula.title', [
                'link' => '<a href="' . route('content.show', ['static', 25151]) . '">' . trans('auth.register.field.eula.title.link'). '</a>'
            ]) !!}
        </div>

        <div class="c-form__group">
            {!! Form::submit(trans('auth.register.submit.title'), [
                'class' => 'c-button m-large m-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

@stop