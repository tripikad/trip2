@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-3">

                <div style="margin: 1em 0;">
                    @include('image.square', ['image' => $content->user->imagePath()])
                </div>

                <a href="content/{{ $content->id }}"><h5>{{ $content->title }}</h5></a>
                
                <p>
                    @include('destination.index', ['destinations' => $content->destinations])
                    @include('topic.index', ['topics' => $content->topics])
                </p>
            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

