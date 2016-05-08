@extends('layouts.main')

@section('title', $title)

@section('header')

    @include('component.header')

@stop

@section('content')

<?php /*     <div class="r-user-edit__content-wrap">

        <div class="r-user-edit__content">

            {!! Form::model(isset($user) ? $user : null, [
                'url' => $url,
                'method' => isset($method) ? $method : 'post',
                'files' => true
            ]) !!}

            <div class="c-columns m-2-cols m-space">
                <div class="c-columns__item">
                    <div class="c-form__group">
                        @include('component.title', [
                            'title' => trans('user.edit.account.title'),
                            'modifiers' => 'm-orange'
                        ])
                    </div>
                    <div class="c-form__group">
                        {!! Form::text('name', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.name.title')
                        ]) !!}
                    </div>
                    <div class="c-form__group">
                        {!! Form::email('email', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.email.title')
                        ]) !!}
                    </div>
                    <div class="c-form__group">
                        {!! Form::password('password', [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.password.title')
                        ]) !!}
                    </div>
                    <div class="c-form__group">
                        {!! Form::password('password_confirmation', [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.password_confirmation.title')
                        ]) !!}
                    </div>
                </div>
                <div class="c-columns__item">
                    <div class="c-form__group">
                        @include('component.title', [
                            'title' => trans('user.edit.contact.title'),
                            'modifiers' => 'm-orange'
                        ])
                    </div>
                    <div class="c-form__group">
                        {!! Form::url('contact_facebook', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.contact_facebook.title')
                        ]) !!}
                    </div>
                    <div class="c-form__group">
                        {!! Form::url('contact_twitter', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.contact_twitter.title')
                        ]) !!}
                    </div>
                    <div class="c-form__group">
                        {!! Form::url('contact_instagram', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.contact_instagram.title')
                        ]) !!}
                    </div>
                    <div class="c-form__group">
                        {!! Form::url('contact_homepage', null, [
                            'class' => 'c-form__input',
                            'placeholder' => trans('user.edit.field.contact_homepage.title')
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="c-form__group">
                @include('component.title', [
                    'title' => trans('user.edit.general.title'),
                    'modifiers' => 'm-orange'
                ])
            </div>
            <div class="c-form__group">
                {!! Form::text('real_name', null, [
                    'class' => 'c-form__input',
                    'placeholder' => trans('user.edit.field.real.name.title')
                ]) !!}
            </div>
            <div class="c-form__group">
                <div class="c-form__label">
                    {{ trans('user.edit.choose.gender') }}
                </div>

                {!! Form::radio('gender', '1', null, [
                    'id' => 'gender1'
                ]) !!}

                {!! Form::label('gender1', trans('user.gender.1')) !!}

                {!! Form::radio('gender', '2', null, [
                    'id' => 'gender2'
                ]) !!}

                {!! Form::label('gender2', trans('user.gender.2')) !!}

            </div>
            <div class="c-form__group">
                <div class="c-form__label">
                    {{ trans('user.edit.field.birthyear.title') }}
                </div>
                @include('component.date.select', [
                    'from' => \Carbon\Carbon::parse('-100 years')->year,
                    'to' => \Carbon\Carbon::now()->year,
                    'selected' => $user->birthyear ? $user->birthyear : \Carbon\Carbon::parse('-30 years')->year,
                    'key' => 'birthyear'
                ])
            </div>
            <div class="c-form__group">
                {!! Form::textarea('description', null, [
                    'class' => 'c-form__input m-high',
                    'placeholder' => trans('user.edit.field.description.title')
                ]) !!}
            </div>
            <div class="c-form__group">
                @include('component.title', [
                    'title' => trans('user.edit.notify.title'),
                    'modifiers' => 'm-orange'
                ])
            </div>
            <div class="c-form__group">
                {!! Form::checkbox('notify_message') !!}
                {!! trans('user.edit.field.notify_message.title') !!}
            </div>
            <div class="c-form__group">
                {!! Form::checkbox('notify_follow') !!}
                {!! trans('user.edit.field.notify_follow.title') !!}
            </div>
            <div class="c-form__group">
                {!! Form::submit($submit, [
                    'class' => 'c-button m-large m-block'
                ]) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div class="r-user-edit__sidebar">
            <div class="r-user-edit__sidebar-block">
                <div class="r-user-edit__sidebar-block-inner">
                    <div class="c-form__group">
                        @include('component.user.image', [
                            'image' => $user->imagePreset('small_square') . '?' . str_random(4),
                            'modifiers' => 'm-full m-center',
                        ])
                    </div>
                    <div class="c-form__group">
                        @include('component.image.form', [
                            'form' => [
                                'url' => $url,
                                'method' => isset($method) ? $method : 'post',
                                'model' => isset($user) ? $user : null,
                                'files' => true
                            ],
                            'name' => 'image',
                            'maxFileSize' => 5,
                            'uploadMultiple' => false
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
 */?>

 <div class="r-auth">
     <div class="r-auth__map">
         <div class="c-auth-map">
             @include('component.svg.standalone', [
                 'name' => 'map'
             ])
         </div>
     </div>
     <div class="r-auth__header">
         <div class="r-auth__masthead">
             @include('component.auth.masthead')
         </div>
     </div>
     <div class="r-auth__notifications">
        <div class="c-alert m-success">
            <div class="c-alert__inner">Teretulemast tripikas Vaata veel üle allolev info, et kõik oleks tip-top ja siis liigume edasi</div>
        </div>
     </div>
     <div class="r-auth__content m-wide">
         <div class="r-auth__content-inner">
            <h3 class="c-auth-title m-margin">{{ trans('user.edit.general.title') }}</h3>
            <div class="c-form__group m-small-margin">
                {!! Form::label('name', trans('user.edit.field.real.name.title'), [
                    'class' => 'c-form__label'
                ]) !!}
                {!! Form::text('name', null, [
                    'class' => 'c-form__input'
                ]) !!}
            </div>
            <div class="c-form__group">
                {{ Form::checkbox('noname', 1, null, [
                    'class' => 'c-form__input m-checkbox',
                    'id' => 'remember'
                ]) }}

                {!! Form::label('noname', 'Ei soovi avalikustada oma nime',[
                    'class' => 'c-form__label m-checkbox'
                ]) !!}
            </div>
            <div class="c-form__group">
                <div class="c-columns m-2-cols m-space">
                    <div class="c-columns__item m-mobile-margin">
                        {!! Form::label('name', 'Sugu', [
                            'class' => 'c-form__label'
                        ]) !!}
                        <div class="c-columns m-2-cols m-space">
                            <div class="c-columns__item m-middle">
                                {{ Form::radio('sex', 1, null, [
                                    'class' => 'c-form__input m-radio',
                                    'id' => 'sex-1'
                                ]) }}
                                {!! Form::label('sex-1', 'Mees',[
                                    'class' => 'c-form__label m-radio'
                                ]) !!}
                            </div>
                            <div class="c-columns__item m-middle">
                                {{ Form::radio('sex', 1, null, [
                                    'class' => 'c-form__input m-radio',
                                    'id' => 'sex-2'
                                ]) }}
                                {!! Form::label('sex-2', 'Naine',[
                                    'class' => 'c-form__label m-radio'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="c-columns__item">
                        {!! Form::label('birth_date', 'Sünniaasta', [
                            'class' => 'c-form__label'
                        ]) !!}
                        <div class="c-form__group-select">
                            @include('component.date.select', [
                                'from' => \Carbon\Carbon::parse('-100 years')->year,
                                'to' => \Carbon\Carbon::now()->year,
                                'selected' => $user->birthyear ? $user->birthyear : \Carbon\Carbon::parse('-30 years')->year,
                                'key' => 'birthyear'
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <div class="c-form__group">
                {!! Form::label('description', 'Lühikirjeldus', [
                    'class' => 'c-form__label'
                ]) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'c-form__input m-high',
                    'placeholder' => 'Kirjelda tripikatele ennast ja oma reisikogemusi…'
                ]) !!}
            </div>

            <h3 class="c-auth-title m-margin">Kontaktinfo</h3>

            <div class="c-form__group m-small-margin">
                <div class="c-columns m-2-cols m-first-smaller m-center">
                    <div class="c-columns__item">
                        {!! Form::label('facebook', 'Facebook', [
                            'class' => 'c-form__label'
                        ]) !!}
                    </div>
                    <div class="c-columns__item">
                        {!! Form::text('facebook', null, [
                            'class' => 'c-form__input'
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="c-form__group m-small-margin">
                <div class="c-columns m-2-cols m-first-smaller m-center">
                    <div class="c-columns__item">
                        {!! Form::label('instagram', 'Instagram', [
                            'class' => 'c-form__label'
                        ]) !!}
                    </div>
                    <div class="c-columns__item">
                        {!! Form::text('instagram', null, [
                            'class' => 'c-form__input'
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="c-form__group m-small-margin">
                <div class="c-columns m-2-cols m-first-smaller m-center">
                    <div class="c-columns__item">
                        {!! Form::label('skype', 'Skype', [
                            'class' => 'c-form__label'
                        ]) !!}
                    </div>
                    <div class="c-columns__item">
                        {!! Form::text('skype', null, [
                            'class' => 'c-form__input'
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="c-form__group m-large-margin">
                <div class="c-columns m-2-cols m-first-smaller m-center">
                    <div class="c-columns__item">
                        {!! Form::label('homepage', 'Koduleht', [
                            'class' => 'c-form__label'
                        ]) !!}
                    </div>
                    <div class="c-columns__item">
                        {!! Form::text('homepage', null, [
                            'class' => 'c-form__input'
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="c-form__group m-large-margin">
                <div class="c-columns m-2-cols m-last-smaller m-space">
                    <div class="c-columns__item">
                        <h3 class="c-auth-title">Profiilipilt</h3>
                        <p class="c-form__note">Kuvatakse sinu profiili ning postituse juures</p>

                        @include('component.image.form', [
                            'form' => [
                                'url' => $url,
                                'method' => isset($method) ? $method : 'post',
                                'model' => isset($user) ? $user : null,
                                'files' => true,
                            ],
                            'id' => 'image',
                            'name' => 'image',
                            'maxFileSize' => 5,
                            'uploadMultiple' => false
                        ])
                    </div>

                    <div class="c-columns__item">
                        @include('component.svg.standalone', [
                            'name' => 'profile-user-image'
                        ])
                    </div>
                </div>
            </div>

            <div class="c-form__group m-large-margin">
                <div class="c-columns m-2-cols m-last-smaller m-space">
                    <div class="c-columns__item">

                        <h3 class="c-auth-title">Taustapilt</h3>

                        <p class="c-form__note">Kuvatakse sinu profiili päise taustana</p>


                        @include('component.image.form', [
                            'form' => [
                                'url' => $url,
                                'method' => isset($method) ? $method : 'post',
                                'model' => isset($user) ? $user : null,
                                'files' => true
                            ],
                            'id' => 'bg_image',
                            'name' => 'bg_image',
                            'maxFileSize' => 5,
                            'uploadMultiple' => false
                        ])


                    </div>

                    <div class="c-columns__item">

                        @include('component.svg.standalone', [
                            'name' => 'profile-user-head-image'
                        ])
                    </div>
                </div>
            </div>

            <div class="c-form__group">

                <h3 class="c-auth-title">Profiili värv</h3>

                <p class="c-form__note">Kuvatakse sinu profiili taustana</p>

                <div class="c-form__group m-inline">

                    {!! Form::label('color-yellow', 'Yellow', [
                        'class' => 'c-form__label m-color m-yellow'
                    ]) !!}

                    {{ Form::radio('color', 1, null, [
                        'class' => 'c-form__input m-radio',
                        'id' => 'color-yellow'
                    ]) }}
                </div>

                <div class="c-form__group m-inline">

                    {!! Form::label('color-green', 'Green', [
                        'class' => 'c-form__label m-color m-green'
                    ]) !!}

                    {{ Form::radio('color', 2, null, [
                        'class' => 'c-form__input m-radio',
                        'id' => 'color-green'
                    ]) }}
                </div>

                <div class="c-form__group m-inline">

                    {!! Form::label('color-blue', 'Blue', [
                        'class' => 'c-form__label m-color m-blue'
                    ]) !!}

                    {{ Form::radio('color', 3, null, [
                        'class' => 'c-form__input m-radio',
                        'id' => 'color-blue'
                    ]) }}
                </div>

                <div class="c-form__group m-inline">

                    {!! Form::label('color-purple', 'Purple', [
                        'class' => 'c-form__label m-color m-purple'
                    ]) !!}

                    {{ Form::radio('color', 4, null, [
                        'class' => 'c-form__input m-radio',
                        'id' => 'color-purple'
                    ]) }}
                </div>

                <div class="c-form__group m-inline">

                    {!! Form::label('color-red', 'Red', [
                        'class' => 'c-form__label m-color m-red'
                    ]) !!}

                    {{ Form::radio('color', 5, null, [
                        'class' => 'c-form__input m-radio',
                        'id' => 'color-red'
                    ]) }}
                </div>

                <div class="c-form__group m-inline">

                    {!! Form::label('color-orange', 'Orange', [
                        'class' => 'c-form__label m-color m-orange'
                    ]) !!}

                    {{ Form::radio('color', 6, null, [
                        'class' => 'c-form__input m-radio',
                        'id' => 'color-orange'
                    ]) }}
                </div>
            </div>

            <div class="c-form__group">
                {!! Form::submit('Edasi', [
                    'class' => 'c-button m-large m-block'
                ]) !!}
            </div>

         </div>
     </div>
 </div>
@stop

@section('footer')

    @include('component.footer')

@stop






















