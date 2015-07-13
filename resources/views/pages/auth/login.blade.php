@extends('layouts.narrow')

@section('title')
    {{ trans('auth.login.title') }}
@stop

@section('content.narrow')

    {!! Form::open(array('url' => '/auth/login')) !!}

        <div class="form-group">
            {!! Form::text('name', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.login.field.name.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password', [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.login.field.password.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::checkbox('remember') !!}
            {!! Form::label('remember', trans('auth.login.field.remember.title')) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('auth.login.submit.title'), [
                'class' => 'btn btn-primary btn-lg btn-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

@stop