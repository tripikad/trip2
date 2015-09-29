@extends('layouts.main')

@section('title')
    
    {{ trans("content.$type.index.title") }}

@stop

@section('navbar.bottom')

    <div class="utils-border-bottom">
            
        @include('component.menu', [
            'menu' => 'admin',
            'items' => config('menu.admin')
        ])
        
    </div>

@stop

@section('header1.right')
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
            'description' => view('component.content.description', ['content' => $content]),
            'extra' => view('component.number', [
                'number' => count($content->comments),
                'options' => '-border'
            ])
        ])
        
        </div>

    @endforeach

  {!! $contents->render() !!}

@stop