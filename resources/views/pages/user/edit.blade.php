@extends('layouts.narrow')

@section('title')
    {{ $title }}
@stop

@section('header.top')
    
    @include('components.image.circle', [
        'image' => $user->imagePath(),
        'width' => '30%'
    ])

    {!! Form::model(isset($user) ? $user : null, [
        'url' => $url,
        'method' => isset($method) ? $method : 'post'
    ]) !!}

    <div class="form-group">

    @if (! $user->image)
        {!! Form::submit(trans('user.image.create.title'), [
            'name' => 'submit_image',
            'class' => 'btn btn-primary btn-lg'
        ]) !!}
    @else 
        {!! Form::submit(trans('user.image.edit.title'), [
            'name' => 'submit_image',
            'class' => 'btn btn-link'
        ]) !!}
    @endif

    </div>

@stop

@section('content.narrow')
        
        <h3 style="margin: 1.5em 0 1em 0; text-align:center;">{{ trans('user.edit.contact.title') }}</h3>

        @include('components.placeholder', ['text' => 'Facebook link field'])

        @include('components.placeholder', ['text' => 'Instagram link field'])

        @include('components.placeholder', ['text' => 'Twitter link field'])

        @include('components.placeholder', ['text' => 'Homepage link field?'])

        <h3 style="margin: 2em 0 1em 0; text-align:center;">{{ trans('user.edit.account.title') }}</h3>

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
                'placeholder' => trans('user.edit.field.password.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::password('password_confirmation', [
                'class' => 'form-control input-lg',
                'placeholder' => trans('user.edit.field.password_confirmation.title')
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit($submit, [
                'class' => 'btn btn-primary btn-lg btn-block
            ']) !!}
        </div>

    {!! Form::close() !!}

@stop