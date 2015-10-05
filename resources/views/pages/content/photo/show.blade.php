@extends('layouts.medium')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content.medium')

    <div class="utils-border-bottom 
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

    @if($image = $content->images()->first())
        
        <div class="utils-padding-bottom">

            <img src="{{ $content->imagePreset('large') }}" />

        </div>

    @endif

    @include('component.row', [
        'image' => $content->user->imagePreset(),
        'image_link' => route('user.show', [$content->user]),
        'heading' => $content->title,
        'description' => view('component.content.description', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()]),
        'body' => $content->body_filtered,
        'options' => '-narrow'
    ])

    </div>
    
    @include('component.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop