@extends('layouts.main')

@section('title')
{{ $title }}
@stop

@section('action.secondary')
    @include('components.placeholder', ['text' => 'Filters ▾'])
@stop

@section('action.primary')
    <a class="btn btn-default btn-block" href="/content/photo/create">＋ Add photo</a>
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4">

                @include('components.card', [
                    'image' => $content->imagePath(),
                    'title' => null
                ])

            </div>
            
            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

