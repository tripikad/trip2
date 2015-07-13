@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header.left')
    @include('components.placeholder', [
        'text' => trans('content.index.filter')
    ])
@stop

@section('header.right')
    @include('components.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')

    @foreach ($contents as $content)

        @include('components.row', [
            'image' => $content->user->imagePath(),
            'image_link' => route('user.show', [$content->user]),
            'heading' => $content->title,
            'heading_link' => route('content.show', [$content->type, $content]),
            'text' => trans("content.$type.index.row.text", [
                'user' => view('components.user.link', ['user' => $content->user]),
                'created_at' => $content->created_at->format('d. m Y H:i:s'),
                'updated_at' => $content->updated_at->format('d. m Y H:i:s'),
                'destinations' => $content->destinations->implode('name', ','),
                'tags' => $content->topics->implode('name', ','),
            ])
        ])
        
        <hr />

    @endforeach

  {!! $contents->render() !!}

@stop