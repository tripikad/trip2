@extends('layouts.twocol')

@section('title')
    
    {{ trans("content.$type.index.title") }}

@stop

@section('header1.right')
    
    @include('component.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])

@stop

@section('header4')
    
    <div class="utils-border-bottom">

        @include('component.filter')

    </div>

@stop

@section('content.left')

    @foreach ($contents as $index => $content)

        <div class="utils-padding-bottom">
        
        @include('component.row', [
            'heading' => $content->title,
            'description' => view('component.date.short', [
                'date' => $content->end_at
            ]),
            'extra' => $content->price
                ? trans("content.flight.index.field.price", [
                    'price' => $content->price,
                    'symbol' => config('site.currency.symbol')
            ]) : null,
        ])

        </div>

    @endforeach

    {!! $contents->render() !!}

@stop

