@extends('layouts.one_column')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content.one')

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
        'modifiers' => 'm-image',
        'profile' => [
            'modifiers' => '',
            'image' => $content->user->imagePreset(),
            'route' => route('user.show', [$content->user])
        ],
        'title' => $content->title,
        'text' => view('component.content.text', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()]),
        'body' => $content->body_filtered
    ])

    </div>
    
    @include('component.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop
