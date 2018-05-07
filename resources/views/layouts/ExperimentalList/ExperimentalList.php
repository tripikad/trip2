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

@section('content')

    @foreach ($content_groups as $content_group)
                    
        <div class="ExperimentalList__contentGroup">

            @foreach ($content_group as $content_item)
                    
                <div class="ExperimentalList__contentItem">

                    {!! $content_item !!}

                </div>
            
            @endforeach
                
        </div>

    @endforeach   
                                    
@stop