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

            <div class="col-xs-6 col-sm-3">

                <a href="{{ route('content.show', ['type' => $content->type, 'id' => $content]) }}">

                    @include('components.card', [
                        'image' => $content->user->imagePathOnly(),
                        'title' => $content->user->name,
                        'text' => $content->title,
                    ])

                </a>

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

