@extends('layouts.twocol')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content.left')

    <div class="utils-border-bottom 
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

    @include('component.row', [
        'image' => $content->user->imagePreset(),
        'image_link' => route('user.show', [$content->user]),
        'heading' => $content->title,
        'description' => view('component.content.description', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()]),
        'body' => $content->body_filtered,
    ])

    </div>

    <div class="utils-border-bottom">    
    
        @include('component.comment.index', ['comments' => $comments])

    </div>

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop