@extends('layouts.two_column')

@section('title')

    {{ $content->title }}

@stop

@section('header1.image')

    @if($content->images())

        {{ $content->imagePreset('large') }}

    @endif

@stop

@section('content.one')

    <div class="utils-border-bottom 
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

    @include('component.row', [
        'profile' => [
            'modifiers' => '',
            'image' => $content->user->imagePreset(),
            'route' => route('user.show', [$content->user])
        ],
        'text' => view('component.content.text', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()]),
        'body' => $content->body_filtered,
        'modifiers' => '-centered'
    ])

    </div>

    @include('component.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop
