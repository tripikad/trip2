@php

$title = $title ?? '';
$head_title = $head_title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$top = isset($top) ? collect($top) : collect();
$content = isset($content) ? collect($content) : collect();
$sidebar = isset($sidebar) ? collect($sidebar) : collect();
$bottom = isset($bottom) ? collect($bottom) : collect();
$footer = $footer ?? '';
$narrow = $narrow ?? false;

@endphp

@extends('v2.layouts.main')

@section('title', $title)
@section('head_title', $head_title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('color', $color)
@section('background', $background)

@section('header')

<header class="position-relative">

    {!! $header !!}

    @if ($top->count())

    <div class="background-gray">

    @foreach ($top as $top_item)

        {!! $top_item !!}
            
    @endforeach

    </div>

    @endif

</header>

@endsection

@section('content')

<section class="position-relative">

    @if ($content->count())

    <div class="background-white">

        <div class="container">

            <div class="row-between padding-top-xl-mobile-md padding-left-xl-tablet-none  padding-bottom-xl-mobile-md padding-right-xl-tablet-none">

                <div class="@if ($narrow) col-7 @else col-9 @endif padding-right-md-mobile-none">

                    @foreach ($content as $content_item)
                    
                    <div @if (! $loop->last) class="margin-bottom-md" @endif>

                        {!! $content_item !!}
                            
                    </div>

                    @endforeach

                </div>

                <div class="@if ($narrow) col-5 @else col-3 @endif padding-left-md-mobile-none padding-top-none-mobile-md">

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

</section>

@endif

@endsection

@section('footer')

    <footer class="background-white">

    {!! $footer !!}

    </footer>

@endsection