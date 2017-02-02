
@php

$title = $title ?? '';
$head_title = $head_title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$top = isset($top) ? collect($top) : collect();
$content_top = $content_top ?? '';
$content = isset($content) ? collect($content) : collect();
$bottom = isset($bottom) ? collect($bottom) : collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('title', $title)
@section('head_title', $head_title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('color', $color)
@section('background', $background)

@section('header')

<div class="position-relative">

{!! $header !!}

</div>

@endsection

@section('content')

<div class="position-relative">

    <div class="container">

        @if ($top->count())

        <div class="row row-center padding-bottom-md">

            <div class="col-7">

                @foreach ($top as $top_item)
                
                    {!! $top_item !!}
                        
                @endforeach

            </div>

        </div>

        @endif

        <div class="row row-center padding-top-lg padding-bottom-lg">

            <div class="col-5 background-white">

                {!! $content_top !!}

                @if ($content->count())

                <div class="padding-lg-mobile-md">
                    
                @foreach ($content as $content_item)
                    
                    <div>

                    {!! $content_item !!}
                    
                    </div>

                @endforeach

                </div>

                @endif
                
            </div>

        </div>

        @if ($bottom->count())

        <div class="align-center padding-bottom-lg">

            @foreach ($bottom as $bottom_item)
            
                {!! $bottom_item !!}
                    
            @endforeach

        </div>

        @endif

    </div>

</div>

@endsection

@section('footer')

<div class="background-white">

{!! $footer !!}

</div>

@endsection