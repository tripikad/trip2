@extends('layouts.form.narrow')

@section('title')
    Pick a new password
@stop

@section('form')

    {!! Form::open(array('url' => '/password/reset')) !!}

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
            {!! Form::password('password_confirmation', [
                'class' => 'form-control input-lg',
                'placeholder' => 'Confirm Password
            ']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
        </div>

    {!! Form::close() !!}

@stop