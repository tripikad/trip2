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

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4">

                <a href="{{ route('content.show', ['type' => $content->type, 'id' => $content]) }}">

                    @include('components.card', [
                        'image' => $content->imagePath(),
                        'title' => $content->title,
                    ])

                </a>

            </div>

            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop