@extends('layouts.narrow')

@section('title')
    {{ trans('auth.reset.apply.title') }}
@stop

@section('content.narrow')

    {!! Form::open(['route' => 'reset.apply.submit']) !!}

        <div class="form-group">
            {!! Form::email('email', null, [
                'class' => 'form-control input-lg',
                'placeholder' => trans('auth.reset.apply.field.email.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('auth.reset.apply.submit.title'), [
                'class' => 'btn btn-primary btn-lg btn-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

@stop