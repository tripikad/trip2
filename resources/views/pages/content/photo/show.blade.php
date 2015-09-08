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

    @if($image = $content->images()->first())
        
        <div class="utils-padding-bottom">

        @include('component.card', [
            'image' => $content->imagePreset('large'),
            'options' => '-noshade'
        ])

        </div>

    @endif

    @include('component.row', [
        'image' => $content->user->imagePreset(),
        'image_link' => route('user.show', [$content->user]),
        'heading' => $content->title,
        'text' => view('component.content.text', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()])
    ])

    <div class="row">

        <div class="col-sm-1">
        </div>

        <div class="col-sm-10">

            {!! $content->body_filtered !!}

        </div>

    </div>
    
    </div>
    
    @include('component.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop