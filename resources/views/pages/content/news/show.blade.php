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
        'image' => $content->user->imagePreset(),
        'image_link' => route('user.show', [$content->user]),
        'description' => view('component.content.description', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()]),
        'body' => $content->body_filtered,
        'options' => '-centered'
    ])

    </div>

    @include('component.comment.index', ['comments' => $content->comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop