@php

$title = $title ?? '';
$head_title = $head_title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$head_image_width = $head_image_width ?? '';
$head_image_height = $head_image_height ?? '';
$head_robots = $head_robots ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$top = isset($top) ? collect($top) : collect();
$content_top = $content_top ?? '';
$content = isset($content) ? collect($content) : collect();
$bottom = isset($bottom) ? collect($bottom) : collect();
$footer = $footer ?? '';

@endphp

@extends('layouts.main')

@section('title', $title)
@section('head_title', $head_title)
@section('head_description', $head_description)
@section('head_image', $head_image)
@section('head_image_width', $head_image_width)
@section('head_image_height', $head_image_height)
@section('head_robots', $head_robots)

@section('color', $color)

@section('background')

{!! $background !!}

@endsection

@section('content')

<div>

    @foreach (items($items ?? []) as $item)

    {!! $item !!}

    @endforeach

</div>

@endsection