@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header.right')
    @include('component.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')
    
    <div class="utils-border-bottom">

        @include('component.filter')

    </div>

    @foreach ($contents as $content)

        <div class="utils-border-bottom">

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

