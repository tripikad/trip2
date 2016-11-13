@extends('layouts.one_column')

@section('title', trans('admin.content.index.title'))

@section('masthead.search')

    @include('component.nav', [
        'modifiers' => '',
        'menu' => 'admin',
        'items' => config('menu.admin')
    ])

@stop

@section('content.one')

    @foreach ($contents as $content)

        @include('component.row', [
            'modifiers' => 'm-image',
            'profile' => [
                'modifiers' => '',
                'image' => $content->user->imagePreset(),
                'route' => ($content->user->name != 'Tripi külastaja' ? route('user.show', [$content->user]) : false)
            ],
            'title' => $content->title,
            'route' => route('content.show', [$content->type, $content->id]),
            'text' => view('component.content.text', ['content' => $content])
        ])

    @endforeach

    @include('component.pagination.default', [
        'collection' => $contents
    ])

@stop
