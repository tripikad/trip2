@php

$promobar = $promobar ?? '';
$header = $header ?? '';
$content = $content ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('promobar', $promobar)

@section('header', $header)

@section('content')

    {{-- Top --}}

    <div class="margin-top-negative-md">
        
        <div class="container">

            <div class="row row-center padding-bottom-md">

                <div class="col-10">

                    @foreach ($top as $top_item)
                    
                    <div @if (!$loop->last) class="margin-bottom-lg" @endif>

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
                
                    <div @if (!$loop->last) class="margin-bottom-lg" @endif>

                        {!! $content_item !!}
                            
                    </div>
                        
                @endforeach

                </div>

                <div class="col-3 padding-top-none-mobile-md padding-left-sm-mobile-none">

                @foreach ($sidebar as $sidebar_item)
                
                    <div @if (!$loop->last) class="margin-bottom-lg" @endif>

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

    <div class="background-gray padding-top-lg padding-bottom-lg">

        <div class="container">

            <div class="row row-center">

                <div class="col-10">

                @foreach ($bottom2 as $bottom_item)
                
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


