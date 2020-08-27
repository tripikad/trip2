@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$promobar = $promobar ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$content = $content ? collect($content) : collect();
$sidebar = $sidebar ? collect($sidebar) : collect();
$bottom1 = isset($bottom1) ? collect($bottom1) : collect();
$bottom2 = isset($bottom2) ? collect($bottom2) : collect();
$bottom3 = isset($bottom3) ? collect($bottom3) : collect();
$footer = $footer ?? '';

@endphp

@extends('layouts.main')

@section('title', $title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('promobar', $promobar)

@section('header')
    {!! $header !!}
@stop

@section('content')

    {{-- Top --}}

    <div class="margin-top-negative-md">
        
        <div class="container-lg">

            <div class="row padding-bottom-sm justify-content-md-center">

                <div class="col-10 mx-auto">

                    @foreach ($top as $top_item)
                    
                        <div @if (!$loop->last) class="margin-bottom-sm" @endif>

                            {!! $top_item !!}

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- Content and sidebar --}}

    <div class="padding-top-md padding-bottom-lg">

        <div class="container-lg">

            <div class="row justify-content-md-center px-sm-4 px-md-0">

                <div class="col-md-7 col-12">

                @foreach ($content as $content_item)
                
                    <div @if (!$loop->last) class="margin-bottom-md" @endif>

                        {!! $content_item !!}
                            
                    </div>
                        
                @endforeach

                </div>

                <div class="col-md-3 col-12 d-none d-sm-block padding-top-none-mobile-md">

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

    <div class="padding-top-md-mobile-none padding-bottom-md">

        <div class="container-lg">

            <div class="row">

                <div class="col-12 mx-auto justify-content-md-center">

                    @foreach ($bottom1 as $bottom_item)

                        <div @if (!$loop->last) class="margin-bottom-lg" @endif>

                            {!! $bottom_item !!}

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>


    {{-- shortNews --}}

    <div class="padding-top-md-mobile-none padding-bottom-md">

        <div class="container-lg">

            <div class="row">

                <div class="col-12 mx-auto">

                    @foreach ($shortNews as $news)

                        <div @if (!$loop->last) class="margin-bottom-lg" @endif>

                            {!! $news !!}

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

        <div class="container-lg">

            <div class="row">

                <div class="col-12 mx-auto">

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

@section('footer')
    {!! $footer !!}
@stop
