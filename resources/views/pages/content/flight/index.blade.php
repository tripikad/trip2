@extends('layouts.main')

@section('title')
{{ $title }}
@stop

@section('action.secondary')
    @include('components.placeholder', ['text' => 'Filters ▾'])
@stop

@section('action.primary')
    <a class="btn btn-default btn-block" href="/content/flight/create">＋ Add new flight offer</a>
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-xs-6 col-sm-3">

                <a href="/content/{{ $content->id }}">

                    @include('components.card', [
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

