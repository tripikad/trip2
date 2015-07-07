@extends('layouts.form.narrow')

@section('title')
    Reset password
@stop

@section('form')

    {!! Form::open(array('url' => '/password/email')) !!}

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'E-mail'
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
        </div>

    {!! Form::close() !!}

@stop