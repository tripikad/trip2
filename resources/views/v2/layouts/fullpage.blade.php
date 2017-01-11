@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$content = $content ? collect($content) : collect();

@endphp

@extends('v2.layouts.main')

@section('title', $title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('content')

    @foreach ($content as $content_item)
                    
        {!! $content_item !!}
                    
    @endforeach

@endsection
