@php

$title = $title ?? '';
$head_title = $head_title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
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

@section('color', $color)
@section('background')
{!! $background !!}
@endsection

@section('header')

<header class="One__header">

    {!! $header !!}

    @if ($top->count())

    <div class="One__top">

        @foreach ($top as $top_item)

        <div class="One__topItem">

            {!! $top_item !!}

        </div>

        @endforeach

    </div>

    @endif

</header>

@endsection

@section('content')

<div class="One__outerWrapper">

    <div class="One__innerWrapper">

        <div class="One__contentTop">

            {!! $content_top !!}

        </div>

        @if ($content->count())

        <main class="One__content">

            @foreach ($content as $content_item)

            <div class="One__contentItem">

                {!! $content_item !!}

            </div>

            @endforeach

        </main>

        @endif

        @if ($bottom->count())

        <section class="One__bottom">

            @foreach ($bottom as $bottom_item)

            <div class="One__bottomItem">

                {!! $bottom_item !!}

            </div>

            @endforeach

        </section>

        @endif

    </div>

</div>

@endsection

@section('footer')

<footer class="One__footer">

    {!! $footer !!}

</footer>

@endsection