@extends('layouts.one_column')

@section('title')
    {{ trans('auth.reset.apply.title') }}
@stop

@section('content.one')

    {!! Form::open(['route' => 'reset.apply.submit']) !!}

        <div class="c-form__group">
            {!! Form::label('email', trans('auth.reset.apply.field.email.title'), [
                'class' => 'c-form__label'
            ]) !!}
            {!! Form::email('email', null, [
                'class' => 'c-form__input'
            ]) !!}
        </div>

        <div class="c-form__group">
            {!! Form::submit(trans('auth.reset.apply.submit.title'), [
                'class' => 'c-button m-large m-block'
            ]) !!}
        </div>

    {!! Form::close() !!}

@stop
