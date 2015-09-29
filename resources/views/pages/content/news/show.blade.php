@extends('layouts.main')

@section('title')
 
    {{ trans("content.$type.index.title") }}

@stop

@section('header1.image')

    {{ $content->imagePreset('large') }}

@stop

@section('content')

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
        'extra' => view('component.flags', ['flags' => $content->getFlags()])
    ])

    <div class="row utils-border-bottom">

        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">

            {!! $content->body_filtered !!}

        </div>

    </div>

    <div class="utils-border-bottom">

        @include('component.comment.index', ['comments' => $comments])

    </div>

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop