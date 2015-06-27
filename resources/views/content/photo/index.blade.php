@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4">

                @include('image.landscape', ['image' => $content->imagePath()])

                <h4>{{ $content->title }}</h4>
                
                @include('destination.index', ['destinations' => $content->destinations])

            </div>

            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

