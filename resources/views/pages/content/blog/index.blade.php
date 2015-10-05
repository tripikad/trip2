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

@section('header2.content')

    @include('component.filter')

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
                'body' => $content->body_filtered,
            ])

        </div>
        
    @endforeach

  {!! $contents->render() !!}

@stop

