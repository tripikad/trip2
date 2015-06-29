@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4" style="margin-bottom: 1.5em;">

                @include('image.landscape', ['image' => $content->imagePath()])

            </div>
            
            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

