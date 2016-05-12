@extends('layouts.main')

@section('title', (Auth::check() ? trans('error.401.title.logged') : trans('error.401.title.unlogged')))

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')
    @include('component.masthead', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

    <div class="l-one-column">
        @include('component.card', [
            'text' => str_replace("\n", "<br>", (Auth::check() ? trans('error.401.body.logged') : trans('error.401.body.unlogged'))),
            'modifiers' => 'm-blue',
        ])
    </div>

@stop
