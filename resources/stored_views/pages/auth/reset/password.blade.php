@extends('layouts.one_column')

@section('title')
    {{ trans('auth.reset.password.title') }}
@stop

@section('content.one')

    {!! Form::open(['route' => 'reset.password.submit']) !!}

        {!! Form::hidden('token', $token) !!}

        <div class="c-form__group">
            {!! Form::label('email', trans('auth.reset.password.field.email.title'), [
                'class' => 'c-form__label'
            ]) !!}
            {!! Form::email('email', null, [
                'class' => 'c-form__input'
            ]) !!}
        </div>

        <div class="c-form__group">
            {!! Form::label('password', trans('auth.reset.password.field.password.title'), [
                'class' => 'c-form__label'
            ]) !!}
            {!! Form::password('password', [
                'class' => 'c-form__input'
            ]) !!}
        </div>

        <div class="c-form__group">
            {!! Form::label('password_confirmation', trans('auth.reset.password.field.password_confirmation.title'), [
                'class' => 'c-form__label'
            ]) !!}
            {!! Form::password('password_confirmation', [
                'class' => 'c-form__input'
            ]) !!}
        </div>

        <div class="c-form__group">
            {!! Form::submit(trans('auth.reset.password.submit.title'), [
                'class' => 'c-button m-large m-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

@stop
