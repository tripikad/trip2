@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$promobar = $promobar ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$head_title = $head_title ?? '';

$contentA = isset($contentA) ? collect($contentA) : collect();
$contentB = isset($contentB) ? collect($contentB) : collect();

$footer = $footer ?? '';

@endphp

@extends('layouts.main')

@section('title', $title)
@section('head_description', $head_description)
@section('head_image', $head_image)
@section('color', $color)
@section('background')
    {!! $background !!}
@endsection
@section('promobar', $promobar)

@section('header')

    {!! $header !!}

@endsection

@section('content')

    <div class="ExperimentalFrontpage__outerWrapper">

        <div class="ExperimentalFrontpage__innerWrapper">

        @if ($contentA->isNotEmpty())

            <section class="Frontpage__contentA">

                <div class="container-narrow">

                    @foreach ($contentA as $contentA_item)
                    
                        <div class="Frontpage__contentAItem">

                            {!! $contentA_item !!}
                                
                        </div>
                            
                    @endforeach

                </div>
                
            </section>

        @endif

        @if ($contentB->isNotEmpty())

            <section class="Frontpage__contentB">

                <div class="container">

                    @foreach ($contentB as $contentB_item)
                    
                        <div class="Frontpage__contentBItem">

                            {!! $contentB_item !!}
                                
                        </div>
                            
                    @endforeach

                </div>
                
            </section>

        @endif

        </div>
    
    </div>

@endsection

@section('footer')

    {!! $footer !!}

@stop