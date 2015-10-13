@extends('layouts.main')

@section('title', 'Styleguide')

@section('content')

<div class="component-styleguide">

@if (count($components)) 

    @foreach($components as $component)

        <mark>{{ $component['title'] }}</mark>

        <div class="row">

            <div class="col-md-6">

                <p>{!! $component['description'] !!}</p>
                
                <pre>{{ str_replace('@', '&#64;', htmlentities($component['code'])) }}</pre>
                        
            </div>

            <div class="col-md-5 col-md-offset-1">

                {!! \StringView::make([
                    'template' => $component['code'],
                    'cache_key' => str_random(10),
                    'updated_at' => 0
                ]) !!}

            </div>

        </div>

    @endforeach

@endif

@stop