@extends('layouts.one_column')

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

    @include('component.nav', [
        'menu' => 'news',
        'items' => config('menu.news')
    ])

@stop

@section('content.one')

    @foreach ($contents as $content)

        <div class="utils-border-bottom">

        @include('component.row', [
            'profile' => [
                'image' => $content->user->imagePreset(),
                'image_link' => route('user.show', [$content->user])
            ],
            'title' => $content->title,
            'route' => route('content.show', [$content->type, $content->id]),
            'text' => view('component.content.text', ['content' => $content])
        ])

        </div>

    @endforeach

  {!! $contents->render() !!}

@stop
