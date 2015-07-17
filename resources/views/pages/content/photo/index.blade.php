@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header.right')
    @include('components.buttonn', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')

    @include('components.filter')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4" style="margin-bottom: 14px;">

                <a href="{{ route('content.show', [$content->type, $content]) }}">
                    
                    @include('components.image.landscape', [
                        'image' => $content->imagePath(),
                    ])
                
                </a>

            </div>
            
            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

