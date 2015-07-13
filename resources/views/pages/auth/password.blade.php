@extends('layouts.narrow')

@section('title')
    {{ trans('auth.password.title') }}
@stop

@section('content')

    {!! Form::open(array('url' => '/password/email')) !!}

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.password.field.email.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('auth.password.submit.title'), [
                'class' => 'btn btn-primary btn-lg btn-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

@stop