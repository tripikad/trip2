@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
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
        'text' => view("component.content.text", ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()])
    ])

    <div class="row">

        <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">

            {!! $content->body_filtered !!}

        </div>
        
    </div>

    </div>

    <div class="utils-border-bottom">    
    
        @include('component.comment.index', ['comments' => $comments])

    </div>

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop