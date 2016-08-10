@extends('layouts.main')

@section('title', $title)

@section('header')

    @include('component.header')

@stop

@section('content')
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
     <div class="r-auth__content m-wide">
         <div class="r-auth__content-inner">
             {!! Form::model(isset($user) ? $user : null, [
                'url' => $url,
                'method' => isset($method) ? $method : 'post',
                'files' => true
             ]) !!}
             <h3 class="c-auth-title m-margin">{{ trans('user.edit.account.title') }}</h3>
             <div class="c-form__group">
                 {!! Form::label('name', trans('user.edit.field.name.title'), [
                     'class' => 'c-form__label'
                 ]) !!}
                 {!! Form::text('name', null, [
                     'class' => 'c-form__input',
                     'placeholder' => trans('user.edit.field.name.title')
                 ]) !!}
             </div>
             <div class="c-form__group">
                 {!! Form::label('email', trans('user.edit.field.email.title'), [
                     'class' => 'c-form__label'
                 ]) !!}
                 {!! Form::email('email', null, [
                     'class' => 'c-form__input',
                     'placeholder' => trans('user.edit.field.email.title')
                 ]) !!}
             </div>
             <div class="c-form__group">
                 {!! Form::label('password', trans('user.edit.field.password.title'), [
                     'class' => 'c-form__label'
                 ]) !!}
                 {!! Form::password('password', [
                     'class' => 'c-form__input',
                     'placeholder' => trans('user.edit.field.password.title')
                 ]) !!}
             </div>
             <div class="c-form__group">
                 {!! Form::label('password_confirmation', trans('user.edit.field.password_confirmation.title'), [
                     'class' => 'c-form__label'
                 ]) !!}
                 {!! Form::password('password_confirmation', [
                     'class' => 'c-form__input',
                     'placeholder' => trans('user.edit.field.password_confirmation.title')
                 ]) !!}
             </div>

             <h3 class="c-auth-title m-margin">{{ trans('user.edit.general.title') }}</h3>
             <div class="c-form__group m-small-margin">
                 {!! Form::label('real_name', trans('user.edit.field.real.name.title'), [
                     'class' => 'c-form__label'
                 ]) !!}
                 {!! Form::text('real_name', null, [
                     'class' => 'c-form__input'
                 ]) !!}
             </div>
             <div class="c-form__group">
                 {{ Form::checkbox('real_name_show', 0, ($user->real_name_show == 0 ? true : false), [
                     'class' => 'c-form__input m-checkbox',
                     'id' => 'noname'
                 ]) }}

                 {!! Form::label('noname', trans('user.edit.field.real.name.show.title'),[
                     'class' => 'c-form__label m-checkbox'
                 ]) !!}
             </div>

             {{--
             <div class="c-form__group">
                 <div class="c-columns m-2-cols m-space">
                     <div class="c-columns__item m-mobile-margin">
                         {!! Form::label('gender', trans('user.edit.choose.gender'), [
                             'class' => 'c-form__label'
                         ]) !!}
                         <div class="c-columns m-2-cols m-space">
                             <div class="c-columns__item m-middle">
                                 {{ Form::radio('gender', 1, null, [
                                     'class' => 'c-form__input m-radio',
                                     'id' => 'gender1'
                                 ]) }}
                                 {!! Form::label('gender1', trans('user.gender.1'),[
                                     'class' => 'c-form__label m-radio'
                                 ]) !!}
                             </div>
                             <div class="c-columns__item m-middle">
                                 {{ Form::radio('gender', 2, null, [
                                     'class' => 'c-form__input m-radio',
                                     'id' => 'gender2'
                                 ]) }}
                                 {!! Form::label('gender2', trans('user.gender.2'),[
                                     'class' => 'c-form__label m-radio'
                                 ]) !!}
                             </div>
                         </div>
                     </div>
                     <div class="c-columns__item">
                         {!! Form::label('birth_date', trans('user.edit.field.birthyear.title'), [
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

             --}}

             <div class="c-form__group">
                 {!! Form::label('description', trans('user.edit.field.description.label'), [
                     'class' => 'c-form__label'
                 ]) !!}
                 {!! Form::textarea('description', null, [
                     'class' => 'c-form__input m-high',
                     'placeholder' => trans('user.edit.field.description.title')
                 ]) !!}
             </div>

             <h3 class="c-auth-title m-margin">{{ trans('user.edit.notify.title') }}</h3>
             <div class="c-form__group">
                 {{ Form::checkbox('notify_message', 1, null, [
                     'class' => 'c-form__input m-checkbox',
                     'id' => 'notify_message_label'
                 ]) }}

                 {!! Form::label('notify_message_label', trans('user.edit.field.notify_message.title'),[
                     'class' => 'c-form__label m-checkbox'
                 ]) !!}
             </div>
             {{--
             <div class="c-form__group">
                 {{ Form::checkbox('notify_follow', 1, null, [
                     'class' => 'c-form__input m-checkbox',
                     'id' => 'notify_follow_label'
                 ]) }}

                 {!! Form::label('notify_follow_label', trans('user.edit.field.notify_follow.title'),[
                     'class' => 'c-form__label m-checkbox'
                 ]) !!}
             </div>
            --}}
             <h3 class="c-auth-title m-margin">{{ trans('user.edit.contact.title') }}</h3>

             <div class="c-form__group m-small-margin">
                 <div class="c-columns m-2-cols m-first-smaller m-center">
                     <div class="c-columns__item">
                         {!! Form::label('contact_facebook', trans('user.edit.field.contact_facebook.title'), [
                             'class' => 'c-form__label'
                         ]) !!}
                     </div>
                     <div class="c-columns__item">
                         {!! Form::text('contact_facebook', null, [
                             'class' => 'c-form__input'
                         ]) !!}
                     </div>
                 </div>
             </div>

             <div class="c-form__group m-small-margin">
                 <div class="c-columns m-2-cols m-first-smaller m-center">
                     <div class="c-columns__item">
                         {!! Form::label('contact_instagram', trans('user.edit.field.contact_instagram.title'), [
                             'class' => 'c-form__label'
                         ]) !!}
                     </div>
                     <div class="c-columns__item">
                         {!! Form::text('contact_instagram', null, [
                             'class' => 'c-form__input'
                         ]) !!}
                     </div>
                 </div>
             </div>

             <div class="c-form__group m-small-margin">
                 <div class="c-columns m-2-cols m-first-smaller m-center">
                     <div class="c-columns__item">
                         {!! Form::label('contact_twitter', trans('user.edit.field.contact_twitter.title'), [
                             'class' => 'c-form__label'
                         ]) !!}
                     </div>
                     <div class="c-columns__item">
                         {!! Form::text('contact_twitter', null, [
                             'class' => 'c-form__input'
                         ]) !!}
                     </div>
                 </div>
             </div>

             <div class="c-form__group m-large-margin">
                 <div class="c-columns m-2-cols m-first-smaller m-center">
                     <div class="c-columns__item">
                         {!! Form::label('contact_homepage', trans('user.edit.field.contact_homepage.title'), [
                             'class' => 'c-form__label'
                         ]) !!}
                     </div>
                     <div class="c-columns__item">
                         {!! Form::text('contact_homepage', null, [
                             'class' => 'c-form__input'
                         ]) !!}
                     </div>
                 </div>
             </div>
             {{--
             <div class="c-form__group">
                 <h3 class="c-auth-title">{{ trans('user.edit.profile_color.title') }}</h3>
                 <p class="c-form__note">{{ trans('user.edit.profile_color.description') }}</p>

                 @foreach (['m-yellow', 'm-green', 'm-blue', 'm-purple', 'm-red', 'm-orange'] as $color)
                     <div class="c-form__group m-inline">
                         {!! Form::label('color-'.$color, '', [
                             'class' => 'c-form__label m-color '.$color
                         ]) !!}
                         {{ Form::radio('profile_color', $color, null, [
                             'class' => 'c-form__input m-radio',
                             'id' => 'color-'.$color
                         ]) }}
                     </div>
                 @endforeach
             </div>
             --}}

             <div class="c-form__group">
                 {!! Form::submit($submit, [
                     'class' => 'c-button m-large m-block'
                 ]) !!}
             </div>
             {!! Form::close() !!}

             <div class="c-form__group m-large-margin">
                 <div class="c-columns m-2-cols m-last-smaller m-space">
                     <div class="c-columns__item">
                         <h3 class="c-auth-title">{{ trans('user.image.title') }}</h3>
                         {{--<p class="c-form__note">{{ trans('user.image.description') }}</p>--}}
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

                     <div class="c-columns__item">
                         @include('component.user.image', [
                            'image' => $user->imagePreset('small_square') . '?' . str_random(4),
                            'modifiers' => 'm-full m-center',
                        ])
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
@stop

@section('footer')
    @include('component.footer')
@stop
