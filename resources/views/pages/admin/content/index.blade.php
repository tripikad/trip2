@extends('layouts.one_column')

@section('title')
    {{ trans('admin.content.index.title') }}
@stop

@section('header2.content')

    @include('component.nav', [
        'menu' => 'admin',
        'items' => config('menu.admin')
    ])

@stop

@section('content.one')

    @foreach ($contents as $content)

        <div class="utils-border-bottom utils-unpublished">

        @include('component.row', [
            'profile' => [
                'image' => $content->user->imagePreset(),
                'route' => route('user.show', [$content->user])
            ],
            'title' => $content->title,
            'route' => route('content.show', [$content->type, $content->id]),
            'text' => view('component.content.text', ['content' => $content])
        ])

        </div>

    @endforeach

  {!! $contents->render() !!}

@stop
