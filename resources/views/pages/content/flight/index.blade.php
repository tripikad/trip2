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

@section('content')

    <div class="utils-padding-bottom">

        @include('component.filter')

    </div>

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-xs-8 col-sm-4">

                <a href="{{ route('content.show', ['type' => $content->type, 'id' => $content]) }}">

                    @include('component.card', [
                        'image' => $content->imagePreset(),
                        'title' => $content->price ? trans("content.flight.index.field.price", [
                            'price' => $content->price,
                            'symbol' => config('site.currency.symbol')
                        ]) : null,
                        'text' => str_limit($content->title, 45)
                            . '<br />'
                            . view('component.date.relative', ['date' => $content->end_at]),
                        'options' => '-center'
                    ])
                
                </a>

            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

