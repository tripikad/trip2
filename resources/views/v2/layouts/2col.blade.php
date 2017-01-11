@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$header = $header ?? '';
$top = isset($top) ? collect($top) : collect();
$content = isset($content) ? collect($content) : collect();
$sidebar = isset($sidebar) ? collect($sidebar) : collect();
$bottom = isset($bottom) ? collect($bottom) : collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('title', $title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('header', $header)

@section('content')

@if ($top->count())

    <div class="background-gray">

    @foreach ($top as $top_item)

        {!! $top_item !!}
            
    @endforeach

    </div>

@endif

<div class="background-white">

    <div class="container">

        <div class="row-between padding-top-xl-mobile-md padding-left-xl-tablet-none  padding-bottom-xl-mobile-md padding-right-xl-tablet-none">

            <div class="col-9 padding-right-md-mobile-none">

                @foreach ($content as $content_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </div>

            <div class="col-3 padding-left-md-mobile-none padding-top-none-mobile-md">

                @foreach ($sidebar as $sidebar_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $sidebar_item !!}
                        
                </div>

                @endforeach

            </div>

        </div>

    </div>

    @if ($bottom->count())

    <div class="padding-top-lg padding-bottom-lg background-gray">

        <div class="container">

        @foreach ($bottom as $bottom_item)
        
            <div @if (! $loop->last) class="margin-bottom-md" @endif>

                {!! $bottom_item !!}
                    
            </div>
                
        @endforeach

        </div>

    </div>

    @endif

</div>

@endsection

@section('footer', $footer)
