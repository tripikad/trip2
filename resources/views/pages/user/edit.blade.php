@extends('layouts.narrow')

@section('title')
    {{ $title }}
@stop

@section('content.narrow')

        {!! Form::model(isset($user) ? $user : null, [
            'url' => $url,
            'method' => isset($method) ? $method : 'post'
        ]) !!}

        <div class="form-group">
            {!! Form::text('image', null, [
                'class' => 'form-control input-lg',
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::text('name', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('user.edit.field.name.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('user.edit.field.email.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password', [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.register.field.password.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password_confirmation', [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.register.field.password_confirmation.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit($submit, [
                'class' => 'btn btn-primary btn-lg btn-block
            ']) !!}
        </div>

    {!! Form::close() !!}

@stop