@extends('layouts.narrow')

@section('title')
    {{ trans('auth.register.title') }}
@stop

@section('content.narrow')

    {!! Form::open(['route' => 'register.submit']) !!}

        <div class="form-group">
            {!! Form::text('name', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.register.field.name.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.register.field.email.title')
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
            {!! Form::checkbox('eula', false) !!}            
            {!! trans('auth.register.field.eula.title', [
                'link' => '<a href="' . route('content.show', ['static', 25151]) . '">' . trans('auth.register.field.eula.title.link'). '</a>'
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('auth.register.submit.title'), [
                'class' => 'btn btn-primary btn-lg btn-block
            ']) !!}
        </div>

    {!! Form::close() !!}

@stop