@extends('layouts.one_column')

@section('title')
    {{ trans('admin.content.index.title') }}
@stop

@section('header2.content')

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
                'route' => route('user.show', [$content->user])
            ],
            'title' => $content->title,
            'route' => route('content.show', [$content->type, $content->id]),
            'text' => view('component.content.text', ['content' => $content])
        ])

    @endforeach

    @include('component.pagination',
        ['collection' => $contents]
    )

@stop
