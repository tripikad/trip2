@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-3">

                @include('image.square', ['image' => $content->user->imagePath()])
                
                <h4>{{ $content->title }}</h4>
                
                @include('destination.index', ['destinations' => $content->destinations])
                @include('topic.index', ['topics' => $content->topics])

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

