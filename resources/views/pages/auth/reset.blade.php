@extends('layouts.narrow')

@section('title')
    {{ trans('auth.reset.title') }}
@stop

@section('content.narrow')

    {!! Form::open(array('url' => '/password/reset')) !!}

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.reset.field.email.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password', [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.reset.field.password.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password_confirmation', [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.reset.field.password_confirmation.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('auth.reset.submit.title'), [
                'class' => 'btn btn-primary btn-lg btn-bloc
            ']) !!}
        </div>

    {!! Form::close() !!}

@stop