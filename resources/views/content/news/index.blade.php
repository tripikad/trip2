@extends('layout')

@section('title')
{{ $title }}
@stop

@section('action.secondary')
    @include('component.placeholder', ['text' => 'Filters ▾'])
@stop

@section('action.primary')
    @include('component.placeholder', ['text' => '＋ Add new news item'])
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4">

                    @include('component.card', [
                        'image' => $content->imagePath(),
                        'title' => $content->title,
                    ])

            </div>

            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

