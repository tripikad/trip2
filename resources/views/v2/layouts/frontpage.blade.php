@php

$header = $header ?? '';
$content_first = $content_first ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="container">

        @foreach ($content_first as $content_first_item)
        
        {!! $content_first_item !!}
                
        @endforeach

    </div>

    @foreach ($bottom as $bottom_item)
    
    {!! $bottom_item !!}
            
    @endforeach
    
@endsection

@section('footer', $footer)
