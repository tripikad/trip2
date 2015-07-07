@extends('layouts.form.narrow')

@section('title')
    Login
@stop

@section('form')

    {!! Form::open(array('url' => '/auth/login')) !!}

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'E-mail'
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password', [
                'class' => 'form-control input-lg',
                'placeholder' => 'Password
            ']) !!}
        </div>

        <div class="form-group">
            {!! Form::checkbox('remember') !!}
            {!! Form::label('remember', 'Remember me') !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Login', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
        </div>

    {!! Form::close() !!}

@stop