@extends('layouts.narrow')

@section('title')
    {{ trans('auth.login.title') }}
@stop


@stop

@section('content.narrow')

    {!! Form::open(['route' => 'login.submit']) !!}

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

    <div class="row utils-padding-bottom">

        <div class="col-sm-6 text-center">

            @include('component.button', [ 
                'route' => route('register.form'),
                'title' => trans('auth.login.register.title'),
                'buttontype' => 'btn-link'
            ])
        
        </div>

        <div class="col-sm-6 text-center">

            @include('component.button', [ 
                'route' => route('reset.apply.form'),
                'title' => trans('auth.login.reset.title'),
                'buttontype' => 'btn-link'
            ])

        </div>

    </div>

@stop