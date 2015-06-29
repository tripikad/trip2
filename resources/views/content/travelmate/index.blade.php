@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-3">

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

