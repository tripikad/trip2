@extends('layouts.one_column')

@section('title')
    {{ $title }}
@stop

@section('header1.top')
    
    <div class="row">

        <div class="col-xs-offset-5 col-xs-2 utils-padding-bottom">

        @include('component.user.image', [
            'image' => $user->imagePreset('small_square') . '?' . str_random(4),
            'options' => '-circle -large',
        ])

        </div>

    </div>

    {!! Form::model(isset($user) ? $user : null, [
        'url' => $url,
        'method' => isset($method) ? $method : 'post',
        'files' => true
    ]) !!}

    {!! Form::file('file') !!}

    {!! Form::submit('Submit', ['name' => 'image_submit']) !!}

    <div class="form-group">

        @if (! $user->image)

        <a href="" id="image_link" class="btn btn-primary btn-md">
            {{ trans('user.image.create.title') }}
        </a>
        
        @else 

        <a href="" id="image_link" class="btn btn-link">
            {{ trans('user.image.edit.title') }}
        </a>

        @endif

    </div>

@stop

@section('content.one')
    
    <div class="row">

        <div class="col-sm-4 utils-padding-right">

            <div class="form-group">

                @include('component.subheader', [
                    'title' => trans('user.edit.account.title'),
                    'options' => '-orange'
                ])

            </div>

            <div class="form-group">
                
                {!! Form::text('name', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.name.title')
                ]) !!}
            
            </div>

            <div class="form-group">
           
                {!! Form::email('email', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.email.title')
                ]) !!}
           
            </div>

            <div class="form-group">
       
                {!! Form::password('password', [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.password.title')
                ]) !!}
       
            </div>

            <div class="form-group">
       
                {!! Form::password('password_confirmation', [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.password_confirmation.title')
                ]) !!}
       
            </div>

        </div>

        <div class="col-sm-4 utils-padding-right">

            <div class="form-group">

                @include('component.subheader', [
                    'title' => trans('user.edit.contact.title'),
                    'options' => '-orange'
                ])

            </div>

            <div class="form-group">

                {!! Form::url('contact_facebook', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.contact_facebook.title')
                ]) !!}
            
            </div>

            <div class="form-group">

                {!! Form::url('contact_twitter', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.contact_twitter.title')
                ]) !!}

            </div>

            <div class="form-group">

                {!! Form::url('contact_instagram', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.contact_instagram.title')
                ]) !!}

            </div>

            <div class="form-group">

                {!! Form::url('contact_homepage', null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans('user.edit.field.contact_homepage.title')
                ]) !!}

            </div>

        </div>

        <div class="col-sm-4">

            <div class="form-group">

                @include('component.subheader', [
                    'title' => trans('user.edit.notify.title'),
                    'options' => '-orange'
                ])

            </div>

            <div class="form-group">

                <div class="row">
                
                    <div class="col-xs-1">

                        {!! Form::checkbox('notify_message') !!}

                    </div>

                    <div class="col-xs-11">

                        {!! trans('user.edit.field.notify_message.title') !!}

                    </div>

                </div>

            </div>

            <div class="form-group">

                <div class="row">
                
                    <div class="col-xs-1">
                        
                        {!! Form::checkbox('notify_follow') !!}

                    </div>

                    <div class="col-xs-11">
                    
                        {!! trans('user.edit.field.notify_follow.title') !!}
                
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">
        
        <div class="col-sm-3 col-sm-offset-9">

            <div class="form-group">

            {!! Form::submit($submit, [
                'class' => 'btn btn-primary btn-lg btn-block
            ']) !!}

            </div>

        </div>

    </div>

    {!! Form::close() !!}

@stop