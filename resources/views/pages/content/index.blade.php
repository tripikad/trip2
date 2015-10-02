@extends('layouts.twocol')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header1.right')
    
    @include('component.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])

@stop

@section('navbar.bottom')

    <div class="utils-border-bottom">
            
        @include('component.menu', [
            'menu' => 'forum',
            'items' => config('menu.forum')
        ])
        
    </div>

@stop

@section('header4')
    
    <div class="utils-border-bottom">

        @include('component.filter')

    </div>

@stop

@section('content.left')

    @foreach ($contents as $content)

        <div class="utils-padding-bottom">

        @include('component.row', [
            'image' => $content->user->imagePreset(),
            'image_link' => route('user.show', [$content->user]),
            'heading' => $content->title,
            'heading_link' => route('content.show', [$content->type, $content->id]),
            'description' => view('component.content.description', ['content' => $content]),
            'extra' => view('component.content.number', [
                'number' => count($content->comments)
            ]),
        ])
        
        </div>

    @endforeach

  {!! $contents->render() !!}

@stop