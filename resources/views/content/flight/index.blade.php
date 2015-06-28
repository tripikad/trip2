@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4">
                <div style="background: #eee; height: 140px; padding: 10px; margin-bottom: 1.5em;">
                <h4>{{ $content->title }}</h4>
                
                @include('carrier.index', ['carriers' => $content->carriers])
                @include('destination.index', ['destinations' => $content->destinations])
                </div>
            </div>

            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

