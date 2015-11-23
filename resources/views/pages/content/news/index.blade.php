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
        'modifiers' => '',
        'menu' => 'news',
        'items' => config('menu.news')
    ])

@stop

@section('header3.content')

    @include('component.filter')

@stop

@section('content.one')

    <div class="row">

        @foreach ($contents as $index => $content)

            <div class="col-sm-3">

                <a href="{{ route('content.show', ['type' => $content->type, 'id' => $content]) }}">

                    @include('component.card', [
                        'image' => $content->imagePreset('small'),
                        'text' => $content->title,
                    ])

                </a>

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    @include('component.pagination',
        ['collection' => $contents]
    )

@stop