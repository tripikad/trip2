@extends('layouts.main')

@section('title')
    
    {{ trans("content.$type.index.title") }}

@stop

@section('header1.right')
    @include('component.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('navbar.bottom')

    <div class="utils-padding-bottom">
            
        @include('component.menu', [
            'menu' => 'news',
            'items' => config('menu.news')
        ])
        
    </div>

@stop

@section('content')

    <div class="utils-padding-bottom">

        @include('component.filter')

    </div>

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4">

                <a href="{{ route('content.show', ['type' => $content->type, 'id' => $content]) }}">

                    @include('component.card', [
                        'image' => $content->imagePreset('small'),
                        'text' => $content->title,
                    ])

                </a>

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop