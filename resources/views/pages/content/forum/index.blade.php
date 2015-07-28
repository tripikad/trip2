@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header.right')
    @include('components.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')
    
    <div class="utils-border-bottom">

        @include('components.filter')

    </div>

    @foreach ($contents as $content)

        <div class="utils-border-bottom">

        @include('components.row', [
            'image' => $content->user->imagePath(),
            'image_link' => route('user.show', [$content->user]),
            'heading' => $content->title,
            'heading_link' => route('content.show', [$content->type, $content->id]),
            'text' => trans("content.$type.index.row.text", [
                'user' => view('components.user.link', ['user' => $content->user]),
                'created_at' => $content->created_at->diffForHumans(),
                'updated_at' => $content->updated_at->diffForHumans(),
                'destinations' => $content->destinations->implode('name', ','),
                'tags' => $content->topics->implode('name', ','),
            ])
        ])
        
        </div>

    @endforeach

  {!! $contents->render() !!}

@stop