@extends('layout')

@section('title')
{{ $title }}
@stop

@section('action.secondary')
    @include('component.placeholder', ['text' => 'Filters ▾'])
@stop

@section('action.primary')
    @include('component.placeholder', ['text' => '＋ Add new travelmate ad'])
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-xs-6 col-sm-3">

                <a href="/content/{{ $content->id }}">

                    @include('component.card', [
                        'image' => $content->user->imagePathOnly(),
                        'title' => null,
                        'subtitle' => $content->user->name,
                        'text' => $content->title,
                    ])

                </a>

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

