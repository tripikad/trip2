@extends('layout')

@section('title')
{{ $title }}
@stop

@section('action.secondary')
    @include('component.placeholder', ['text' => 'Filters ▾'])
@stop

@section('action.primary')
    @include('component.placeholder', ['text' => '＋ Add new flight offer'])
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-xs-6 col-sm-3">

                <a href="/content/{{ $content->id }}">

                    @include('component.card', [
                        'title' => null,
                        'subtitle' => $content->title,

                    ])
                
                </a>

                {{--
                @include('carrier.index', ['carriers' => $content->carriers])
                @include('destination.index', ['destinations' => $content->destinations])
                --}}

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

