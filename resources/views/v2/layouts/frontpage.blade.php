@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$promobar = $promobar ?? '';
$header = $header ?? '';
$content = $content ? collect($content) : collect();
$sidebar = $sidebar ? collect($sidebar) : collect();
$bottom1 = isset($bottom1) ? collect($bottom1) : collect();
$bottom2 = isset($bottom2) ? collect($bottom2) : collect();
$bottom3 = isset($bottom3) ? collect($bottom3) : collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('title', $title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('promobar', $promobar)

@section('header', $header)

@section('content')

    {{-- Top --}}

    <div class="margin-top-negative-md">
        
        <div class="container">

            <div class="row row-center padding-bottom-md">

                <div class="col-10">

                    @foreach ($top as $top_item)
                    
                    <div @if (!$loop->last) class="margin-bottom-md-mobile-sm" @endif>

                        {!! $top_item !!}
                            
                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- Content and sidebar --}}

    <div class="padding-top-lg padding-bottom-lg">

        <div class="container">

            <div class="row row-center">

                <div class="col-7 padding-right-sm-mobile-none">

                @foreach ($content as $content_item)
                
                    <div @if (!$loop->last) class="margin-bottom-md" @endif>

                        {!! $content_item !!}
                            
                    </div>
                        
                @endforeach

                </div>

                <div class="col-3 padding-top-none-mobile-md padding-left-sm-mobile-none">

                @foreach ($sidebar as $sidebar_item)
                
                    <div @if (!$loop->last) class="margin-bottom-md" @endif>

                        {!! $sidebar_item !!}
                            
                    </div>
                        
                @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- Bottom 1 --}}

    <div class="padding-top-lg padding-bottom-lg">

        <div class="container">

            <div class="row row-center">

                <div class="col-10">

                @foreach ($bottom1 as $bottom_item)
                
                    <div @if (!$loop->last) class="margin-bottom-lg" @endif>

                        {!! $bottom_item !!}
                            
                    </div>
                        
                @endforeach

                </div>

            </div>

        </div>

    </div>


    {{-- Bottom 2 --}}

    @foreach ($bottom2 as $bottom_item)
    
        {!! $bottom_item !!}
                            
    @endforeach

    {{-- Bottom 3 --}}

    <div class="background-gray padding-top-lg padding-bottom-md">

        <div class="container">

            <div class="row row-center">

                <div class="col-10">

                @foreach ($bottom3 as $bottom_item)
                
                    <div @if (!$loop->last) class="margin-bottom-lg" @endif>

                        {!! $bottom_item !!}
                            
                    </div>
                        
                @endforeach

                </div>

            </div>

        </div>

    </div>
        
@endsection

@section('footer', $footer)


