@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('navbar.bottom')

    <div class="utils-border-bottom">
            
        @include('component.menu', [
            'menu' => 'forum',
            'items' => config('menu.forum')
        ])
        
    </div>

@stop

@section('header.right')
    @include('component.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')
    
    @foreach ($contents as $content)

        <div class="utils-border-bottom">

        @include('component.row', [
            'image' => $content->user->imagePreset(),
            'image_link' => route('user.show', [$content->user]),
            'heading' => $content->title,
            'heading_link' => route('content.show', [$content->type, $content->id]),
            'text' => trans("content.$type.index.row.text", [
                'user' => view('component.user.link', ['user' => $content->user]),
                'created_at' => $content->created_at->diffForHumans(),
            ]),
            'extra' => view('component.number', [
                'number' => count($content->comments),
                'options' => '-inverted'
            ]),
            'options' => '-small'
        ])
        
        </div>

    @endforeach

  {!! $contents->render() !!}

@stop