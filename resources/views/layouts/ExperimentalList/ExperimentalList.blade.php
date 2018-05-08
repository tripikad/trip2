@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$promobar = $promobar ?? '';
$color = $color ?? '';
$background = $background ?? '';
$head_title = $head_title ?? '';

$content = $content ?? collect();

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

    @foreach ($content as $content_item)
                    
        <div class="ExperimentalList__contentItem">

            {!! $content_item !!}

        </div>
            
    @endforeach
                                    
@stop