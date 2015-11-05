@extends('layouts.two_column')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content.one')

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

@stop
