@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-travelmates m-single">

    <div class="r-travelmates__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getRandom()
        ])
    </div>

    <div class="r-travelmates__wrap">

        <div class="r-travelmates__content">

            @include('component.row', [
                'profile' => [
                    'modifiers' => '',
                    'image' => $content->user->imagePreset(),
                    'route' => route('user.show', [$content->user])
                ],
                'modifiers' => 'm-image',
                'title' => $content->title,
                'text' => view('component.content.text', ['content' => $content]),
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                'body' => $content->body_filtered,
            ])

            @include('component.comment.index', ['comments' => $comments])

            @if (\Auth::check())

                @include('component.comment.create')

            @endif

        </div>

        <div class="r-travelmates__sidebar">

        </div>

    </div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop