@extends('layouts.main')

@section('title')
    {{ trans('admin.content.index.title') }}
@stop

@section('header2.content')

    @include('component.menu', [
        'menu' => 'admin',
        'items' => config('menu.admin')
    ])
        
@stop

@section('content')
    
    @foreach ($contents as $content)

        <div class="utils-border-bottom utils-unpublished">

        @include('component.row', [
            'image' => $content->user->imagePreset(),
            'image_link' => route('user.show', [$content->user]),
            'heading' => $content->title,
            'heading_link' => route('content.show', [$content->type, $content->id]),
            'description' => view('component.content.description', ['content' => $content])
        ])
        
        </div>

    @endforeach

  {!! $contents->render() !!}

@stop